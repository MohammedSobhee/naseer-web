$(document).ready(function () {

    if ($("#orders_tbl").length) {

        var orders_tbl = $("#orders_tbl");
        orders_tbl.on('preXhr.dt', function (e, settings, data) {
            data.name = $('#name').val();
            data.city = $('#city').val();
            data.type = $('#type').val();
            data.service_id = $('#service_id').val();
            data.status = $('#status').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: baseURL + "/requests/request-data"
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#orders_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'user.name', name: 'user.name'},
                {data: 'city.name', name: 'city.name'},
                {data: 'type', name: 'type'},
                {data: 'service.name', name: 'service.name'},
                {data: 'contact_prefer', name: 'contact_prefer'},
                {data: 'payment_prefer', name: 'payment_prefer'},
                {data: 'service_date', name: 'service_date'},
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

});
