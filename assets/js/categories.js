$(document).ready(function () {

    if ($("#constants_tbl").length) {

        var constant = $('#constant').val();
        var constants_tbl = $("#constants_tbl");
        constants_tbl.on('preXhr.dt', function (e, settings, data) {

            data.type = $('#cate_type').val();

        }).dataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: baseURL + "/category/" + constant
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#constants_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'image', name: 'image'},
                {data: 'name', name: 'name'},
                // {data: 'type', name: 'type'},
                {data: 'action', name: 'action'}
            ],

            language: {
                "sProcessing": "<img src='" + baseAssets + "/apps/img/preloader.svg'>",
                "sLengthMenu": "أظهر _MENU_ مدخلات",
                "sZeroRecords": "لم يعثر على أية سجلات",
                "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix": "",
                "sSearch": "ابحث:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "الأول",
                    "sPrevious": "السابق",
                    "sNext": "التالي",
                    "sLast": "الأخير"
                }
            },
            // "searching": false,
            // "ordering": false,

            bStateSave: !0,
            lengthMenu: [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]],
            pageLength: 10,
            pagingType: "bootstrap_full_number",
            columnDefs: [{orderable: !1, targets: [0]}, {searchable: !1, targets: [0]}, {className: "dt-right"}],
            order: [[2, "asc"]]
        });

        // Grab the datatables input box and alter how it is bound to events
        $(".dataTables_filter input")
            .unbind() // Unbind previous default bindings
            .bind("input", function (e) { // Bind our desired behavior
                // If the length is 3 or more characters, or the user pressed ENTER, search
                if (this.value.length >= 3 || e.keyCode == 13) {
                    // Call the API search function
                    constants_tbl.api().search(this.value).ajax.reload();

                }
                // Ensure we clear the search if they backspace far enough
                if (this.value == "") {
                    constants_tbl.api().search("").ajax.reload();
                }
            });
    }

    $(document).on('click', '#save', function (event) {

        var _this = $(this);
        var constant_name = $('.constant_name').val();
        var type = $('#type').val();
        var action = _this.attr('href');
        event.preventDefault();
        _this.find('i').addClass('fa-spinner fa-spin');


        $.ajax({
            url: action,
            type: 'POST',
            dataType: 'json',
            data: {'_token': csrf_token, 'constant_name': constant_name, 'type': type},
            success: function (data) {

                if (data.status) {
                    $('.alert').hide();
                    toastr['success'](data.message, '');
                    constants_tbl.api().ajax.reload();

                } else {
                    toastr['error'](data.message);
                }
                _this.find('i').removeClass('fa-spinner fa-spin');
                $('input').not('input[type="hidden"]').val('');
                $('#save_category_frm').attr('action', $('#url_action').val());
            }
        });

    });
    $(document).on('click', '.edit', function (event) {

        var _this = $(this);
        var action = _this.attr('href');
        event.preventDefault();


        $.ajax({
            url: action,
            type: 'GET',
            // dataType: 'json',
            success: function (data) {

                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#edit-category').modal('show', {backdrop: 'static', keyboard: false});
                // if (data.status) {
                //     // $('.constant_name').val(data.items.name);
                //     // $('#type').val(data.items.type);
                //     // $('#save_category_frm').attr('action', action);
                //
                //
                // } else {
                //     toastr['error'](data.message);
                // }
            }
        });

    });
    $(document).on('click', '.delete', function (event) {

        var _this = $(this);
        var action = _this.attr('href');
        event.preventDefault();
        var constant_name = _this.closest('tr').find("td:eq(2)").text();

        bootbox.dialog({
            message: "هل انت متأكد من حذف (" + constant_name + ")? <span class='label label-danger'> لا يمكن التراجع عن العملية</span>",
            title: "تأكيد عملية الحذف!",
            buttons: {

                main: {
                    label: 'بالتأكيد <i class="fa fa-check"></i> ',
                    className: "btn-primary",
                    callback: function () {
                        //do something else
                        $.ajax({
                            url: action,
                            type: 'DELETE',
                            dataType: 'json',
                            data: {_token: csrf_token},
                            success: function (data) {

                                if (data.status) {
                                    toastr['success'](data.message, '');
                                    constants_tbl.api().ajax.reload();
                                } else {
                                    toastr['error'](data.message);
                                }
                            }
                        });
                    }
                }, danger: {
                    label: 'اغلاق <i class="fa fa-remove"></i>',
                    className: "btn-danger",
                    callback: function () {
                        //do something
                        bootbox.hideAll()
                    }
                }
            }
        });


    });

    $(document).on("click", ".filter-submit", function () {
//                if ($(this).val().length > 3)
        constants_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input,select').val('');
        // $('#is_admin_confirm,.status').val('').trigger('change');
        constants_tbl.api().ajax.reload();
    });

    $(document).on('submit', '#save_category_frm,#formEdit', function (event) {

        var _this = $(this);
        // var loader = '<i class="fa fa-spinner fa-spin"></i>';
        _this.find('.save i').addClass('fa-spinner fa-spin');
        event.preventDefault(); // Totally stop stuff happening
        // START A LOADING SPINNER HERE
        // Create a formdata object and add the files

        var formData = new FormData($(this)[0]);

        var action = $(this).attr('action');
        var method = $(this).attr('method');

        $.ajax({
            url: action,
            type: method,
            data: formData,

            contentType: false,
            processData: false,
            success: function (data) {

                if (data.status) {

                    $('.alert').hide();
                    toastr['success'](data.message, '');
                    constants_tbl.api().ajax.reload();

                    if (event.target.id != 'formEdit') {
                        $('input').not('input[type="hidden"]').val('');
                        $('select').val(0);
                    }else{
                        $('#edit-category').modal('hide');

                    }

                } else {
                    var $errors = '<strong>' + data.message + '</strong>';
                    $errors += '<ul>';
                    $.each(data.errors, function (i, v) {
                        $errors += '<li>' + v.message + '</li>';
                    });
                    $errors += '</ul>';
                    $('.alert').show();
                    $('.alert').html($errors);
                    // toastr['error'](data.message);
                }
                _this.find('.btn i').removeClass('fa-spinner fa-spin');
                // _this.find('.fa-spin').hide();
                // $('#save_category_frm').attr('action', $('#url_action').val());
            }
        });
    });

});
