var requests_tbl = $("#requests_tbl");
var requests_talent_tbl = $("#requests_talent_tbl");
$(document).ready(function () {


    if ($("#requests_tbl").length) {

        requests_tbl.on('preXhr.dt', function (e, settings, data) {
            data.date_from = $('#date_from').val();
            data.date_to = $('#date_to').val();
            data.talent_name = $('#talent_name').val();
            data.client_name = $('#client_name').val();
            data.occasion_id = $('#occasion_id').val();
            data.status = $('#status').val();
            // data.email = $('#email_c').val();
            // data.phone = $('#phone_c').val();
            // data.is_active = $('#is_active_c').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + "/request-data",
                "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status !== undefined && !json.status) {
                        $('#requests_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                // {data: 'image', name: 'image'},
                {data: 'user.name', name: 'user.name'},
                {data: 'talent.name', name: 'talent.name'},
                {data: 'occasion_title', name: 'occasion_title'},
                // {data: 'message', name: 'message'},
                {data: 'booking_price', name: 'booking_price'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'approved_at', name: 'approved_at'},
                {data: 'approved_talent_at', name: 'approved_talent_at'},
                {data: 'action', name: 'action'}
            ],
            "fnDrawCallback": function () {
                //Initialize checkbos for enable/disable user
                $(".make-switch").bootstrapSwitch({size: "mini", onColor: "success", offColor: "danger"});
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
    if ($("#requests_talent_tbl").length) {

        requests_talent_tbl.on('preXhr.dt', function (e, settings, data) {
            data.talent_id = $('#talent_id').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + "/request-data",
                "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status !== undefined && !json.status) {
                        $('#requests_talent_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                // {data: 'image', name: 'image'},
                {data: 'user.name', name: 'user.name'},
                {data: 'occasion.title_en', name: 'occasion.title_en'},
                {data: 'booking_price', name: 'booking_price'},
                {data: 'status', name: 'status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'}
            ],
            "fnDrawCallback": function () {
                //Initialize checkbos for enable/disable user
                $(".make-switch").bootstrapSwitch({size: "mini", onColor: "success", offColor: "danger"});
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

    $('#requests_tbl').on('switchChange.bootstrapSwitch', '.make-switch', function (event, state) {
        // ... skipped ...
        var request_id = $(this).data('id');

        $.ajax({
            url: baseURL + '/request-approve',
            type: 'PUT',
            dataType: 'json',
            data: {'_token': csrf_token, 'request_id': request_id},
            success: function (data) {

                if (data.status) {
                    toastr['success'](data.message, '');
                    requests_tbl.api().ajax.reload();

                } else {
                    toastr['error'](data.message);
                }

            }
        });

    });

    $(document).on('click', '.video-mdl', function (e) {

        e.preventDefault();
        $("#wait_msg,#overlay").show();
        var action = $(this).attr('href');

        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#videoId').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });

    $(document).on('click', '.close-modal', function (e) {

        e.preventDefault();
        var video = document.getElementById("client-request-video");
        // var video = $(this).closest('.video').find('video');

        if (video !== undefined && video !== null) {
            video.muted = true;
            $(this).addClass('fa-volume-up')
        }

        $(this).closest('#requestIdMdl').modal('hide');

    });
    $(document).on('click', '.request-mdl', function (e) {

        e.preventDefault();
        $("#wait_msg,#overlay").show();
        var action = $(this).attr('href');

        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#requestIdMdl').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });

    $(document).on('click', '.delete', function (event) {

        var _this = $(this);
        var action = _this.attr('href');
        event.preventDefault();

        bootbox.dialog({
            message: "Are you sure for deleting (<span class='label label-danger'> You can not return back.</span>)",
            title: "Deleting process!",
            buttons: {

                main: {
                    label: 'Sure <i class="fa fa-check"></i> ',
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
                                    requests_tbl.api().ajax.reload();
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


    $(document).on("click", ".filter-submit", function () {
        requests_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {
        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input').val('');
        requests_tbl.api().ajax.reload();
    });


});
