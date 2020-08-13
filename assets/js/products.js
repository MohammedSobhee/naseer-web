$(document).ready(function () {

    if ($("#products_tbl").length) {

        var products_tbl = $("#products_tbl");
        products_tbl.on('preXhr.dt', function (e, settings, data) {

            data.name = $('#name').val();
            data.is_offer = $('#is_offer').val();
            data.category_id = $('#category_id').val();
            data.size_id = $('#size_id').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: baseURL + "/products-data"
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#products_tbl_processing').hide();
                        bootbox.alert(json.message);
                        //
                    } else
                        return json.data;
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'price', name: 'price'},
                {data: 'is_offer', name: 'is_offer'},
                {data: 'offer_type', name: 'offer_type'},
                {data: 'offer_percentage', name: 'offer_percentage'},
                {data: 'quantity', name: 'quantity'},
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
    $(document).on('click', '.delete-product-image', function (event) {

        var _this = $(this);
        var action = _this.attr('data-url');
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
                                    _this.closest('tr').remove();

                                } else {
                                    toastr['error'](data.message);
                                }
                            }
                        });
                    }
                }, danger: {
                    label: 'Close <i class="fa fa-remove"></i>',
                    className: "btn-danger",
                    callback: function () {
                        //do something
                        bootbox.hideAll()
                    }
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
                                    products_tbl.api().ajax.reload();
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
        products_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input,select').val('');
        // $('#is_admin_confirm,.status').val('').trigger('change');
        products_tbl.api().ajax.reload();
    });

    $(document).on('change', '#is_offer', function () {

        if ($(this).val() == 1) {
            $('.offer_percentage').slideDown();
            $('.offer_type').slideDown();
        } else {
            $('.offer_percentage').slideUp();
            $('.offer_type').slideUp();

        }
    });

    $(document).on('click', '.add-product-mdl', function (e) {
        e.preventDefault();
        $("#wait_msg,#overlay").show();
        var action = $(this).attr('href');

        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();


                $('#results-modals').html(data);
                $('.offer_percentage').slideUp();
                $('.offer_type').slideUp();

                $('#add-product').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });

    $(document).on('click', '.edit-product-mdl', function (e) {
        $("#wait_msg,#overlay").show();
        e.preventDefault();
        var action = $(this).attr('href');
        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                // $('.offer_percentage').slideDown();
                // $('.offer_type').slideDown();
                // if ($('#results-modals').find('.is_offer').val() == 0) {
                //     $('.offer_percentage').slideUp();
                //     $('.offer_type').slideUp();
                // }
                $('#edit-product').modal('show', {backdrop: 'static', keyboard: false});
                $('#results-modals').find('#is_offer').change();

            }, error: function (xhr) {

            }
        });
    });

    $(document).on('click', '.edit-product-images-mdl', function (e) {
        // var addProductHtml = $('.component').html();
        // // $('.component').addClass('text-center').html('<i class="fa fa-spinner fa-spin text-center fa-5x"></i>');
        // // $(".component").animate({
        // //     top: '0px'
        // // }, 2000);
        e.preventDefault();
        var action = $(this).attr('href');
        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                // $("#wait_msg,#overlay").hide();
                // $('.component').removeClass('text-center').html(data);

                $('#images-product').html(data);
                $('#imagesProduct').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {
                // $('.component').html(addProductHtml);
            }
        });
    });

    $(document).on('submit', '#formAdd,#formEdit', function (event) {

        var _this = $(this);
        // var loader = '<i class="fa fa-spinner fa-spin"></i>';
        _this.find('.btn.save i').addClass('fa-spinner fa-spin');
        event.preventDefault(); // Totally stop stuff happening
        // START A LOADING SPINNER HERE
        // Create a formdata object and add the filee

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
                    products_tbl.api().ajax.reload();
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

            }
        });
    });

})
;