$(document).ready(function () {

    if ($("#coupons_tbl").length) {

        var coupons_tbl = $("#coupons_tbl");
        coupons_tbl.on('preXhr.dt', function (e, settings, data) {
            //.name,.title,.server,.searcher.,.status
            // data.name = $('.name').val();
            data.name = $('#name').val();
            data.start_date = $('#start_date').val();
            data.end_date = $('#end_date').val();
            data.is_complete = $('#is_complete').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,
            "initComplete": function(settings, json) {
                ComponentsClipboard.init();
            },
            "ajax": {
                url: baseURL + "/coupons-data"
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#coupons_tbl_processing').hide();
                        bootbox.alert(json.message);
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'expired_date', name: 'expired_date'},
                {data: 'ratio', name: 'ratio'},
                {data: 'ratio_type', name: 'ratio_type'},
                {data: 'code', name: 'code'},
                {data: 'num_user', name: 'num_user'},
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

    $(document).on('change', '.is_complete', function (event) {

        var _this = $(this);
        var coupon_id = _this.data('id');
        event.preventDefault();
        $.ajax({
            url: baseURL + '/coupon-complete',
            type: 'PUT',
            dataType: 'json',
            data: {'_token': csrf_token, 'coupon_id': coupon_id},
            success: function (data) {

                if (data.status) {
                    $('.alert').hide();
                    toastr['success'](data.message, '');
                    coupons_tbl.api().ajax.reload();

                } else {
                    toastr['error'](data.message);
                }

            }
        });

    });

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
                                    coupons_tbl.api().ajax.reload();
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
        coupons_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input,select').val('');
        // $('#is_admin_confirm,.status').val('').trigger('change');
        coupons_tbl.api().ajax.reload();
    });

    $(document).on('click', '.add-coupon-mdl', function (e) {
        e.preventDefault();
        $("#wait_msg,#overlay").show();
        var action = $(this).attr('href');

        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#add-coupon').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });

    $(document).on('click', '.edit-coupon-mdl', function (e) {
        $("#wait_msg,#overlay").show();
        e.preventDefault();
        var action = $(this).attr('href');
        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#edit-coupon').modal('show', {backdrop: 'static', keyboard: false});
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
                    coupons_tbl.api().ajax.reload();
                    $('#add-coupon').modal('hide');
                    $('#edit-coupon').modal('hide');
                    // if (event.target.id == 'formAdd') {
                    //     empty_frm(event.target);
                    // }
                    bootbox.dialog({
                        message: 'الكود الكابون:' + '<span id="copyId">' + data.items.code + '</span>',
                        title: "الكود الكابون!",
                        buttons: {
                            cancel: {
                                label: '<i class="fa fa-times"></i> اغلاق', className: "red", callback: function () {
                                    bootbox.hideAll();
                                }
                            }
                        }
                    });

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
                _this.find('.btn.save i').removeClass('fa-spinner fa-spin');
                // _this.find('.fa-spin').hide();

            }
        });
    });

});