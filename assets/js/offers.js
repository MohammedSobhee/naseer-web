$(document).ready(function () {

    if ($("#offers_tbl").length) {

        var offers_tbl = $("#offers_tbl");
        offers_tbl.on('preXhr.dt', function (e, settings, data) {
            data.name = $('#name').val();
            data.payment_type = $('#payment_type').val();
            data.status = $('#status').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: baseURL + "/offers/offer-data/" + $('#order_id').val()
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#offers_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'service_provider.name', name: 'service_provider.name'},
                {data: 'down_payment', name: 'down_payment'},
                {data: 'late_payment', name: 'late_payment'},
                {data: 'details', name: 'details'},
                {data: 'status', name: 'status'},
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

    $(document).on("click", ".filter-submit", function () {
//                if ($(this).val().length > 3)
        offers_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input,select').val('');
        // $('#is_admin_confirm,.status').val('').trigger('change');
        offers_tbl.api().ajax.reload();
    });

});
