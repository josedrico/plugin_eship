(function($){
    modalInsertToken();

    function modalInsertToken() {
        $('#tokenEshipModalBtn').on('click', function () {
            let formDataToken = $('#token-input-eship').val();
            let formPhoneCompany = $('#phone-input-eship').val();
            let formNameCompany = $('#name-input-eship').val();
            let formEmailCompany = $('#email-input-eship').val();

            $("#tokenEshipModalForm").validate({
                rules: {
                    apiKeyEship: {
                        required: true
                    },
                    phoneCompanyEship: {
                        required: true,
                        digits: true
                    },
                    nameCompanyEship: {
                        required: true
                    },
                    emailCompanyEship: {
                        required: true
                    }
                },
                success: function(label) {
                    label.addClass("valid").css('color','green').text('Valid')
                },
                submitHandler: function(form) {
                    let $data = {
                        method: 'POST',
                        url: eshipData.url,
                        content: {
                            action: 'insert_token_eship',
                            nonce: eshipData.security,
                            token: formDataToken,
                            phone: formPhoneCompany,
                            name: formNameCompany,
                            email: formEmailCompany,
                            dimensions: 1,
                            typeAction: 'add_token'
                        },
                        type: 'json'
                    };
                    ajaxEship($data);
                }
            });
        });
    }

    function ajaxEship($data) {
        $('#loader-light').show();
        $.ajax({
            method: $data.method,
            url: $data.url,
            data: $data.content,
            dataType: $data.type,
            success: function (data) {
                $('#loader-light').hide();
                console.log('ajaxEship', data);
                if (!data.show) {
                    if (data.error) {
                        swal({
                            title: "Error! " + ((typeof data.message != 'undefined')? data.message : ''),
                            icon: "error",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            title: "Done! " + ((typeof data.message != 'undefined')? data.message : ''),
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    }
                }
            },
            error: function (error) {
                console.log(error);
                swal({
                    title: "Error! " + error,
                    icon: "error",
                }).then((value) => {
                    //console.log(value)
                    location.reload();
                });
            }
        });
    }
})(jQuery);