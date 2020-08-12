var transactions_tbl = $("#transactions_tbl");
$(document).ready(function () {


    if ($("#transactions_tbl").length) {

        transactions_tbl.on('preXhr.dt', function (e, settings, data) {
            data.transaction_date_from = $('#transaction_date_from').val();
            data.transaction_date_to = $('#transaction_date_to').val();
            data.talent_name = $('#talent_name').val();
            data.status = $('#status').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + "/transaction-data",
                "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status !== undefined && !json.status) {
                        $('#transactions_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                // {data: 'image', name: 'image'},
                {data: 'request_id', name: 'request_id'},
                {data: 'talent.name', name: 'talent.name'},
                {data: 'cost', name: 'cost'},
                {data: 'commission_rate', name: 'commission_rate'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'}
            ],

            language: {
                "sProcessing": "<img src='" + baseAssets + "/apps/img/preloader_.gif'>",
            },

            "searching": false,
            "ordering": false,
            bStateSave: !0,
            lengthMenu: [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]],
            pageLength: 10,
            pagingType: "bootstrap_full_number",
            columnDefs: [{orderable: !1, targets: [0]}, {searchable: !1, targets: [0]}, {className: "dt-right"}],
            order: [[1, "asc"]],

        });
    }

    $(document).on("click", ".filter-submit", function () {
        transactions_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {
        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input').val('');
        transactions_tbl.api().ajax.reload();
    });
    $(document).on('click', '.refund', function (event) {

        var _this = $(this);
        var action = _this.attr('href');
        event.preventDefault();

        bootbox.dialog({
            message: "Are you sure for refunding (<span class='label label-danger'> You can not return back.</span>)",
            title: "Refunding process!",
            buttons: {

                main: {
                    label: 'Sure <i class="fa fa-check"></i> ',
                    className: "btn-primary",
                    callback: function () {
                        //do something else
                        $.ajax({
                            url: action,
                            type: 'PUT',
                            dataType: 'json',
                            data: {_token: csrf_token},
                            success: function (data) {

                                if (data.status) {
                                    toastr['success'](data.message, '');
                                    transactions_tbl.api().ajax.reload();
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


});
