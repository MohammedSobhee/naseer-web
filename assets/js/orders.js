$(document).ready(function () {

    if ($("#orders_tbl").length) {

        var orders_tbl = $("#orders_tbl");
        orders_tbl.on('preXhr.dt', function (e, settings, data) {
            //.name,.title,.server,.searcher.,.status
            // data.name = $('.name').val();
            data.customer_name = $('#customer_name').val();
            data.status = $('#status').val();
            data.payment_method = $('#payment_method').val();
            data.city_id = $('#city_id').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: baseURL + "/orders-data"
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#orders_tbl_processing').hide();
                        bootbox.alert(json.message);
                        //
                    } else
                        return json.data;
                }
            },
            // `name`, `description`, `price`, `is_offer`, `offer_price`, `category_id`, `quantity`, `color_id`, `size_id`
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {data: 'customer.name', name: 'customer.name'},
                {data: 'status', name: 'status'},
                {data: 'city.name', name: 'city.name'},
                {data: 'payment_method', name: 'payment_method'},
                {data: 'delivery_price', name: 'delivery_price'},
                {data: 'extra_fee', name: 'extra_fee'},
                {data: 'total_price', name: 'total_price'},
                {data: 'created_at', name: 'created_at'},
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

    // $(document).on('click', '.order-view', function (event) {
    //     event.preventDefault();
    //     $('.loader').show();
    //     $('#order-products').modal('show');
    //     var action = $(this).attr('href');
    //     $('.orderNo').text($(this).closest('tr').find("td:eq(1)").text());
    //     $('.customerName').text($(this).closest('tr').find("td:eq(2)").text());
    //     $('.orderDate').text($(this).closest('tr').find("td:eq(9)").text());
    //     $.ajax({
    //         url: action,
    //         type: 'GET',
    //         // dataType:'json',
    //         success: function (data) {
    //             $('.loader').hide();
    //             $('#product-table tbody').html(data);
    //         }, error: function (xhr) {
    //
    //         }
    //     });
    // });

    $(document).on('click', '.order-view', function (e) {
        e.preventDefault();
        $("#wait_msg,#overlay").show();
        var action = $(this).attr('href');

        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#order-products').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });
    $(document).on('click', '.delete', function (event) {

        var _this = $(this);
        var action = _this.attr('href');
        event.preventDefault();
        var constant_name = _this.closest('tr').find("td:eq(1)").text();

        bootbox.dialog({
            message: "هل انت متأكد من حذف الطلب رقم:(" + constant_name + ")؟ <span class='label label-danger'> لا يمكن التراجع عن العملية</span>",
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
                                    orders_tbl.api().ajax.reload();
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
        orders_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input,select').val('');
        // $('#is_admin_confirm,.status').val('').trigger('change');
        orders_tbl.api().ajax.reload();
    });

    $(document).on('click', '.add-order-mdl', function (e) {
        e.preventDefault();
        $("#wait_msg,#overlay").show();
        var action = $(this).attr('href');

        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#add-order').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });

    $(document).on('click', '.edit-order-mdl', function (e) {
        $("#wait_msg,#overlay").show();
        e.preventDefault();
        var action = $(this).attr('href');
        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#edit-order').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });
    $(document).on('click', '.bank-transfer', function (e) {
        $("#wait_msg,#overlay").show();
        e.preventDefault();
        var action = $(this).attr('href');
        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#bank_transfer_frm').modal('show', {backdrop: 'static', keyboard: false});
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
                    orders_tbl.api().ajax.reload();
                    if (event.target.id == 'formAdd') {
                        empty_frm(event.target);
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
                    toastr['error'](data.message);
                }
                _this.find('.btn.save i').removeClass('fa-spinner fa-spin');
                // _this.find('.fa-spin').hide();

            }
        });
    });

    $(document).on('change', '.status', function (event) {

        var _this = $(this);
        var order_id = _this.data('id');
        event.preventDefault();
        $.ajax({
            url: baseURL + '/orders/status',
            type: 'PUT',
            dataType: 'json',
            data: {'_token': csrf_token, 'order_id': order_id, 'status': _this.val()},
            success: function (data) {

                if (data.status) {
                    $('.alert').hide();
                    toastr['success'](data.message, '');
                    orders_tbl.api().ajax.reload();

                } else {
                    toastr['error'](data.message);
                }

            }
        });

    });

})
;