siteObjJs.admin.categoryJs = function () {
    var maxImageSize = 2097152;
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
        
        $("body").on('change', '.cat_image_name', function () {
            var billSelectError = '';
            var form = $(this).closest("form");
            var formId = form.attr("id");
            if (typeof (FileReader) != "undefined") {
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.png|.bmp)$/;
                if (regex.test(this.files[0].name.toLowerCase())) {
                    if (this.files[0].size > maxImageSize) {
                        billSelectError += this.files[0].name + ' is not selected. Maximum image size allowed is 2MB only.';
                        $('input[type="file"]').val(null);
                        $('#' + formId + " span#file-error-container").attr("style", "color: red").text(billSelectError).addClass('help-block-error');
                        setTimeout(function(){
                            $('#' + formId + " span#file-error-container").text("").removeClass('help-block-error');
                        }, 3000);
                        return false;
                    }
                } else {
                    $('input[type="file"]').val(null);
                    $('#' + formId + " span#file-error-container").attr("style", "color: red").text(this.files[0].name + " is not a valid image file.").addClass('help-block-error');
                    setTimeout(function(){
                        $('#' + formId + " span#file-error-container").text("").removeClass('help-block-error');
                    }, 3000);
                    return false;
                }
            } else {
                console.log("This browser does not support HTML5 FileReader.");
            }
        });

        $("body").on('click', '#remove-btn', function () {
            var r = confirm("Are you sure you want to delete this image?");
            if (r == true) {
                var rowId = $(this).attr('data-image-id');
                $("#blank-row-"+rowId).remove();
                if($("#dvPreview").children().length == 0) {
                    $(".category-image-div").remove();
                    $("#cat_image_name").removeAttr('disabled');
                }
            }
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

    return {
        //main function to initiate the module
        init: function () {
            initializeListener();
            //bind the validation method to 'add' form on load
            siteObjJs.validation.formValidateInit('#create-category-master', handleAjaxRequest);
        }

    };
}();