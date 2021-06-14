siteObjJs.admin.SalesItemwise = function () {

// Initialize all the page-specific event listeners here.

    var initializeListener = function () {
        $('body').on("click", ".btn-collapse", function () {
            $("#ajax-response-text").html("");
            //retrieve id of form element and create new instance of validator to clear the error messages if any
            var formElement = $(this).closest("form");
            var formId = formElement.attr("id");
            var validator = $('#' + formId).validate();
            validator.resetForm();
            //remove any success or error classes on any form, to reset the label and helper colors
            $('.form-group').removeClass('has-error');
            $('.form-group').removeClass('has-success');
        });

    };
    // Common method to handle add and edit ajax request and reponse
    var handleAjaxRequest = function () {
        var formElement = $(this.currentForm); // Retrive form from DOM and convert it to jquery object
        var actionUrl = formElement.attr("action");
        var actionType = formElement.attr("method");
        var formData = formElement.serialize();
        var icon = "check";
        var messageType = "success";
        $.ajax(
                {
                    url: actionUrl,
                    cache: false,
                    type: actionType,
                    data: formData,
                    success: function (data)
                    {
                        //console.log(data);
                        //data: return data from server
                        if (data.status === "error")
                        {
                            icon = "times";
                            messageType = "danger";
                        }

                        //Empty the form fields
                        formElement.find("input[type=text], textarea").val("");
                        //trigger cancel button click event to collapse form and show title of add page
                        $('.btn-collapse').trigger('click');
                        //reload the data in the datatable
                        grid.getDataTable().ajax.reload();
                        Metronic.alert({
                            type: messageType,
                            icon: icon,
                            message: data.message,
                            container: $('#ajax-response-text'),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });
                    },
                    error: function (jqXhr, json, errorThrown)
                    {
                        var errors = jqXhr.responseJSON;
                        var errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml += value[0] + '<br />';
                        });
                        //alert(errorsHtml, "Error " + jqXhr.status + ': ' + errorThrown);
                        Metronic.alert({
                            type: 'danger',
                            message: errorsHtml,
                            container: $('#ajax-response-text'),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });
                    }
                }
        );
    }

    var handleTable = function () {

        grid = new Datatable();
        grid.init({
            src: $('#datatable-sales-itemwise'),
            loadingMessage: 'Loading...',
            dataTable: {
                'language': {
                    'info': '<span class="seperator">|</span><b>Total _TOTAL_ record(s) found</b>',
                    'infoEmpty': '',
                },
                "bStateSave": false,
                "lengthMenu": siteObjJs.admin.commonJs.constants.gridLengthMenu,
                "pageLength": siteObjJs.admin.commonJs.constants.recordsPerPage,
                "columns": [
                    {data: null, name: 'rownum', searchable: false},
                    {data: 'customer_id', name: 'customer_id', searchable: false},
                    {data: 'merchant_name', name: 'merchant_name', sortable: false, searchable: false},
                    {data: 'membership_id', name: 'membership_id'},
                    {data: 'tier_name', name: 'tier_name'},
                    {data: 'customer_name', name: 'customer_name'},
                    {data: 'email_address', name: 'email_address'},
                    {data: 'mobile_number', name: 'mobile_number'},
                    {data: 'city', name: 'city', sortable: false},
                    {data: 'pincode', name: 'pincode', sortable: false},
                    {data: 'state', name: 'state', sortable: false},
                    {data: 'country', name: 'country', sortable: false},
                    {data: 'membership', name: 'membership', sortable: false, searchable: false},
                    {data: 'location_username', name: 'location_username', sortable: false},
                    {data: 'date_of_birth', name: 'date_of_birth'},
                    {data: 'spouse_dob', name: 'spouse_dob'},
                    {data: 'anniversary_date', name: 'anniversary_date'},
                    {data: 'gender_label', name: 'gender_label', sortable: false},
                    {data: 'marital_status_label', name: 'marital_status_label', sortable: false},
                    {data: 'status_label', name: 'status_label', sortable: false},
                    {data: 'last_rewarded_date', name: 'last_rewarded_date', sortable: true},
                    {data: 'last_redeemed_date', name: 'last_redeemed_date', sortable: true},
                    {data: 'last_bill_rejection_date', name: 'last_bill_rejection_date', sortable: true},
                    {data: 'total_lifetime_spend', name: 'total_lifetime_spend', num: true},
                    {data: 'earned_points', name: 'earned_points'},
                    {data: 'earned_value', name: 'earned_value'},
                    {data: 'redeemed_points', name: 'redeemed_points'},
                    {data: 'redeemed_value', name: 'redeemed_value'},
                    {data: 'refunded_points', name: 'refunded_points'},
                    {data: 'expired_points', name: 'expired_points'},
                    {data: 'current_points_balance', name: 'current_points_balance'},
                    {data: 'current_points_value', name: 'current_points_value'},
                    {data: 'registration_date_time', name: 'registration_date_time'},
                    {data: 'register_location', name: 'register_location', sortable: false},
                    {data: 'app_installed', name: 'app_installed', sortable: false},
                    {data: 'app_installed_date', name: 'app_installed_date'},
                    {data: null, name: 'action', sortable: false}
                ],
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;
                    var page = api.page();
                    var recNum = null;
                    var displayLength = settings._iDisplayLength;
                    api.column(0, {page: 'current'}).data().each(function (group, i) {
                        recNum = ((page * displayLength) + i + 1);
                        $(rows).eq(i).children('td:first-child').html(recNum);
                    });
                    /*
                    api.column(23, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(23)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(23)').html(recFormat);
                    });*/
                    api.column(24, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(24)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(24)').html(recFormat);
                    });
                    api.column(25, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(25)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(25)').html(recFormat);
                    });
                    api.column(26, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(26)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(26)').html(recFormat);
                    });
                    api.column(27, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(27)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(27)').html(recFormat);
                    });
                    api.column(28, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(28)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(28)').html(recFormat);
                    });
                    api.column(29, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(29)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(29)').html(recFormat);
                    });
                    api.column(30, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(30)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(30)').html(recFormat);
                    });
                    api.column(31, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(31)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(31)').html(recFormat);
                    });
                    api.column(32, {page: 'current'}).data().each(function (group, i) {
                        var recFormat = parseFloat($(rows).eq(i).children('td:nth-child(31)').html()).toFixed(2);
                        if (recFormat != '' && !isNaN(recFormat))
                            $(rows).eq(i).children('td:nth-child(32)').html(recFormat);
                    });
                    api.column(33, {page: 'current'}).data().each(function (group, i) {
                        $(rows).eq(i).children('td:last-child').html(' ');
                    });
                },
                "ajax": {
                    "url": "reports/sales-itemwise/data",
                    "type": "POST"
                },
                order: [[1, 'desc']]
            }
        });
        $('#data-search').keyup(function () {
            grid.getDataTable().search($(this).val()).draw();
        });

        $(".form-filter-attr").keyup(function (e) {
            var code = e.which; // recommended to use e.which, it's normalized across browsers
            if (code == 13)
                e.preventDefault();
            if (code == 32 || code == 13 || code == 188 || code == 186) {
                $('.filter-submit').click();
            }
        });
        // For drop down filter
        $(".form-filter-select-attr").change(function () {
            $('.filter-submit').click();
        })
    };

    var handleDatetimePicker = function () {
        if (!jQuery().datepicker) {
            return;
        }
        $(".date-of-birth").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            // isRTL: Metronic.isRTL(),
            changeYear: true,
            yearRange: 'yy-50:yy+1',
            // pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left")
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            initializeListener();
            handleDatetimePicker();
            handleTable();
        }
    };
}();