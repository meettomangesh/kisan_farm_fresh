siteObjJs.admin.communicationMessageJs = function () {

// Initialize all the page-specific event listeners here.

    var initializeListener = function () {

        //CKEDITOR.replace( 'email_body' );

        $('body').on("click", ".btn-collapse", function () {
            $("#ajax-response-text").html("");
            //retrieve id of form element and create new instance of validator to clear the error messages if any
            var formElement = $(this).closest("form");
            var formId = formElement.attr("id");
            $("#" + formId + " .select2me").select2("val", "");
            $("#" + formId).find("#merchant_id").select2("val", "");
            $("#" + formId).find('#merchant_id option[value="0"]').prop("selected", true);
            var validator = $('#' + formId).validate();
            validator.resetForm();
            formElement.find('#pos_ids').tagsinput('removeAll');
            //remove any success or error classes on any form, to reset the label and helper colors
            $('.form-group').removeClass('has-error');
            $('.form-group').removeClass('has-success');
            $("#" + formId).find('#today_time-error').html('');
        });

        $('#customer-communication-message-table').on('click', '.filter-cancel', function (e) {
            $("#merchant-name-search").select2('val', '');
        });

    };
    // Method to fetch and place edit form with data using ajax call

    var fetchDataForEdit = function () {
        $('body').on('click', '.edit-form-link', function () {
            var cat_id = $(this).attr("id");
            var actionUrl = 'customer-communication-message/' + cat_id + '/edit';
            CKEDITOR.instances.email_body.destroy(true);
            $('#edit-customer-communication-message').find('#email_tags').tagsinput('removeAll');
            $.ajax({
                url: actionUrl,
                cache: false,
                dataType: "json",
                type: "GET",
                success: function (data)
                {
                    $("#edit_form").html(data.form);
                    $('#edit-customer-communication-message').find('#send-email-btn').prop('disabled', true);
                    $('#edit-customer-communication-message').find('#send-sms-btn').prop('disabled', true);
                    $('#edit-customer-communication-message').find('#test_email_addresses').val('');
                    $('#edit-customer-communication-message').find('#test_mobile_numbers').val('');
                    if (data.message_data.test_mode == 1) {
                        $('#edit-customer-communication-message').find('#testing-mode-div').show();                       
                    } else {
                        $('#edit-customer-communication-message').find('#testing-mode-div').hide();
                    }
                    $("#edit_form").find("input#email_tags").tagsinput('refresh');
                    $('#edit_form .select2me').select2({
                        placeholder: "Select",
                        allowClear: true
                    });
                    $('form').find('input:radio').uniform();
                    if (data.message_data.merchant_id != 0) {
                        $('#edit-customer-communication-message').find('#loyalty_id').attr('disabled', false);
                        $('#edit-customer-communication-message').find('#loyalty_tier_id').attr('disabled', false);
                        if(data.message_data.message_type == 1) {
                            $('#edit-customer-communication-message').find('#offer_id').attr('disabled', false);
                            $('#edit-customer-communication-message').find('#offer_id').select2('val', data.message_data.offer_id);
                        } else if(data.message_data.message_type == 2) {
                            $('#edit-customer-communication-message').find('#offer_id').attr('disabled', true);
                            $('#edit-customer-communication-message').find('#product_id').attr('disabled', true);
                        } else if(data.message_data.message_type == 3) {
                            $('#edit-customer-communication-message').find('#offer_id').attr('disabled', true);
                            $('#edit-customer-communication-message').find('#product_id').attr('disabled', false);
                            $('#edit-customer-communication-message').find('#product_id').select2('val', data.message_data.offer_id);
                        }    
                    }                   
                    if (data.message_data.push_text != '') {
                        $('#edit-customer-communication-message').find('#push-text-div').show();
                        
                        //deep link screen disable for merchant offer
                        $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                        if (data.message_data.push_text != '') {
                            if(data.message_data.message_type == 1) {
                                if($('#edit-customer-communication-message').find('#deep_link_screen option[value="MERCHANT_OFFERS"]').length > 0) {
                                    $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', 'MERCHANT_OFFERS');
                                    $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', true);
                                } else {
                                    $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                    $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', data.message_data.deep_link_screen);
                                }
                            } else if(data.message_data.message_type == 3) {
                                    if($('#edit-customer-communication-message').find('#deep_link_screen option[value="MERCHANT_SHOP"]').length > 0) {
                                        $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', 'MERCHANT_SHOP');
                                        $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', true);
                                    } else {
                                        $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                        $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', data.message_data.deep_link_screen);
                                    }
                            } else {
                                $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', data.message_data.deep_link_screen);
                            }
                        }                                                    
                    }

                    if (data.message_data.sms_text != '') {
                        $('#edit-customer-communication-message').find('#sms-text-div').show();
                    }
                    
                    if ((data.message_data.sms == '1') || (data.message_data.sms_notification == '1')) {
                        $('#edit-customer-communication-message').find('#send-sms-btn').prop('disabled', false);
                        //deep link screen disable for merchant offer
                        $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                        if (data.message_data.sms_notification != '') {
                            if(data.message_data.message_type == 1) {
                                if($('#edit-customer-communication-message').find('#deep_link_screen option[value="MERCHANT_OFFERS"]').length > 0) {
                                    $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', 'MERCHANT_OFFERS');
                                    $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', true);
                                } else {
                                    $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                    $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', data.message_data.deep_link_screen);
                                }
                            } else if(data.message_data.message_type == 3) {
                                if($('#edit-customer-communication-message').find('#deep_link_screen option[value="MERCHANT_SHOP"]').length > 0) {
                                    $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', 'MERCHANT_SHOP');
                                    $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', true);
                                } else {
                                    $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                    $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', data.message_data.deep_link_screen);
                                }
                            } else {
                                $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', data.message_data.deep_link_screen);
                            }
                        }     
                    } else {
                        $('#edit-customer-communication-message').find('#send-sms-btn').prop('disabled', true);
                    }
                    
                    if (data.message_data.email == '1') {
                        $('#edit-customer-communication-message').find('#email').prop('checked', true);
                        $('#edit-customer-communication-message').find('#email-div').show();
                        //send test email sms btn enable disable conditions                        
                        $('#edit-customer-communication-message').find('#send-email-btn').prop('disabled', false);                        
                    } else {
                        $('#edit-customer-communication-message').find('#email-div').hide();                        
                    }
                    if (data.message_data.push_notification == '1') {
                        $('#edit-customer-communication-message').find('#push_notification').prop('checked', true);
                        $('#edit-customer-communication-message').find('#sms_notification').attr("disabled", true);
                    }
                    if (data.message_data.sms == '1') {
                        $('#edit-customer-communication-message').find('#sms').prop('checked', true);
                        $('#edit-customer-communication-message').find('#sms_notification').attr("disabled", true);
                    }
                    if (data.message_data.sms_notification == '1') {
                        $('#edit-customer-communication-message').find('#sms_notification').prop('checked', true);
                        $('#edit-customer-communication-message').find('#push_notification').attr("disabled", true);
                        $('#edit-customer-communication-message').find('#sms').attr("disabled", true);

                    }

                    if (data.message_data.test_mode == '1') {
                        $('#edit-customer-communication-message').find('#for_testing option[value="1"]').prop("selected", true);
                        $('#edit-customer-communication-message').find('#testing-mode-div').show();
                        $('#edit-customer-communication-message').find('#test_email_addresses').val(data.message_data.test_email_address);
                        $('#edit-customer-communication-message').find('#test_mobile_numbers').val(data.message_data.test_mobile_number);
                    }
                    handleBootstrapMaxlength();
                    handleDatePicker();
                    handleTimePickers();

                    getMerchantLoyaltyProgram('edit-customer-communication-message');
                    getMerchantLoyaltyOfferData('edit-customer-communication-message');
                    showEmailFormDiv('edit-customer-communication-message');
                    showSmsFormDiv('edit-customer-communication-message');
                    showNotificationsFormDiv('edit-customer-communication-message');
                    showSmsAndNotificationsFormDiv('edit-customer-communication-message');
                    sendTodayDiv('edit-customer-communication-message');
                    sendTestSms('edit-customer-communication-message');
                    sendTestEmail('edit-customer-communication-message');
                    changeMessageType('edit-customer-communication-message');
                    enableTestingModeDiv('edit-customer-communication-message');



                    $('#edit-customer-communication-message').find('#message_send_time').val(data.message_data.message_send_date);
                    $('#edit-customer-communication-message').find('#today_time').val(data.message_data.message_send_time);

                    if (typeof (CKEDITOR.instances.email_body) == "object")
                    {
                        CKEDITOR.instances.email_body.destroy(true);
                        CKEDITOR.replaceAll("ckeditor");
                    } else {

                        CKEDITOR.replaceAll("ckeditor");
                    }

                    $('body').on('click', '#email', function (e) {
                        if ($(this).is(":checked")) {
                            $('#edit-customer-communication-message').find('#email-div').show();
                        } else {
                            $('#edit-customer-communication-message').find('#email-div').hide();
                        }
                    });

                    $('body').on('click', '#push_notification', function (e) {
                        if ($(this).is(":checked") || $('#edit-customer-communication-message').find('#sms_notification').is(":checked")) {
                            $('#edit-customer-communication-message').find('#push-text-div').show();  
                            //deep link screen disable for merchant offer
                            $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                            $('#edit-customer-communication-message').find("input:radio[name='message_type']").each(function () {
                                if($(this).parent().hasClass('checked')) {
                                    if($(this).attr("value")==1) {
                                        if($('#edit-customer-communication-message').find('#deep_link_screen option[value="MERCHANT_OFFERS"]').length > 0) {
                                            $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', 'MERCHANT_OFFERS');
                                            $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', true);
                                        } else {
                                            $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                            $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', '');
                                        }
                                    } else if($(this).attr("value") == 3) {
                                        if($('#edit-customer-communication-message').find('#deep_link_screen option[value="MERCHANT_SHOP"]').length > 0) {
                                            $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', 'MERCHANT_SHOP');
                                            $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', true);
                                        } else {
                                            $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                            $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', '');
                                        }
                                    } else {
                                        $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                        $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', '');
                                    } 
                                    
                                }                     
                            });
                        } else if ($('#edit-customer-communication-message').find('#push_notification').is(":checked") || $('#edit-customer-communication-message').find('#sms').is(":checked")) {                            
                            $('#edit-customer-communication-message').find('#push-text-div').hide();
                        } else {
                            $('#edit-customer-communication-message').find('#push-text-div').hide();                            
                        }
                    });

                    $('body').on('click', '#sms', function (e) {
                        if ($(this).is(":checked") || $('#edit-customer-communication-message').find('#sms_notification').is(":checked")) {
                            $('#edit-customer-communication-message').find('#sms-text-div').show();                            
                        } else if ($('#edit-customer-communication-message').find('#push_notification').is(":checked") || $('#edit-customer-communication-message').find('#sms').is(":checked")) {                            
                            $('#edit-customer-communication-message').find('#sms-text-div').hide();
                        } else {
                            $('#edit-customer-communication-message').find('#sms-text-div').hide();                            
                        }
                    });

                    $('body').on('click', '#sms_notification', function (e) {
                        if ($(this).is(":checked") || ($('#edit-customer-communication-message').find('#push_notification').is(":checked") && $('#edit-customer-communication-message').find('#sms').is(":checked"))) {
                            $('#edit-customer-communication-message').find('#push-text-div').show();
                            //deep link screen disable for merchant offer
                            $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                            $('#edit-customer-communication-message').find("input:radio[name='message_type']").each(function () {
                                if($(this).parent().hasClass('checked')) {
                                    if($(this).attr("value")==1) {
                                        if($('#edit-customer-communication-message').find('#deep_link_screen option[value="MERCHANT_OFFERS"]').length > 0) {
                                            $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', 'MERCHANT_OFFERS');
                                            $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', true);
                                        } else {
                                            $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                            $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', '');
                                        }                                        
                                    } else if($(this).attr("value") == 3) {
                                        if($('#edit-customer-communication-message').find('#deep_link_screen option[value="MERCHANT_SHOP"]').length > 0) {
                                            $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', 'MERCHANT_SHOP');
                                            $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', true);
                                        } else {
                                            $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                            $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', '');
                                        }
                                    } else {
                                        $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                        $('#edit-customer-communication-message').find('#deep_link_screen').select2('val', '');
                                    } 
                                    
                                }                     
                            });
                            $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                            $('#edit-customer-communication-message').find("input:radio[name='message_type']").each(function () {
                                if($(this).parent().hasClass('checked')) {
                                    if($(this).attr("value")==1) {
                                        $('#edit-customer-communication-message').find('#deep_link_screen').val('MERCHANT_OFFERS');
                                        $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', true);
                                    } else if($(this).attr("value")==3) {
                                        $('#edit-customer-communication-message').find('#deep_link_screen').val('MERCHANT_SHOP');
                                        $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', true);
                                    } else {
                                        $('#edit-customer-communication-message').find('#deep_link_screen').prop('disabled', false);
                                    } 
                                    
                                }                     
                            });
                                                        
                            $('#edit-customer-communication-message').find('#sms-text-div').show();                                                        
                        } else {
                            $('#edit-customer-communication-message').find('#push-text-div').hide();
                            $('#edit-customer-communication-message').find('#sms-text-div').hide();                            
                        }
                    });

                    $('body').on('change', '#for_testing', function (e) {
                        if ($('#edit-customer-communication-message').find('#for_testing').val() == 1) {
                            $('#edit-customer-communication-message').find('#testing-mode-div').show();
                        } else {
                            $('#edit-customer-communication-message').find('#test_email_addresses').val('');
                            $('#edit-customer-communication-message').find('#test_mobile_numbers').val('');
                            $('#edit-customer-communication-message').find('#testing-mode-div').hide();
                        }
                    });

                    $.uniform.update();
                    //CKEDITOR.instances.email_body.setData( data.message_data.email_body );
                    siteObjJs.validation.formValidateInit('#edit-customer-communication-message', handleEditAjaxRequest);

                },
                error: function (jqXhr, json, errorThrown)
                {
                    var errors = jqXhr.responseJSON;
                    var errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml += value[0] + '<br />';
                    });
                    // alert(errorsHtml, "Error " + jqXhr.status + ': ' + errorThrown);
                    Metronic.alert({
                        type: 'danger',
                        message: errorsHtml,
                        container: $('#ajax-response-text'),
                        place: 'prepend',
                        closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                    });
                }
            });
        });
    };

    var handleEditAjaxRequest = function () {
        var formElement = $(this.currentForm); // Retrive form from DOM and convert it to jquery object
        var actionUrl = formElement.attr("action");
        var actionType = formElement.attr("method");
        var formData = formElement.serialize();
        var icon = "check";
        var messageType = "success";
        if ($('#edit-customer-communication-message').find('#email').is(':checked') || $('#edit-customer-communication-message').find('#push_notification').is(':checked') || $('#edit-customer-communication-message').find('#sms').is(':checked') || $('#edit-customer-communication-message').find('#sms_notification').is(':checked')) {

        } else {
            var error = 'Please select atleast one Message Notify By.';
            Metronic.alert({
                type: 'danger',
                icon: 'times',
                message: error,
                container: $('#ajax-response-text'),
                place: 'prepend',
                closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
            });
            return false;
        }

        var formData = new FormData();
        formData.append('merchant_id', $('#edit-customer-communication-message').find('#merchant_id').val());
        formData.append('loyalty_id', $('#edit-customer-communication-message').find('#loyalty_id').val());
        formData.append('loyalty_tier_id', $('#edit-customer-communication-message').find('#loyalty_tier_id').val());

        var defaultEmail = 0;
        if ($('#edit-customer-communication-message').find('#email').is(':checked')) {
            defaultEmail = 1;
            $('#edit-customer-communication-message').find('#send-email-btn').prop('disabled', false);
            if (($('#edit-customer-communication-message').find('#for_testing').val() == 1) && ($('#edit-customer-communication-message').find('#test_email_addresses').val() == '')) {
                var error = 'Please enter test email.';
                Metronic.alert({
                    type: 'danger',
                    icon: 'times',
                    message: error,
                    container: $('#ajax-response-text'),
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
                return false;
            }
        }
        formData.append('email', defaultEmail);

        var defaultPushNotification = 0;
        if ($('#edit-customer-communication-message').find('#push_notification').is(':checked')) {
            defaultPushNotification = 1;
        }
        formData.append('push_notification', defaultPushNotification);
        formData.append('deep_link_screen', $('#edit-customer-communication-message').find('#deep_link_screen').val());

        var defaultSms = 0;
        if ($('#edit-customer-communication-message').find('#sms').is(':checked')) {
            defaultSms = 1;
            $('#edit-customer-communication-message').find('#send-sms-btn').prop('disabled', false);
            if (($('#edit-customer-communication-message').find('#for_testing').val() == 1) && ($('#edit-customer-communication-message').find('#test_mobile_numbers').val() == '')) {
                var error = 'Please enter test mobile number.';
                Metronic.alert({
                    type: 'danger',
                    icon: 'times',
                    message: error,
                    container: $('#ajax-response-text'),
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
                return false;
            }
        }
        formData.append('sms', defaultSms);

        var defaultSmsNotification = 0;
        if ($('#edit-customer-communication-message').find('#sms_notification').is(':checked')) {
            defaultSmsNotification = 1;
            $('#edit-customer-communication-message').find('#send-sms-btn').prop('disabled', false);
            if (($('#edit-customer-communication-message').find('#for_testing').val() == 1) && ($('#edit-customer-communication-message').find('#test_mobile_numbers').val() == '')) {
                var error = 'Please enter test mobile number.';
                Metronic.alert({
                    type: 'danger',
                    icon: 'times',
                    message: error,
                    container: $('#ajax-response-text'),
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
                return false;
            }
        }
        formData.append('sms_notification', defaultSmsNotification);

        var defaultMessageType = 0;
        var radioMessageValue = $('#edit-customer-communication-message').find("input[name='message_type']:checked").val();
        if (radioMessageValue == 1) {
            defaultMessageType = 1;
        } else if (radioMessageValue == 2) {
            defaultMessageType = 2;
        } else if (radioMessageValue == 3) {
            defaultMessageType = 3;
        }
        formData.append('message_title', $('#edit-customer-communication-message').find('#message_title').val());
        formData.append('message_type', defaultMessageType);
        formData.append('offer_id', $('#edit-customer-communication-message').find('#offer_id').val());
        formData.append('product_id', $('#edit-customer-communication-message').find('#product_id').val());
        formData.append('push_text', $('#edit-customer-communication-message').find('#push_text').val());
        formData.append('sms_text', $('#edit-customer-communication-message').find('#sms_text').val());
        //formData.append('image_url', $('#edit-customer-communication-message').find('#image_url').val());
        formData.append('email_from_name', $('#edit-customer-communication-message').find('#email_from_name').val());
        formData.append('email_from_email', $('#edit-customer-communication-message').find('#email_from_email').val());
        formData.append('email_subject', $('#edit-customer-communication-message').find('#email_subject').val());
        //formData.append('email_body', $('#edit-customer-communication-message').find('#email_body').val());
        var emailBody = CKEDITOR.instances.email_body.getData()
        formData.append('email_body', emailBody);
        formData.append('message_send_time', $('#edit-customer-communication-message').find('#message_send_time').val());
        var defaultTodayTime = 0;
        if ($('#edit-customer-communication-message').find('#send_today').is(':checked')) {
            defaultTodayTime = 1;

        }
        formData.append('send_today', defaultTodayTime);
        formData.append('today_time', $('#edit-customer-communication-message').find('#today_time').val());

        var defaultStatus = 0;
        var radioStatus = $('#edit-customer-communication-message').find("input[name='status']:checked").val();
        if (radioStatus == 1) {
            defaultStatus = 1;
        } else if (radioStatus == 0) {
            defaultStatus = 0;
        }
        formData.append('status', defaultStatus);

        formData.append('for_testing', $('#edit-customer-communication-message').find('#for_testing').val());
        formData.append('test_email_addresses', $('#edit-customer-communication-message').find('#test_email_addresses').val());
        formData.append('test_mobile_numbers', $('#edit-customer-communication-message').find('#test_mobile_numbers').val());

        var tags = $('#edit-customer-communication-message').find("input#email_tags").tagsinput('items');
        formData.append('email_tags', tags);


        $.ajax(
                {
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    "headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data)
                    {
                        //data: return data from server
                        if (data.status === "error")
                        {
                            icon = "times";
                            messageType = "danger";
                        }

                        //Empty the form fields
                        $("#ajax-response-text").html("");

                        $('.form-group').removeClass('has-error');
                        $('.form-group').removeClass('has-success');
                        $('.help-block-error').remove();

                        formElement.find('#push-text-div').hide();
                        formElement.find('#sms-text-div').hide();
                        formElement.find('#testing-mode-div').hide();

                        var $el = formElement.find("#loyalty_id");
                        $el.empty(); // remove old options
                        $el.append($('<option>', {
                            value: '',
                            text: 'Select Loyalty',
                        }));
                        var $elt = formElement.find("#loyalty_tier_id");
                        $elt.empty(); // remove old options
                        $elt.append($('<option>', {
                            value: '',
                            text: 'Select Loyalty Tier',
                        }));
                        var $elo = formElement.find("#offer_id");
                        $elo.empty(); // remove old options
                        $elo.append($('<option>', {
                            value: '',
                            text: 'Select Offer',
                        }));
                        formElement.find("input[type=text], textarea").val("");
                        formElement.find("#merchant_id").select2("val", "");
                        formElement.find("#loyalty_id").select2("val", "");
                        formElement.find("#loyalty_tier_id").select2("val", "");
                        formElement.find("#offer_id").select2("val", "");

                        formElement.find('#loyalty_id').attr('disabled', true);
                        formElement.find('#loyalty_tier_id').attr('disabled', true);
                        formElement.find('#offer_id').attr('disabled', true);
                        formElement.find("input[name=message_type][value=1]").prop('checked', 'checked');
                        formElement.find("input[name=status][value=1]").prop('checked', 'checked');
                        $.uniform.update();
                        //formElement.find('#offer_image_url').empty();

                        formElement.find('#merchant_id option[value="0"]').prop("selected", true);
                        var validator = formElement.validate();
                        validator.resetForm();
                        formElement[0].reset();

                        //trigger cancel button click event to collapse form and show title of add page
                        $('.edit-form-main').hide();
                        $('.add-form-main').show();

                        $('.collapse.box-expand-form').trigger('click');
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

                        /*setTimeout(function () {
                         window.location.href = document.URL;
                         }, 2000);*/

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
    };

    // method to handle add ajax request and reponse

    var handleAjaxRequest = function (e) {
        var formElement = $(this.currentForm); // Retrive form from DOM and convert it to jquery object
        var actionUrl = formElement.attr("action");
        var actionType = formElement.attr("method");
        var formData = formElement.serialize();
        var formObj = $('#merchant_id').closest("form");
        var currentForm1 = formObj.attr("id");
        currentForm1 = $('#' + currentForm1);
        var icon = "check";
        var messageType = "success";

        if (currentForm1.find('#email').is(':checked') || currentForm1.find('#push_notification').is(':checked') || currentForm1.find('#sms').is(':checked') || currentForm1.find('#sms_notification').is(':checked')) {

        } else {
            var error = 'Please select atleast one Message Notify By.';
            Metronic.alert({
                type: 'danger',
                icon: 'times',
                message: error,
                container: $('#ajax-response-text'),
                place: 'prepend',
                closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
            });
            return false;
        }

        var formData = new FormData();        
        formData.append('merchant_id', currentForm1.find('#merchant_id').val());
        formData.append('loyalty_id', currentForm1.find('#loyalty_id').val());
        formData.append('loyalty_tier_id', currentForm1.find('#loyalty_tier_id').val());

        var defaultEmail = 0;
        if (currentForm1.find('#email').is(':checked')) {
            defaultEmail = 1;
            if ((currentForm1.find('#for_testing').val() == 1) && (currentForm1.find('#test_email_addresses').val() == '')) {
                var error = 'Please enter test email.';
                Metronic.alert({
                    type: 'danger',
                    icon: 'times',
                    message: error,
                    container: $('#ajax-response-text'),
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
                return false;
            }
        }
        formData.append('email', defaultEmail);

        var defaultPushNotification = 0;
        if (currentForm1.find('#push_notification').is(':checked')) {
            defaultPushNotification = 1;
        }
        formData.append('push_notification', defaultPushNotification);
        formData.append('deep_link_screen', currentForm1.find('#deep_link_screen').val());

        var defaultSms = 0;
        if (currentForm1.find('#sms').is(':checked')) {
            defaultSms = 1;
            if ((currentForm1.find('#for_testing').val() == 1) && (currentForm1.find('#test_mobile_numbers').val() == '')) {
                var error = 'Please enter test mobile number.';
                Metronic.alert({
                    type: 'danger',
                    icon: 'times',
                    message: error,
                    container: $('#ajax-response-text'),
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
                return false;
            }
        }
        formData.append('sms', defaultSms);

        var defaultSmsNotification = 0;
        if (currentForm1.find('#sms_notification').is(':checked')) {
            defaultSmsNotification = 1;
            if ((currentForm1.find('#for_testing').val() == 1) && (currentForm1.find('#test_mobile_numbers').val() == '')) {
                var error = 'Please enter test mobile number.';
                Metronic.alert({
                    type: 'danger',
                    icon: 'times',
                    message: error,
                    container: $('#ajax-response-text'),
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
                return false;
            }
        }
        formData.append('sms_notification', defaultSmsNotification);

        var defaultMessageType = 0;
        var radioMessageValue = currentForm1.find("input[name='message_type']:checked").val();
        if (radioMessageValue == 1) {
            defaultMessageType = 1;
        } else if (radioMessageValue == 2) {
            defaultMessageType = 2;
        } else if (radioMessageValue == 3) {
            defaultMessageType = 3;
        }
        formData.append('message_title', currentForm1.find('#message_title').val());
        formData.append('message_type', defaultMessageType);
        formData.append('offer_id', currentForm1.find('#offer_id').val());
        formData.append('product_id', currentForm1.find('#product_id').val());
        formData.append('push_text', currentForm1.find('#push_text').val());
        formData.append('sms_text', currentForm1.find('#sms_text').val());
        //formData.append('image_url', currentForm1.find('#image_url').val());
        formData.append('email_from_name', currentForm1.find('#email_from_name').val());
        formData.append('email_from_email', currentForm1.find('#email_from_email').val());
        formData.append('email_subject', currentForm1.find('#email_subject').val());
        var emailBody = CKEDITOR.instances.email_body.getData()
        formData.append('email_body', emailBody);

        formData.append('message_send_time', currentForm1.find('#message_send_time').val());
        var defaultTodayTime = 0;
        if (currentForm1.find('#send_today').is(':checked')) {
            defaultTodayTime = 1;
        }
        formData.append('send_today', defaultTodayTime);
        formData.append('today_time', currentForm1.find('#today_time').val());

        var defaultStatus = 0;
        var radioStatus = currentForm1.find("input[name='status']:checked").val();
        if (radioStatus == 1) {
            defaultStatus = 1;
        } else if (radioStatus == 0) {
            defaultStatus = 0;
        }
        formData.append('status', defaultStatus);

        formData.append('for_testing', currentForm1.find('#for_testing').val());
        formData.append('test_email_addresses', currentForm1.find('#test_email_addresses').val());
        formData.append('test_mobile_numbers', currentForm1.find('#test_mobile_numbers').val());

        var tags = currentForm1.find("input#email_tags").tagsinput('items');
        formData.append('email_tags', tags);

        $.ajax(
                {
                    url: actionUrl,
                    type: actionType,
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    "headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data)
                    {
                        //data: return data from server
                        if (data.status === "error")
                        {
                            icon = "times";
                            messageType = "danger";
                        }

                        //Empty the form fields
                        $("#ajax-response-text").html("");

                        $('.form-group').removeClass('has-error');
                        $('.form-group').removeClass('has-success');
                        $('.help-block-error').remove();

                        formElement.find('#push-text-div').hide();
                        formElement.find('#sms-text-div').hide();
                        formElement.find('#testing-mode-div').hide();

                        var $el = formElement.find("#loyalty_id");
                        $el.empty(); // remove old options
                        $el.append($('<option>', {
                            value: '',
                            text: 'Select Loyalty',
                        }));
                        var $elt = formElement.find("#loyalty_tier_id");
                        $elt.empty(); // remove old options
                        $elt.append($('<option>', {
                            value: '',
                            text: 'Select Loyalty Tier',
                        }));
                        var $elo = formElement.find("#offer_id");
                        $elo.empty(); // remove old options
                        $elo.append($('<option>', {
                            value: '',
                            text: 'Select Offer',
                        }));
                        formElement.find("input[type=text], textarea").val("");
                        formElement.find("#merchant_id").select2("val", "");
                        formElement.find("#loyalty_id").select2("val", "");
                        formElement.find("#loyalty_tier_id").select2("val", "");
                        formElement.find("#offer_id").select2("val", "");

                        formElement.find('#loyalty_id').attr('disabled', true);
                        formElement.find('#loyalty_tier_id').attr('disabled', true);
                        formElement.find('#offer_id').attr('disabled', true);
                        formElement.find("input[name=message_type][value=1]").prop('checked', 'checked');
                        formElement.find("input[name=status][value=1]").prop('checked', 'checked');
                        $.uniform.update();
                        //formElement.find('#offer_image_url').empty();
                        CKEDITOR.instances.email_body.setData('');
                        formElement.find('#merchant_id option[value="0"]').prop("selected", true);
                        formElement.find("#merchant_id").select2("val", "0");

                        formElement.find("#row-message-send-date-div").show();
                        formElement.find("#date-picker-btn").attr('disabled', false);
                        formElement.find("#message_send_time").prop('disabled', false);
                        formElement.find("#send_today_message").html('');

                        formElement.find('#email_tags').tagsinput('removeAll');
                        var validator = formElement.validate();
                        validator.resetForm();
                        formElement[0].reset();
                        formElement.find('#sms_notification').attr("disabled", false);
                        formElement.find('#push_notification').attr("disabled", false);
                        formElement.find('#sms').attr("disabled", false);
                        //trigger cancel button click event to collapse form and show title of add page
                        $('.edit-form-main').hide();
                        $('.add-form-main').show();

                        $('.collapse.box-expand-form').trigger('click');
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
    };

    var handleTable = function () {

        grid = new Datatable();
        grid.init({
            src: $('#customer-communication-message-table'),
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
                    {data: null, name: 'rownum', searchable: false, orderable: false},
                    {data: 'id', name: 'id', visible: false},
                    {data: 'merchant_loyalty_name', name: 'merchant_loyalty_name', searchable: false, orderable: false},
                    {data: 'notify_type', name: 'notify_type', searchable: false, orderable: false},
                    {data: 'message_type_name', name: 'message_type_name', searchable: false, orderable: false},
                    {data: 'message_title', name: 'message_title', searchable: false, orderable: false},
                    {data: 'message_send_date_time', name: 'message_send_date_time', searchable: false, orderable: false},
                    {data: 'email_count', name: 'email_count', searchable: false, orderable: false},
                    {data: 'sms_count', name: 'sms_count', searchable: false, orderable: false},
                    {data: 'push_notification_count', name: 'push_notification_count', searchable: false, orderable: false},
                    {data: 'push_notification_received_count', name: 'push_notification_received_count', searchable: false, orderable: true},
                    {data: 'status', name: 'status', searchable: false, orderable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
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

                    api.column(10, {page: 'current'}).data().each(function (group, i) {
                        var status = $(rows).eq(i).children('td:nth-child(11)').html();
                        var statusBtn = '';
                        if (status == 1) {
                            statusBtn = '<span class="label label-sm label-success">active</span>';
                        } else {
                            statusBtn = '<span class="label label-sm label-danger">inactive</span>';
                        }
                        $(rows).eq(i).children('td:nth-child(11)').html(statusBtn);
                    });
                },
                "ajax": {
                    "url": "customer-communication-message/data",
                    "type": "GET"
                },
                "order": [
                    [1, "desc"]
                ]// set first column as a default sort by asc
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
    $('body').on("change", "#loyalty_tier_id", function () {
        var formObj = '#'+$(this).closest('form').attr('id');
        if ($(formObj+' #loyalty_tier_id option:selected').val() == 0) {
            //$('#location_id').select2("val", '');
            $(formObj+' #loyalty_tier_id').select2("val", 0);

        }
        
    });
    var getMerchantLoyaltyProgram = function (currentForm) {
        $('body').on('change', '#merchant_id', function (e) {
            var actionUrl = adminUrl + '/customer-communication-message/get-loyalty-program-details/' + $(this).val();

            $.ajax({
                url: actionUrl,
                cache: false,
                type: "GET",
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (data)
                {
                    if (data.loyalty_details != '') {
                        var $el = $('#' + currentForm).find("#loyalty_id");
                        $el.empty();
                        //return false;
                        $('#' + currentForm).find('#loyalty_id').attr('disabled', false);
                        $.each(data.loyalty_details, function (value, key) {
                            $el.append($("<option selected='selected'></option>").attr("value", value).text(key));
                        });

                        var $ell = $('#' + currentForm).find("#loyalty_tier_id");
                        $ell.empty();
                        //$ell.append($("<option></option>").attr("value", '').text('Select Loyalty Tier'));
                        $('#' + currentForm).find('#loyalty_tier_id').attr('disabled', false);
                        
                        /*$.each(data.tier_details, function (value, key) {
                            $ell.append($("<option selected='selected'></option>").attr("value", value).text(key));
                        });*/
                        $ell.select2("val", '');
                        $ell.empty(); // remove old options  
                        $ell.append($('<option>', {
                            value: 0,
                            text: 'All',
                        }));                                          
                        $.each(data.tier_details, function (value, key) {
                            $ell.append($('<option>', {
                                value: value,
                                text: key,
                            }));
                        });

                        //$('#' + currentForm).find("#loyalty_tier_id").select2("val", '');
//                        $('#' + currentForm).find('#gender').attr('disabled', false);

                        var $offer = $('#' + currentForm).find("#offer_id");
                        $offer.empty();
                        $offer.append($("<option></option>").attr("value", '').text('Select Offer'));
                        
                        var $product = $('#' + currentForm).find("#product_id");
                        $product.empty();
                        $product.append($("<option></option>").attr("value", '').text('Select Product'));
                        
                        $('#' + currentForm).find('#email_subject').val('');
                        CKEDITOR.instances.email_body.setData('');
                        $('#' + currentForm).find("input:radio[name='message_type']").each(function () {
                            if ($(this).parent().hasClass('checked')) {
                                if ($(this).attr("value") == 1) {
                                    $('#' + currentForm).find('#offer_id').attr('disabled', false);
                                    $.each(data.offer_list, function (value, key) {
                                        $offer.append($("<option></option>").attr("value", value).text(key));
                                    });
                                    $('#' + currentForm).find("#offer_id").select2("val", '');
                                } else if ($(this).attr("value") == 2) {
                                    $('#' + currentForm).find("#offer_id").select2("val", '');
                                    $('#' + currentForm).find('#offer_id').attr('disabled', true);
                                    $('#' + currentForm).find("#product_id").select2("val", '');
                                    $('#' + currentForm).find('#product_id').attr('disabled', true);
                                } else if ($(this).attr("value") == 3) {
                                    $('#' + currentForm).find('#product_id').attr('disabled', false);
                                    $.each(data.product_list, function (value, key) {
                                        $product.append($("<option></option>").attr("value", value).text(key));
                                    });
                                    $('#' + currentForm).find("#product_id").select2("val", '');

                                }
                            }
                        });

                    } else {

                        var $el = $('#' + currentForm).find("#loyalty_id");
                        $el.empty(); // remove old options
                        $el.append($('<option>', {
                            value: '',
                            text: 'Select Loyalty',
                        }));
                        var $elt = $('#' + currentForm).find("#loyalty_tier_id");
                        $elt.empty(); // remove old options
                        $elt.append($('<option>', {
                            value: '',
                            text: 'Select Loyalty Tier',
                        }));
                        var $elo = $('#' + currentForm).find("#offer_id");
                        $elo.empty(); // remove old options
                        $elo.append($('<option>', {
                            value: '',
                            text: 'Select Offer',
                        }));

                        $('#' + currentForm).find("#merchant_id").select2("val", "");
                        $('#' + currentForm).find("#loyalty_id").select2("val", "");
                        $('#' + currentForm).find("#loyalty_tier_id").select2("val", "");
                        $('#' + currentForm).find("#offer_id").select2("val", "");

                        $('#' + currentForm).find('#loyalty_id').attr('disabled', true);
                        $('#' + currentForm).find('#loyalty_tier_id').attr('disabled', true);
                        $('#' + currentForm).find('#offer_id').attr('disabled', true);
                        $('#' + currentForm).find('#merchant_id option[value="0"]').attr("selected", true);
                        $('#' + currentForm).find("#merchant_id").select2("val", "0");

                    }
                    var $elDeep = $('#' + currentForm).find("#deep_link_screen");
                    $elDeep.empty();
                    $elDeep.append($("<option></option>").attr("value", '').text('Select Deep Link Screen'));
                    $.each(data.merchant_deep_link_screen_list, function (value, key) {
                        $elDeep.append($("<option></option>").attr("value", value).text(key));
                    });
                    
                    //deep link screen disable for merchant offer
                    $('#' + currentForm).find('#deep_link_screen').prop('disabled', false);
                    $('#' + currentForm).find("input:radio[name='message_type']").each(function () {
                        if($(this).parent().hasClass('checked')) {
                            if($(this).attr("value")==1) {                                    
                                if($('#' + currentForm).find('#deep_link_screen option[value="MERCHANT_OFFERS"]').length > 0) {
                                    $('#' + currentForm).find('#deep_link_screen').select2('val', 'MERCHANT_OFFERS');
                                    $('#' + currentForm).find('#deep_link_screen').prop('disabled', true);
                                } 
                                else {
                                    $('#' + currentForm).find('#deep_link_screen').prop('disabled', false);
                                    $('#' + currentForm).find('#deep_link_screen').select2('val', '');
                                }                                
                            } else if($(this).attr("value")==3) { 
                                if($('#' + currentForm).find('#deep_link_screen option[value="MERCHANT_SHOP"]').length > 0) {
                                    $('#' + currentForm).find('#deep_link_screen').select2('val', 'MERCHANT_SHOP');
                                    $('#' + currentForm).find('#deep_link_screen').prop('disabled', true);
                                } else {
                                    $('#' + currentForm).find('#deep_link_screen').prop('disabled', false);
                                    $('#' + currentForm).find('#deep_link_screen').select2('val', '');
                                } 
                            } else {
                               $('#' + currentForm).find('#deep_link_screen').prop('disabled', false);
                               $('#' + currentForm).find('#deep_link_screen').select2('val', '');
                            }
                        }                     
                    });

                },
                error: function (jqXhr, json, errorThrown)
                {
                    var errors = jqXhr.responseJSON;
                    var errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml += value[0] + '<br />';
                    });
                    Metronic.alert({
                        type: 'danger',
                        message: errorsHtml,
                        container: $('#ajax-response-text'),
                        place: 'prepend',
                        closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                    });
                }
            });
        });
    };

    var getMerchantLoyaltyOfferData = function (currentForm) {


        $('body').on('change', '#offer_id', function (e) {
            if ($(this).val() > 0) {

                var actionUrl = adminUrl + '/customer-communication-message/get-merchant-loyalty-offer-data/' + $(this).val();

                $.ajax({
                    url: actionUrl,
                    cache: false,
                    type: "GET",
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (data)
                    {
                        $('#' + currentForm).find('#email_subject').val('');
                        //$('#'+currentForm).find('#image_url').val('');
                        $('#' + currentForm).find('#email_body').val('');
                        //$('#'+currentForm).find("#offer_image_url").html('');

                        $('#' + currentForm).find('#email_subject').val(data.offer_title);
                        /*if (data.image_url != '') {
                         $('#'+currentForm).find('#image_url').val(data.image_url);
                         $('#'+currentForm).find("#offer_image_url").html('<img class="img-thumbnail" src="' + data.image_url + '" alt="' + data.offer_title + '">');
                         }*/
                        CKEDITOR.instances.email_body.setData('<p><img class="img-thumbnail" src="' + data.image_url + '" alt="' + data.offer_title + '"></p>' + data.long_description);
                        //CKEDITOR.instances['email_body'].setReadOnly(true);
                        //currentForm.find('#email_body').val(data.long_description);
                    },
                    error: function (jqXhr, json, errorThrown)
                    {
                        var errors = jqXhr.responseJSON;
                        var errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml += value[0] + '<br />';
                        });
                        Metronic.alert({
                            type: 'danger',
                            message: errorsHtml,
                            container: $('#ajax-response-text'),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });
                    }
                });
            }
        });
    };

    var enableTestingModeDiv = function (currentForm) {
        var currentForm = $('#' + currentForm);
        $('body').on('change', '#for_testing', function (e) {
            if ($('body').find('#for_testing').val() == 1) {
                currentForm.find('#testing-mode-div').show();
            } else {
                currentForm.find('#test_email_addresses').val('');
                currentForm.find('#test_mobile_numbers').val('');
                currentForm.find('#testing-mode-div').hide();
            }
            currentForm.find('#send-email-btn').prop('disabled', true);
            currentForm.find('#send-sms-btn').prop('disabled', true);
            currentForm.find('#test_email_addresses').val('');
            currentForm.find('#test_mobile_numbers').val('');
            if (currentForm.find('#email').is(":checked")) {
                currentForm.find('#send-email-btn').prop('disabled', false);
            } else {
                currentForm.find('#test_email_addresses').val('');
            }
            if (currentForm.find('#sms').is(":checked")) {
                currentForm.find('#send-sms-btn').prop('disabled', false);
            } else {
                currentForm.find('#test_mobile_numbers').val('');
            }
            if (currentForm.find('#sms_notification').is(":checked")) {                
                currentForm.find('#send-sms-btn').prop('disabled', false);
            } else {
                currentForm.find('#test_mobile_numbers').val('');
            }
            if (!(currentForm.find('#sms_notification').is(":checked") || currentForm.find('#sms').is(":checked"))) {
                currentForm.find('#send-sms-btn').prop('disabled', true);
            }
            if (!currentForm.find('#email').is(":checked")) { 
                currentForm.find('#send-email-btn').prop('disabled', true);
            }
        });

    };
    var handleBootstrapMaxlength = function () {
        $('#create-customer-communication-message').find("textarea").maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            placement: 'bottom-left',
            threshold: 10
        });

        $('#edit-customer-communication-message').find("textarea").maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            placement: 'bottom-left',
            threshold: 10
        });

    };

    /*var handleDatePicker = function () {
     if (!jQuery().datetimepicker) {
     return;
     }
     
     $(".form_datetime").datetimepicker({
     autoclose: true,
     isRTL: Metronic.isRTL(),
     format: "dd MM yyyy - hh:ii",
     startDate: '+1d',
     endDate: '+3d',
     pickerPosition: (Metronic.isRTL() ? "bottom-right" : "bottom-left"),
     });
     
     };*/

    var handleDatePicker = function () {
        if (!jQuery().datepicker) {
            return;
        }

        $(".form_datetime").datepicker({
            autoclose: true,
            isRTL:true,
            format: "dd MM yyyy",
            startDate: '+1d',
            //endDate: '+3d',
            pickerPosition: (true ? "bottom-right" : "bottom-left"),
        });

        $(".search_form_datetime").datepicker({
            autoclose: true,
            isRTL: true,
            format: "dd MM yyyy",
            pickerPosition: (true ? "bottom-right" : "bottom-left")
        });

    };

    var showEmailFormDiv = function (currentForm) {
        currentForm = $('#' + currentForm);

        $('body').on('click', '#email', function (e) {
            if ($(this).is(":checked")) {
                currentForm.find('#email-div').show();                
            } else {
                currentForm.find('#email-div').hide();                
                currentForm.find('#test_email_addresses').val('');
            }
            //send test email sms btn enable disable conditions
            if ($(this).is(":checked")) {                         
                    currentForm.find('#send-email-btn').prop('disabled', false);
                if (currentForm.find('#sms').is(":checked") || currentForm.find('#sms_notification').is(":checked")) {
                    currentForm.find('#send-sms-btn').prop('disabled', false);
                } else {
                    currentForm.find('#send-sms-btn').prop('disabled', true);
                }
            } else {
                currentForm.find('#send-email-btn').prop('disabled', true);
            }
        });
        
        
    };

    var showNotificationsFormDiv = function () {
        var formObj = $('#merchant_id').closest("form");
        var currentForm = formObj.attr("id");
        currentForm = $('#' + currentForm);

        $('body').on('click', '#push_notification', function (e) {
            if ($(this).is(":checked") || currentForm.find('#sms_notification').is(":checked")) {
                currentForm.find('#push-text-div').show();
                
                //deep link screen disable for merchant offer
                currentForm.find('#deep_link_screen').prop('disabled', false);
                currentForm.find("input:radio[name='message_type']").each(function () {
                    if($(this).parent().hasClass('checked')) {
                        if($(this).attr("value")==1) {
                            if(currentForm.find('#deep_link_screen option[value="MERCHANT_OFFERS"]').length > 0) {
                                currentForm.find('#deep_link_screen').select2('val', 'MERCHANT_OFFERS');
                                currentForm.find('#deep_link_screen').prop('disabled', true);
                            } else {
                                currentForm.find('#deep_link_screen').prop('disabled', false);
                                currentForm.find('#deep_link_screen').select2('val', '');
                            }
                        } else if($(this).attr("value")==3) {
                            if(currentForm.find('#deep_link_screen option[value="MERCHANT_SHOP"]').length > 0) {
                                currentForm.find('#deep_link_screen').select2('val', 'MERCHANT_SHOP');
                                currentForm.find('#deep_link_screen').prop('disabled', true);
                            } else {
                                currentForm.find('#deep_link_screen').prop('disabled', false);
                                currentForm.find('#deep_link_screen').select2('val', '');
                            }
                        } else {
                            currentForm.find('#deep_link_screen').prop('disabled', false);
                            currentForm.find('#deep_link_screen').select2('val', '');
                        } 

                    }                     
                });
                
                currentForm.find('#sms_notification').attr("disabled", true);
            } else if (currentForm.find('#push_notification').is(":checked") || currentForm.find('#sms').is(":checked")) {
                currentForm.find('#sms_notification').attr("disabled", true);
                currentForm.find('#push-text-div').hide();
            } else {
                currentForm.find('#push-text-div').hide();
                currentForm.find('#sms_notification').attr("disabled", false);
            }
            //send test email sms btn enable disable conditions
            if ($(this).is(":checked")) {
                currentForm.find('#send-email-btn').prop('disabled', true);
                currentForm.find('#send-sms-btn').prop('disabled', true);
                if (currentForm.find('#email').is(":checked")) {
                    currentForm.find('#send-email-btn').prop('disabled', false);
                } else {
                    currentForm.find('#send-email-btn').prop('disabled', true);
                }
                if (currentForm.find('#sms').is(":checked") || currentForm.find('#sms_notification').is(":checked")) {
                    currentForm.find('#send-sms-btn').prop('disabled', false);
                } else {
                    currentForm.find('#send-sms-btn').prop('disabled', true);
                }                
            }
            //condition when only push notification selected and other options not selected
            if ($(this).is(":checked") && (!(currentForm.find('#sms').is(":checked") || currentForm.find('#sms_notification').is(":checked") || currentForm.find('#email').is(":checked")))) {
                currentForm.find('#send-email-btn').prop('disabled', true);
                currentForm.find('#send-sms-btn').prop('disabled', true);
            }
            
        });
    };

    var showSmsFormDiv = function (currentForm) {
        currentForm = $('#' + currentForm);

        $('body').on('click', '#sms', function (e) {
            if ($(this).is(":checked") || currentForm.find('#sms_notification').is(":checked")) {
                currentForm.find('#sms-text-div').show();               
                currentForm.find('#sms_notification').attr("disabled", true);
            } else if (currentForm.find('#push_notification').is(":checked") || currentForm.find('#sms').is(":checked")) {
                currentForm.find('#sms_notification').attr("disabled", true);
                currentForm.find('#sms-text-div').hide();                
                currentForm.find('#test_mobile_numbers').val('');
            } else {
                currentForm.find('#sms-text-div').hide();                
                currentForm.find('#test_mobile_numbers').val('');
                currentForm.find('#sms_notification').attr("disabled", false);
            }
            
           //send test email sms btn enable disable conditions                        
            if ($(this).is(":checked") || currentForm.find('#sms_notification').is(":checked")) {      
                currentForm.find('#send-sms-btn').prop('disabled', false);
                if (currentForm.find('#email').is(":checked")) {
                    currentForm.find('#send-email-btn').prop('disabled', false);
                } else {
                    currentForm.find('#send-email-btn').prop('disabled', true);
                }                                
            } else {
                currentForm.find('#send-sms-btn').prop('disabled', true);
            }
            
        });
    };

    var showSmsAndNotificationsFormDiv = function (currentForm) {
        currentForm = $('#' + currentForm);

        $('body').on('click', '#sms_notification', function (e) {
            if ($(this).is(":checked") || (currentForm.find('#push_notification').is(":checked") && currentForm.find('#sms').is(":checked"))) {
                currentForm.find('#push-text-div').show();
                //deep link screen disable for merchant offer
                currentForm.find('#deep_link_screen').prop('disabled', false);
                currentForm.find("input:radio[name='message_type']").each(function () {
                    if($(this).parent().hasClass('checked')) {
                        if($(this).attr("value")==1) {
                            if(currentForm.find('#deep_link_screen option[value="MERCHANT_OFFERS"]').length > 0) {
                                currentForm.find('#deep_link_screen').select2('val', 'MERCHANT_OFFERS');
                                currentForm.find('#deep_link_screen').prop('disabled', true);
                            } else {                                
                                currentForm.find('#deep_link_screen').prop('disabled', false);
                                currentForm.find('#deep_link_screen').select2('val', '');
                            }
                        } else if($(this).attr("value")==3) {
                            if(currentForm.find('#deep_link_screen option[value="MERCHANT_SHOP"]').length > 0) {
                                currentForm.find('#deep_link_screen').select2('val', 'MERCHANT_SHOP');
                                currentForm.find('#deep_link_screen').prop('disabled', true);
                            } else {                                
                                currentForm.find('#deep_link_screen').prop('disabled', false);
                                currentForm.find('#deep_link_screen').select2('val', '');
                            }
                        } else {
                            currentForm.find('#deep_link_screen').prop('disabled', false);
                            currentForm.find('#deep_link_screen').select2('val', '');
                        } 

                    }                     
                });
                currentForm.find('#sms-text-div').show();                
                currentForm.find('#push_notification').attr("disabled", true);
                currentForm.find('#sms').attr("disabled", true);
            } else {
                currentForm.find('#push-text-div').hide();
                currentForm.find('#sms-text-div').hide();                
                currentForm.find('#test_mobile_numbers').val('');
                currentForm.find('#push_notification').attr("disabled", false);
                currentForm.find('#sms').attr("disabled", false);
            }
            //send test email sms btn enable disable conditions                        
            if ($(this).is(":checked") || currentForm.find('#sms').is(":checked")) {                      
                currentForm.find('#send-sms-btn').prop('disabled', false);                               
                if (currentForm.find('#email').is(":checked")) {
                    currentForm.find('#send-email-btn').prop('disabled', false);
                } else {
                    currentForm.find('#send-email-btn').prop('disabled', true);
                }                                
            } else {
                currentForm.find('#send-sms-btn').prop('disabled', true);
            }
        });
    };

    var sendTodayDiv = function (currentForm) {

        $('body').on('click', '#send_today', function (e) {
            if ($(this).is(":checked")) {
                $('#' + currentForm).find("#row-message-send-date-div").hide();
                if (currentForm !== 'edit-customer-communication-message') {
                    $('#' + currentForm).find("#message_send_time").val('');
                }
                $('#' + currentForm).find("#date-picker-btn").attr('disabled', 'disabled');
                $('#' + currentForm).find("#message_send_time").prop('disabled', true);
                $('#' + currentForm).find("#send_today_message").html('<span class="label label-danger span_send_today_message">NOTE! </span><span class="span_send_today_message" style="margin-left:10px;">You cannot edit this Message/Offer after submission.</span>');
                $('#' + currentForm).find('#message-send-date-div .form-group').removeClass('has-error');
                $('#' + currentForm).find('#message_send_time-error').remove();
                //
            } else {
                $('#' + currentForm).find("#row-message-send-date-div").show();
                $('#' + currentForm).find("#date-picker-btn").attr('disabled', false);
                $('#' + currentForm).find("#message_send_time").prop('disabled', false);
                $('#' + currentForm).find("#send_today_message").html('');
            }
        });
    };

    var handleTimePickers = function () {
        
        if (jQuery().timepicker) {
            var d = new Date();
            var h = d.getHours() + 1;
            var m = d.getMinutes();
            var ampm = '';
            if (h > 12) {
                h = h - 12;
                ampm = 'PM'
            } else {
                ampm = 'AM'
            }
            $('#today_time').timepicker({
                autoclose: true,
                showSeconds: false,
                snapToStep: true,
                minuteStep: 15,
                defaultTime: h + ':' + m + ' ' + ampm
            });

            $('.timepicker').parent('.input-group').on('click', '.input-group-btn', function (e) {
                e.preventDefault();
                $(this).parent('.input-group').find('.timepicker').timepicker('showWidget');
            });
        }
    };

    var sendTestSms = function (currentForm) {
        $('body').on('click', '.send-sms', function (e) {
            var actionUrl = adminUrl + '/customer-communication-message/send-test-sms';

            if ($('#' + currentForm).find('#test_mobile_numbers').val() == '' && $('#' + currentForm).find('#sms_text').val() == '') {
                var error = 'Please enter Message Text and Mobile Number.';
                Metronic.alert({
                    type: 'danger',
                    icon: 'times',
                    message: error,
                    container: $('#ajax-response-text'),
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
                return false;
            }

            var formData = new FormData();
            formData.append('merchant_id', $('#' + currentForm).find('#merchant_id').val());
            formData.append('test_mobile_numbers', $('#' + currentForm).find('#test_mobile_numbers').val());
            formData.append('sms_text', $('#' + currentForm).find('#sms_text').val());

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                "headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data)
                {
                    //$('#' + currentForm).find('#test_mobile_numbers').val('');
                    if (data.status == 'success') {
                        Metronic.alert({
                            type: 'success',
                            icon: 'check',
                            message: data.message,
                            container: $('#ajax-response-text'),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });
                    } else {
                        Metronic.alert({
                            type: 'danger',
                            icon: 'times',
                            message: data.message,
                            container: $('#ajax-response-text'),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });
                    }

                },
                error: function (jqXhr, json, errorThrown)
                {
                    var errors = jqXhr.responseJSON;
                    var errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml += value[0] + '<br />';
                    });
                    Metronic.alert({
                        type: 'danger',
                        message: errorsHtml,
                        container: $('#ajax-response-text'),
                        place: 'prepend',
                        closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                    });
                }
            });
        });
    };

    var sendTestEmail = function (currentForm) {
        $('body').on('click', '.send-email', function (e) {
            var actionUrl = adminUrl + '/customer-communication-message/send-test-email';

            if ($('#' + currentForm).find('#test_email_addresses').val() == '' && $('#' + currentForm).find('#email_from_name').val() == '' && $('#' + currentForm).find('#email_from_email').val() == '' && $('#' + currentForm).find('#email_subject').val() == '') {
                var error = 'Please enter Send Email Data.';
                Metronic.alert({
                    type: 'danger',
                    icon: 'times',
                    message: error,
                    container: $('#ajax-response-text'),
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
                return false;
            }

            var formData = new FormData();
            formData.append('merchant_id', $('#' + currentForm).find('#merchant_id').val());
            formData.append('test_email_addresses', $('#' + currentForm).find('#test_email_addresses').val());
            formData.append('email_from_name', $('#' + currentForm).find('#email_from_name').val());
            formData.append('email_from_email', $('#' + currentForm).find('#email_from_email').val());
            formData.append('email_subject', $('#' + currentForm).find('#email_subject').val());
            var emailBody = CKEDITOR.instances.email_body.getData()
            formData.append('email_body', emailBody);
            formData.append('email_tags', $('#' + currentForm).find('#email_tags').val());

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                "headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data)
                {
                    //$('#' + currentForm).find('#test_email_addresses').val('');
                    if (data.status == 'success') {
                        Metronic.alert({
                            type: 'success',
                            icon: 'check',
                            message: data.message,
                            container: $('#ajax-response-text'),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });
                    } else {
                        Metronic.alert({
                            type: 'danger',
                            icon: 'times',
                            message: data.message,
                            container: $('#ajax-response-text'),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });
                    }

                },
                error: function (jqXhr, json, errorThrown)
                {
                    var errors = jqXhr.responseJSON;
                    var errorsHtml = '';
                    $.each(errors, function (key, value) {
                        errorsHtml += value[0] + '<br />';
                    });
                    Metronic.alert({
                        type: 'danger',
                        message: errorsHtml,
                        container: $('#ajax-response-text'),
                        place: 'prepend',
                        closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                    });
                }
            });
        });
    };

    $.validator.addMethod('validWebUrl', function (value) {
        var url_validate = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if (!url_validate.test(value) && value != '') {
            return false;
        } else {
            return true;
        }
    }, 'Please enter Valid URL.');

    $.validator.addMethod("validEmail", function (value, element)
    {
        return this.optional(element) || /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test(value);
    }, "Please enter a valid Email Address.");

    $.validator.addMethod('validPushText', function (value, element) {
        var formElement = $(element).closest("form");
        var formId = formElement.attr("id");
        if ($('#' + formId).find('#push_notification').is(':checked') || $('#' + formId).find('#sms_notification').is(':checked')) {
            if ($.trim(value) == '') {
                return false;
            } else {
                return true;
            }
        }

    }, 'Please enter Notification Text.');

    $.validator.addMethod('validDeepLinkScreen', function (value, element) {
        var formElement = $(element).closest("form");
        var formId = formElement.attr("id");
        if ($('#' + formId).find('#push_notification').is(':checked') || $('#' + formId).find('#sms_notification').is(':checked')) {
            if ($.trim(value) == '') {
                return false;
            } else {
                return true;
            }
        }

    }, 'Please select Deep Link Screen.');

    $.validator.addMethod('validSmsText', function (value, element) {
        var formElement = $(element).closest("form");
        var formId = formElement.attr("id");
        if ($('#' + formId).find('#sms').is(':checked') || $('#' + formId).find('#sms_notification').is(':checked')) {
            if ($.trim(value) == '') {
                return false;
            } else {
                return true;
            }
        }

    }, 'Please enter Message Text.');

    $.validator.addMethod('validEmailFromName', function (value, element) {
        var formElement = $(element).closest("form");
        var formId = formElement.attr("id");
        if ($('#' + formId).find('#email').is(':checked')) {
            if ($.trim(value) == '') {
                return false;
            } else {
                return true;
            }
        }
    }, 'Please enter Sender Name.');

    $.validator.addMethod('validEmailFromEmail', function (value, element) {
        var formElement = $(element).closest("form");
        var formId = formElement.attr("id");
        if ($('#' + formId).find('#email').is(':checked')) {
            if ($.trim(value) == '') {
                return false;
            } else {
                return true;
            }
        }
    }, 'Please enter Sender Email.');

    $.validator.addMethod('validEmailSubject', function (value, element) {
        var formElement = $(element).closest("form");
        var formId = formElement.attr("id");
        if ($('#' + formId).find('#email').is(':checked')) {
            if ($.trim(value) == '') {
                return false;
            } else {
                return true;
            }
        }
    }, 'Please enter Email Subject.');

    $.validator.addMethod('validEmailBody', function (value, element) {
        var formElement = $(element).closest("form");
        var formId = formElement.attr("id");
        if ($('#' + formId).find('#email').is(':checked')) {
            if (CKEDITOR.instances.editor1.updateElement()) {
                return false;
            } else {
                return true;
            }
        }
    }, 'Please enter Email Body.');


    var checkPastTime = function () {
        $('body').on('change', '#today_time', function (e) {
            var formElement = $('#merchant_id').closest("form");
            var currentForm = formElement.attr("id");
            var currentFormObj = $('#' + currentForm);
            if (currentFormObj.find('#send_today').parent('span').hasClass('checked')) {
                var todayTime = $(this).val();
                var actionUrl = adminUrl + '/customer-communication-message/check-past-time/' + todayTime;
                $.ajax({
                    url: actionUrl,
                    cache: false,
                    dataType: "json",
                    type: "GET",
                    success: function (data)
                    {
                        currentFormObj.find('#today_time-error').html('');
                        if (data.status == 'error') {
                            currentFormObj.find('#today_time-error').html('Send Notification Time should be greater than current time.');
                            $("form").submit(function (e) {
                                e.preventDefault();
                            });
                            return false;
                        } else {
                            currentFormObj.find('#today_time-error').html('');
                            return true;
                        }

                    },
                    error: function (jqXhr, json, errorThrown)
                    {
                        var errors = jqXhr.responseJSON;
                        var errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml += value[0] + '<br />';
                        });
                        Metronic.alert({
                            type: 'danger',
                            message: errorsHtml,
                            container: $('#ajax-response-text'),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });
                    }
                });
            }
        });
    }


    var changeMessageType = function (currentForm) {
        console.log('inside changeMessageType');
        $('body').on('change', "input:radio[name='message_type']", function (e) {
            console.log('i am on line 1779');
            if ($('#' + currentForm).find('#offer_id').val() == '') {
                $('#' + currentForm).find('#email_subject').val('');
                //CKEDITOR.instances.email_body.setData('');
                var actionUrl = adminUrl + '/customer-communication-message/get-loyalty-program-details/' + $('#' + currentForm).find('#merchant_id').val();

                $.ajax({
                    url: actionUrl,
                    cache: false,
                    type: "GET",
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (data)
                    {

                        var $offer = $('#' + currentForm).find("#offer_id");
                        $offer.empty();
                        $offer.append($("<option></option>").attr("value", '').text('Select Offer'));
                        
                        var $product = $('#' + currentForm).find("#product_id");
                        $product.empty();
                        $product.append($("<option></option>").attr("value", '').text('Select Product'));

                        $('#' + currentForm).find("input:radio[name='message_type']").each(function () {
                            if ($(this).parent().hasClass('checked')) {
                                if ($(this).attr("value") == 1) {
                                    console.log('selected is 1 :')
                                    $('#' + currentForm).find('#offer_id').attr('disabled', false);
                                    $.each(data.offer_list, function (value, key) {
                                        $offer.append($("<option></option>").attr("value", value).text(key));
                                    });
                                    $('#' + currentForm).find("#offer_id").select2("val", '');                                   
                                    
                                    $product.empty();
                                    $product.append($("<option></option>").attr("value", '').text('Select Product'));                                    
                                    $product.select2("val", '');      
                                    $product.attr('disabled', true);      
                                    
                                    
                                    if($('#' + currentForm).find('#deep_link_screen option[value="MERCHANT_OFFERS"]').length > 0) {
                                        $('#' + currentForm).find('#deep_link_screen').select2('val', 'MERCHANT_OFFERS');
                                        $('#' + currentForm).find('#deep_link_screen').prop('disabled', true);
                                    } else {
                                        $('#' + currentForm).find('#deep_link_screen').prop('disabled', false);
                                        $('#' + currentForm).find('#deep_link_screen').select2('val', '');
                                    }
                                    
                                } else if ($(this).attr("value") == 2) {
                                    console.log('selected is 2 :')
                                    $('#' + currentForm).find('#email_subject').val('');
                                    $('#' + currentForm).find('#email_body').html('');
                                    CKEDITOR.instances.email_body.setData('');
                                    $offer.empty();
                                    $offer.append($("<option></option>").attr("value", '').text('Select Offer'));
                                    $('#' + currentForm).find('#offer_id').attr('disabled', true);
                                    
                                    $product.empty();
                                    $product.append($("<option></option>").attr("value", '').text('Select Product'));
                                    $product.select2("val", '');      
                                    $product.attr('disabled', true);                                    
                                    
                                    $('#' + currentForm).find('#deep_link_screen').prop('disabled', false);
                                    $('#' + currentForm).find('#deep_link_screen').select2("val", '');

                                } else if ($(this).attr("value") == 3) {
                                    console.log('selected is 3 :')
                                    $('#' + currentForm).find('#email_subject').val('');
                                    $('#' + currentForm).find('#email_body').html('');
                                    CKEDITOR.instances.email_body.setData('');
                                    
                                    $('#' + currentForm).find('#product_id').attr('disabled', false);
                                    $.each(data.product_list, function (value, key) {
                                        $product.append($("<option></option>").attr("value", value).text(key));
                                    });
                                    $('#' + currentForm).find("#product_id").select2("val", '');
                                    
                                    $offer.empty();
                                    $offer.append($("<option></option>").attr("value", '').text('Select Offer'));
                                    $('#' + currentForm).find('#offer_id').attr('disabled', true);
                                    
                                    if($('#' + currentForm).find('#deep_link_screen option[value="MERCHANT_SHOP"]').length > 0) {
                                        $('#' + currentForm).find('#deep_link_screen').select2('val', 'MERCHANT_SHOP');
                                        $('#' + currentForm).find('#deep_link_screen').prop('disabled', true);
                                    } else {
                                        $('#' + currentForm).find('#deep_link_screen').prop('disabled', false);
                                        $('#' + currentForm).find('#deep_link_screen').select2('val', '');
                                    }

                                }
                            }
                        });

                    }, error: function (jqXhr, json, errorThrown) {
                        var $elo = $('#' + currentForm).find("#offer_id");
                        $elo.empty(); // remove old options
                        $elo.append($('<option>', {
                            value: '',
                            text: 'Select Offer',
                        }));
                        $('#' + currentForm).find("#offer_id").select2("val", "");
                    }
                });
            } else {
                $('#' + currentForm).find("input:radio[name='message_type']").each(function () {
                    if ($(this).parent().hasClass('checked')) {
                        if ($(this).attr("value") == 1) {
                            $('#' + currentForm).find('#offer_id').attr('disabled', false);
                        } else if ($(this).attr("value") == 2) {
                            $('#' + currentForm).find("#offer_id").select2("val", '');
                            $('#' + currentForm).find('#offer_id').attr('disabled', true);
                            $('#' + currentForm).find("#product_id").select2("val", '');
                            $('#' + currentForm).find('#product_id').attr('disabled', true);
                            $('#' + currentForm).find('#email_subject').val('');
                            CKEDITOR.instances.email_body.setData('');                            
                        } else if ($(this).attr("value") == 3) {
                            $('#' + currentForm).find('#product_id').attr('disabled', false);
                            $('#' + currentForm).find("#offer_id").select2("val", '');
                            $('#' + currentForm).find('#offer_id').attr('disabled', true);
                            $('#' + currentForm).find('#email_subject').val('');
                            CKEDITOR.instances.email_body.setData('');                            
                        }
                    }
                });
            }
        });
    };




    return {
        //main function to initiate the module
        init: function (obj) {
            console.log(obj);
            initializeListener();
           // handleTable();
            fetchDataForEdit();
            handleBootstrapMaxlength();
            getMerchantLoyaltyProgram(obj);
            getMerchantLoyaltyOfferData(obj);
            handleDatePicker();
            enableTestingModeDiv(obj);
            showEmailFormDiv(obj);
            showNotificationsFormDiv(obj);
            showSmsFormDiv(obj);
            handleTimePickers();
            sendTodayDiv(obj);
            showSmsAndNotificationsFormDiv(obj);
            sendTestSms(obj);
            sendTestEmail(obj);
            checkPastTime();
            changeMessageType(obj);
            //bind the validation method to 'add' form on load
            siteObjJs.validation.formValidateInit('#'+obj, handleAjaxRequest);
            $('#'+obj).find('input:checkbox').uniform();
            $('#'+obj).find('input:radio').uniform();
        }

    };
}();