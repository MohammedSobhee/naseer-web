var contacts_tbl = $("#contacts_tbl");
$(document).ready(function () {


    if ($("#contacts_tbl").length) {

        contacts_tbl.on('preXhr.dt', function (e, settings, data) {
            // data.talent_name = $('#talent_name').val();
            // data.client_name = $('#client_name').val();
            // data.occasion_id = $('#occasion_id').val();
            // data.status = $('#status').val();
            // data.email = $('#email_c').val();
            // data.phone = $('#phone_c').val();
            // data.is_active = $('#is_active_c').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + "/contact-data",
                "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status !== undefined && !json.status) {
                        $('#contacts_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                // {data: 'image', name: 'image'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                // {data: 'message', name: 'message'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'}
            ],
            "fnDrawCallback": function () {
                //Initialize checkbos for enable/disable user
                // $(".make-switch").bootstrapSwitch({size: "mini", onColor: "success", offColor: "danger"});
            },

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

    $(document).on('click', '.contact-mdl', function (e) {

        e.preventDefault();
        $("#wait_msg,#overlay").show();
        var action = $(this).attr('href');

        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#contactIdMdl').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });


    $(document).on("click", ".filter-submit", function () {
        contacts_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {
        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input').val('');
        contacts_tbl.api().ajax.reload();
    });


});
