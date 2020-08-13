$(document).ready(function () {

    if ($("#sponsors_tbl").length) {

        var sponsors_tbl = $("#sponsors_tbl");
        sponsors_tbl.on('preXhr.dt', function (e, settings, data) {
            data.title = $('#title').val();
            data.media_type = $('#media_type').val();
            data.status = $('#status').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: baseURL + "/sponsors/sponsor-data"

                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#users_tbl_processing').hide();
                        bootbox.alert(json.message);
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'title', name: 'title'},
                {data: 'media', name: 'media'},
                {data: 'media_type', name: 'media_type'},
                {data: 'status', name: 'status'},
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
            "searching": false,
            "ordering": false,

            bStateSave: !0,
            lengthMenu: [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]],
            pageLength: 10,
            pagingType: "bootstrap_full_number",
            columnDefs: [{orderable: !1, targets: [0]}, {searchable: !1, targets: [0]}, {className: "dt-right"}],
            order: [[2, "asc"]]
        });
    }
    $(document).on('change', '.status', function (event) {

        var _this = $(this);
        var sponsor_id = _this.data('id');
        event.preventDefault();
        $.ajax({
            url: baseURL + '/change-status-sponsor/' + sponsor_id,
            type: 'PUT',
            dataType: 'json',
            data: {'_token': csrf_token},
            success: function (data) {

                if (data.status) {
                    $('.alert').hide();
                    toastr['success'](data.message, '');
                    sponsors_tbl.api().ajax.reload();

                }
                else {
                    toastr['error'](data.message);
                }

            }
        });

    });
    $(document).on('click', '.delete', function (event) {

        var _this = $(this);
        var action = _this.attr('href');
        event.preventDefault();

        var sponsor_name = _this.closest('tr').find("td:eq(1)").text();
        bootbox.confirm({
            message: "هل انت متأكد من حذف الاعلان :(" + sponsor_name + ")؟",
            buttons: {

                confirm: {
                    label: 'بالتأكيد <i class="fa fa-check"></i>',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'الغاء<i class="fa fa-times"></i>',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    $.ajax({
                        url: action,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {'_token': csrf_token},
                        success: function (data) {

                            if (data.status) {
                                $('.alert').hide();
                                toastr['success'](data.message, '');
                                sponsors_tbl.api().ajax.reload();

                            }
                            else {
                                toastr['error'](data.message);
                            }

                        }
                    });
                }
            }
        });

    });

    $(document).on('click', '.add-post-mdl', function () {
        $("#wait_msg,#overlay").show();

        $.ajax({
            url: baseURL + '/sponsor/create',
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#add-sponsor').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });

    $(document).on('click', '.edit-sponsor-mdl', function (e) {
        $("#wait_msg,#overlay").show();
        e.preventDefault();
        var action = $(this).attr('href');
        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#edit-sponsor').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });

    $(document).on('submit', '#formAdd,#formEdit', function (event) {

        var _this = $(this);
        // var loader = '<i class="fa fa-spinner fa-spin"></i>';
        _this.find('.btn.save i').addClass('fa-spinner fa-spin');
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
                    // if ($(event.target).attr('id') === 'add-league') {
                    //     $('input[type=text]').val('');
                    //     $('input[type=email]').val('');
                    //     $('input[type=password]').val('');
                    //     $('.select2').val(null).trigger('change');
                    //
                    //     // add reset select
                    // }

                    sponsors_tbl.api().ajax.reload();
                    if (event.target.id == 'formAdd') {
                        empty_frm(event.target);
                    }
                }
                else {
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
                _this.find('.btn.save i').removeClass('fa-spinner fa-spin');
                // _this.find('.fa-spin').hide();

            }
        });
    });


    $(document).on("click", ".filter-submit", function () {
//                if ($(this).val().length > 3)
        sponsors_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input,select').val('');
        sponsors_tbl.api().ajax.reload();
    });
})
;