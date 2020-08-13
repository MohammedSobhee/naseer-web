$(document).ready(function () {

    if ($("#users_tbl").length) {

        var users_tbl = $("#users_tbl");
        users_tbl.on('preXhr.dt', function (e, settings, data) {
            //.name,.title,.server,.searcher.,.status
            // data.name = $('.name').val();
            data.name = $('#name').val();
            data.email = $('#email').val();
            data.mobile = $('#mobile').val();
            data.is_active = $('#is_active').val();
            data.email_verified_at = $('#email_verified_at').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: baseURL + "/users/user-data"
                // success: function (response) {
                //
                //     if (!response.status) {
                //         $('#users_tbl_processing').hide();
                //         bootbox.alert(response.message);
                //
                //     }
                // }
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
                {data: 'logo', name: 'logo'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'email_verified_at', name: 'email_verified_at'},
                {data: 'mobile', name: 'mobile'},
                {data: 'is_active', name: 'is_active'},
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
    $(document).on('click', '.user-det', function (e) {
        $("#wait_msg,#overlay").show();
        e.preventDefault();
        var action = $(this).attr('href');
        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#user_view_frm').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });
    $(document).on('change', '.is_active', function (event) {

        var _this = $(this);
        var user_id = _this.data('id');
        event.preventDefault();
        $.ajax({
            url: baseURL + '/user-activation',
            type: 'PUT',
            dataType: 'json',
            data: {'_token': csrf_token, 'user_id': user_id},
            success: function (data) {

                if (data.status) {
                    $('.alert').hide();
                    toastr['success'](data.message, '');
                    users_tbl.api().ajax.reload();

                } else {
                    toastr['error'](data.message);
                }

            }
        });

    });
    $(document).on('change', '.is_email_verified', function (event) {

        var _this = $(this);
        var user_id = _this.data('id');
        event.preventDefault();
        $.ajax({
            url: baseURL + '/user/verify-email',
            type: 'PUT',
            dataType: 'json',
            data: {'_token': csrf_token, 'user_id': user_id},
            success: function (data) {

                if (data.status) {
                    $('.alert').hide();
                    toastr['success'](data.message, '');
                    users_tbl.api().ajax.reload();

                } else {
                    toastr['error'](data.message);
                }

            }
        });

    });

    $(document).on("click", ".filter-submit", function () {
//                if ($(this).val().length > 3)
        users_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input,select').val('');
        // $('#is_admin_confirm,.status').val('').trigger('change');
        users_tbl.api().ajax.reload();
    });
})
;