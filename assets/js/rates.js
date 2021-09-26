$(document).ready(function () {

    if ($("#rates_tbl").length) {

        var rates_tbl = $("#rates_tbl");
        rates_tbl.on('preXhr.dt', function (e, settings, data) {
            data.name = $('#name').val();
            data.service_provider = $('#service_provider').val();
            data.type = $('#type').val();
            data.service_id = $('#service_id').val();
            data.is_approved = $('#is_approved').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: baseURL + "/rates/rate-data"
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#rates_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'client.name', name: 'client.name'},
                {data: 'service_provider.name', name: 'service_provider.name'},
                {data: 'action', name: 'action'},
                {data: 'order.type', name: 'order.type'},
                {data: 'order.service.name', name: 'order.service.name'},
                {data: 'rate', name: 'rate'},
                {data: 'text', name: 'text'},
                {data: 'action', name: 'action'}
            ],
            "fnDrawCallback": function () {
                //Initialize checkbos for enable/disable user
                $(".make-switch").bootstrapSwitch({size: "mini", onColor: "success", offColor: "danger"});
            },
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

    $('#rates_tbl').on('switchChange.bootstrapSwitch', '.is_active', function (event, state) {
        // ... skipped ...
        var rate_id = $(this).data('id');

        $.ajax({
            url: baseURL + '/rates/rate-status',
            type: 'PUT',
            dataType: 'json',
            data: {'_token': csrf_token, 'rate_id': rate_id},
            success: function (data) {

                if (data.status) {
                    toastr['success'](data.message, '');
                } else {
                    toastr['error'](data.message);
                }

            }
        });

    });

    $(document).on("click", ".filter-submit", function () {
//                if ($(this).val().length > 3)
        rates_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input,select').val('');
        // $('#is_admin_confirm,.status').val('').trigger('change');
        rates_tbl.api().ajax.reload();
    });

});
