var clients_tbl = $("#clients_tbl");
var talents_tbl = $("#talents_tbl");
var talents_dashboard_tbl = $("#talents_dashboard_tbl");
$(document).ready(function () {


    if ($("#clients_tbl").length) {

        clients_tbl.on('preXhr.dt', function (e, settings, data) {
            data.username = $('#username_c').val();
            data.email = $('#email_c').val();
            data.phone = $('#phone_c').val();
            data.is_active = $('#is_active_c').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + "/client-data",
                "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status !== undefined && !json.status) {
                        $('#clients_tbl_processing').hide();
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
                {data: 'email', name: 'email'},
                // {data: 'email_verified_at', name: 'email_verified_at'},
                {data: 'phone', name: 'phone'},
                // {data: 'country', name: 'country'},
                // {data: 'city', name: 'city'},
                // {data: 'address', name: 'address'},
                {data: 'is_active', name: 'is_active'},
                // {data: 'action', name: 'action'}
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
    if ($("#talents_tbl").length) {

        talents_tbl.on('preXhr.dt', function (e, settings, data) {
            data.username = $('#username_t').val();
            data.email = $('#email_t').val();
            data.phone = $('#phone_t').val();
            data.gender = $('#gender_t').val();
            data.is_active = $('#is_active_t').val();
            data.is_approve = $('#is_approve_t').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + "/talent-data/1",
                "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status !== undefined && !json.status) {
                        $('#talents_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'image', name: 'image'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'gender', name: 'gender'},
                {data: 'booking_price', name: 'booking_price'},
                {data: 'findme', name: 'findme'},
                {data: 'handler', name: 'handler'},
                {data: 'follower_num', name: 'follower_num'},
                {data: 'position', name: 'position'},
                {data: 'is_active', name: 'is_active'},
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
    if ($("#talents_dashboard_tbl").length) {

        talents_dashboard_tbl.on('preXhr.dt', function (e, settings, data) {
            data.username = $('#username_t').val();
            data.email = $('#email_t').val();
            data.phone = $('#phone_t').val();
            data.gender = $('#gender_t').val();
            data.is_active = $('#is_active_t').val();
            data.is_approve = $('#is_approve_t').val();
        }).dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + "/talent-data/0",
                "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status !== undefined && !json.status) {
                        $('#talents_dashboard_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'findme', name: 'findme'},
                {data: 'handler', name: 'handler'},
                {data: 'follower_num', name: 'follower_num'},
                {data: 'is_approve', name: 'is_approve'}
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

    $('#clients_tbl').on('switchChange.bootstrapSwitch', '.make-switch', function (event, state) {
        // ... skipped ...
        var user_id = $(this).data('id');

        $.ajax({
            url: baseURL + '/client-status',
            type: 'PUT',
            dataType: 'json',
            data: {'_token': csrf_token, 'user_id': user_id},
            success: function (data) {

                if (data.status) {
                    toastr['success'](data.message, '');
                } else {
                    toastr['error'](data.message);
                }

            }
        });

    });
    $('#talents_tbl').on('switchChange.bootstrapSwitch', '.status', function (event, state) {
        // ... skipped ...
        var user_id = $(this).data('id');

        $.ajax({
            url: baseURL + '/talent-status',
            type: 'PUT',
            dataType: 'json',
            data: {'_token': csrf_token, 'user_id': user_id},
            success: function (data) {

                if (data.status) {
                    toastr['success'](data.message, '');
                } else {
                    toastr['error'](data.message);
                }

            }
        });

    });
    $('#talents_dashboard_tbl').on('switchChange.bootstrapSwitch', '.approve', function (event, state) {
        // ... skipped ...
        var user_id = $(this).data('id');

        $.ajax({
            url: baseURL + '/talent-approve',
            type: 'PUT',
            dataType: 'json',
            data: {'_token': csrf_token, 'user_id': user_id},
            success: function (data) {

                if (data.status) {
                    toastr['success'](data.message, '');
                    talents_dashboard_tbl.api().ajax.reload();

                } else {
                    toastr['error'](data.message);
                }

            }
        });

    });

    $(document).on('click', '.add-talent-mdl', function (e) {

        e.preventDefault();
        $("#wait_msg,#overlay").show();
        var action = $(this).attr('href');

        $.ajax({
            url: action,
            type: 'GET',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#add-talent-mdl').modal('show', {backdrop: 'static', keyboard: false});
            }, error: function (xhr) {

            }
        });
    });

    $(document).on("click", ".filter-submit-c", function () {
        clients_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel-c', function () {
        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input').val('');
        clients_tbl.api().ajax.reload();
    });
    $(document).on("click", ".filter-submit-t", function () {
        talents_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel-t', function () {
        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input').val('');
        talents_tbl.api().ajax.reload();
    });
    $(document).on("click", ".filter-submit-td", function () {
        talents_dashboard_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel-td', function () {
        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input').val('');
        talents_dashboard_tbl.api().ajax.reload();
    });

    $(document).on('submit', 'form', function (event) {

        var _this = $(this);
        // var loader = '<i class="fa fa-spinner fa-spin"></i>';
        // var loader = ' <i class="fa fa-spinner fa-spin"></i> ';
        $(this).find('.save i').addClass('fa-spinner fa-spin');
        $(this).find('.save').attr('disabled', 'true');
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

                    toastr.success(data.message);
                    // talents_tbl.api().ajax.reload();
                    // location.href = baseURL + "/talent/archive/" + data.items.id;
                } else {

                    if (data.statusCode == 401) {
                        location.reload()
                    }
                    var $errors = '<strong>' + data.message + '</strong>';
                    $errors += '<ul>';
                    $.each(data.errors, function (i, v) {
                        $errors += '<li>' + v.message + '</li>';
                    });
                    $errors += '</ul>';
                    $('.alert').show();
                    $('.alert').html($errors);
                    toastr.error(data.message);


                }
                // _this.find('.btn-primary').find('i').remove();
                // _this.find('.fa-spin').hide();
                _this.find('.save i').removeClass('fa-spinner fa-spin');
                _this.find('.save').removeAttr('disabled');


            }
        });
    });


});
