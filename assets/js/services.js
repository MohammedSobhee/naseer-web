$(document).ready(function () {

    if ($("#services_tbl").length) {

        var services_tbl = $("#services_tbl");
        services_tbl.on('preXhr.dt', function (e, settings, data) {

            data.name = $('#name').val();
            data.service_provider_type_id = $('#service_provider_type_id').val();

        }).dataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: baseURL + "/services/service-data"
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#services_tbl_processing').hide();
                        bootbox.alert(json.message);
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'service_provider_type_name', name: 'service_provider_type_name'},
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

        // Grab the datatables input box and alter how it is bound to events
        $(".dataTables_filter input")
            .unbind() // Unbind previous default bindings
            .bind("input", function (e) { // Bind our desired behavior
                // If the length is 3 or more characters, or the user pressed ENTER, search
                if (this.value.length >= 3 || e.keyCode == 13) {
                    // Call the API search function
                    services_tbl.api().search(this.value).ajax.reload();

                }
                // Ensure we clear the search if they backspace far enough
                if (this.value == "") {
                    services_tbl.api().search("").ajax.reload();
                }
            });
    }

    $(document).on('click', '.edit-service-mdl', function (event) {

        var _this = $(this);
        var action = _this.attr('href');
        event.preventDefault();


        $.ajax({
            url: action,
            type: 'GET',
            // dataType: 'json',
            success: function (data) {

                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#edit-service').modal('show', {backdrop: 'static', keyboard: false});
            }
        });

    });
    $(document).on("click", ".filter-submit", function () {
//                if ($(this).val().length > 3)
        services_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('tr').find('input,select').val('');
        // $('#is_admin_confirm,.status').val('').trigger('change');
        services_tbl.api().ajax.reload();
    });

    $(document).on('submit', '#formEdit', function (event) {

        var _this = $(this);
        // var loader = '<i class="fa fa-spinner fa-spin"></i>';
        _this.find('.save i').addClass('fa-spinner fa-spin');
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
                    services_tbl.api().ajax.reload();

                } else {
                    var $errors = '<strong>' + data.message + '</strong>';
                    $errors += '<ul>';
                    $.each(data.errors, function (i, v) {
                        $errors += '<li>' + v.message + '</li>';
                    });
                    $errors += '</ul>';
                    $('.alert').show();
                    $('.alert').html($errors);
                    // toastr['error'](data.message);
                }
                _this.find('.btn i').removeClass('fa-spinner fa-spin');
                // _this.find('.fa-spin').hide();
                // $('#save_category_frm').attr('action', $('#url_action').val());
            }
        });
    });

});
