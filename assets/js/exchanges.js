$(document).ready(function () {

    if ($("#exchanges_tbl").length) {

        var exchanges_tbl = $("#exchanges_tbl");
        exchanges_tbl.on('preXhr.dt', function (e, settings, data) {
            //.name,.title,.server,.searcher.,.status
            // data.name = $('.name').val();
            data.type_id = $('#type_id').val();
            data.color_id = $('#color_id').val();
            data.size_id = $('#size_id').val();
            data.category_id = $('#category_id').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: baseURL + "/exchanges-data"
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#exchanges_tbl_processing').hide();
                        bootbox.alert(json.message);
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'type.name', name: 'type.name'},
                {data: 'price', name: 'price'},
                {data: 'category.name', name: 'category.name'},
                {data: 'color.name', name: 'color.name'},
                {data: 'size.name', name: 'size.name'},
                {data: 'description', name: 'description'},
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
    if ($("#exchange_requests_tbl").length) {

        var exchange_requests_tbl = $("#exchange_requests_tbl");
        exchange_requests_tbl.on('preXhr.dt', function (e, settings, data) {
            //.name,.title,.server,.searcher.,.status
            // data.name = $('.name').val();
            data.name = $('#name').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: baseURL + "/exchange-requests-data"
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#exchanges_tbl_processing').hide();
                        bootbox.alert(json.message);
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'idno', name: 'idno'},
                {data: 'name', name: 'name'},
                {data: 'mobile', name: 'mobile'},
                {data: 'city_name', name: 'city_name'},
                {data: 'device_image', name: 'device_image'},
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

    $(document).on('click', '.delete', function (event) {

        var _this = $(this);
        var action = _this.attr('href');
        event.preventDefault();
        var constant_name = _this.closest('tr').find("td:eq(1)").text();

        bootbox.dialog({
            message: "هل انت متأكد من حذف (" + constant_name + ")؟ <span class='label label-danger'> لا يمكن التراجع عن العملية</span>",
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
                                    exchanges_tbl.api().ajax.reload();
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
        if ($("#exchanges_tbl").length)
            exchanges_tbl.api().ajax.reload();
        else
            exchange_requests_tbl.api().ajax.reload();

    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input,select').val('');
        // $('#is_admin_confirm,.status').val('').trigger('change');

        if ($("#exchanges_tbl").length)
            exchanges_tbl.api().ajax.reload();
        else
            exchange_requests_tbl.api().ajax.reload();
    });

    $(document).on('change', '#category_id', function (e) {
        e.preventDefault();

        var _this = $(this);
        var cat_id = $(this).val();
        $.ajax({
            url: baseURL + '/types/' + cat_id,
            type: 'GET',
            success: function (data) {
                _this.closest('form').find('#type_id').html(data);
            }, error: function (xhr) {

            }
        });
    });
    $(document).on('click', '.add-exchange-mdl', function (e) {
        e.preventDefault();
        $("#wait_msg,#overlay").show();
        var action = $(this).attr('href');

        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#add-exchange').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });
    // $(document).on('click', '.add-exchange-request-mdl', function (e) {
    //     e.preventDefault();
    //     $("#wait_msg,#overlay").show();
    //     var action = $(this).attr('href');
    //
    //     $.ajax({
    //         url: action,
    //         type: 'GET',
    //         success: function (data) {
    //             $("#wait_msg,#overlay").hide();
    //
    //             $('#results-modals').html(data);
    //             $('#add-exchange').modal('show', {backdrop: 'static', keyboard: false});
    //         }, error: function (xhr) {
    //
    //         }
    //     });
    // });

    $(document).on('click', '.edit-exchange-mdl', function (e) {
        $("#wait_msg,#overlay").show();
        e.preventDefault();
        var action = $(this).attr('href');
        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#edit-exchange').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });

    $(document).on('click', '.edit-exchange-request-mdl', function (e) {
        $("#wait_msg,#overlay").show();
        e.preventDefault();
        var action = $(this).attr('href');
        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#exchange_request_frm').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });
    $(document).on('click', '.add-exchange-request-mdl', function (e) {
        $("#wait_msg,#overlay").show();
        e.preventDefault();
        var action = $(this).attr('href');
        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#exchange_request_frm').modal('show', {backdrop: 'static', keyboard: false});
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
                    exchanges_tbl.api().ajax.reload();
                    if (event.target.id == 'formAdd') {
                        empty_frm(event.target);
                    }
                } else {
                    var $errors = '<strong>' + data.message + '</strong>';
                    // $errors += '<ul>';
                    // $.each(data.items, function (i, v) {
                    //     $errors += '<li>' + v.message + '</li>';
                    // });
                    // $errors += '</ul>';
                    $('.alert').show();
                    $('.alert').html($errors);
                    // toastr['error'](data.message);
                }
                _this.find('.btn.save i').removeClass('fa-spinner fa-spin');
                // _this.find('.fa-spin').hide();

            }
        });
    });

})
;