(function($){
    getQuotationEship();
    modalInsertToken();
    modalUpdateToken();
    selectElement();
    clickGetShipment();
    closeReload();

    function closeReload() {
        $('#show-pdf-eship').click(function () {
            location.reload();
        });

        $('#show-pdf-eship-top').click(function () {
            location.reload();
        })
    }

    function bsTb(config, data) {
        $(`${config.id}`).bootstrapTable({
            toggle: 'table',
            search: config.search,
            searchHighlight: true,
            searchOnEnterKey: true,
            showSearchButton: true,
            iconsPrefix: 'dashicons',
            icons: {
                search: 'dashicons-search'
            },
            searchAlign: 'left',
            pagination: config.pagination,
            sidePagination: "server",
            pageList: "[25, 50, 100, ALL]",
            pageSize: "25",
            data: data
        });
    }

    function messageApi(data, id = false) {
        return `<div ${(id)? "id=" + id : ''} class="alert ${(data.bg != undefined)? data.bg : 'alert-danger'} alert-dismissible fade show ${(data.margin != 'undefined')? data.margin : FALSE}" role="alert">
                ${(data.svg != 'undefined')? data.svg : FALSE } ${data.Error}
            </div>`;
    }

    function imgCarriersPacks(data) {
        return `<img class="img-fluid ${data.heigth} ${data.width}" src="${data.src}">`;
    }

    function createPdfIframe(data) {
        return `<p>
                Tracking number: <a href="https://app.myeship.co/en/track/track?no=${data.tracking_number}" target="_blank">${data.tracking_number}</a>
            </p>
            <div class="ratio ratio-16x9">
              <iframe src="${data.label_url}" title="${data.provider}" allowfullscreen></iframe>
            </div>`;
    }

    function redirectQuotesEship(href, btnClass, contentText, moreClass = '') {
        let html = `<a class="btn btn-${btnClass}${moreClass} w-100" href="/wp-admin/admin.php?page=${href}">
                    ${contentText}
                </a>`;

        return html;
    }

    function modalInsertToken() {
        $('#tokenEshipModalBtn').on('click', function (e) {
            //e.preventDefault();
            let formDataToken = $('#token-input-eship').val();
            let formDataCs = $('#cs-input-eship').val();
            let formDataCk = $('#ck-input-eship').val();
            let formPhoneCompany = $('#phone-input-eship').val();
            let formNameCompany = $('#name-input-eship').val();

            $("#tokenEshipModalForm").validate({
                rules: {
                    apiKeyEship: {
                        required: true
                    },
                    customerSecretEship: {
                        required: true
                    },
                    customerKeyEship: {
                        required: true
                    },
                    phoneCompanyEship: {
                        required: true,
                        digits: true
                    },
                    nameCompanyEship: {
                        required: true
                    }
                },
                success: function(label) {
                    label.addClass("valid").css('color','green').text('Valid')
                },
                submitHandler: function(form) {
                    console.log(form);
                    let $data = {
                        method: 'POST',
                        url: eshipData.url,
                        content: {
                            action: 'insert_token_eship',
                            nonce: eshipData.security,
                            token: formDataToken,
                            cs: formDataCs,
                            ck: formDataCk,
                            phone: formPhoneCompany,
                            name: formNameCompany,
                            typeAction: 'add_token'
                        },
                        type: 'json'
                    };
                    ajaxEship($data);
                }
            });
        });
    }

    function modalUpdateToken() {
        $('#updateDataEshipModalBtn').on('click', function (e) {
            //console.log('updateDataEshipModalBtn');
            //e.preventDefault();
            let formDataToken = $('#token-input-eship').val();
            let formDataCs = $('#cs-input-eship').val();
            let formDataCk = $('#ck-input-eship').val();
            let formPhoneCompany = $('#phone-input-eship').val();
            let formNameCompany = $('#name-input-eship').val();
            let formEmailCompany = $('#email-input-eship').val();
            let user =  $('#updateDataEshipModalForm').data('user');

            $("#updateDataEshipModalForm").validate({
                rules: {
                    apiKeyEship: {
                        required: true
                    },
                    customerSecretEship: {
                        required: true
                    },
                    customerKeyEship: {
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
                    //console.log(form);
                    let $data = {
                        method: 'POST',
                        url: eshipData.url,
                        content: {
                            action: 'update_token_eship',
                            nonce: eshipData.security,
                            token: formDataToken,
                            cs: formDataCs,
                            ck: formDataCk,
                            phone: formPhoneCompany,
                            name: formNameCompany,
                            email: formEmailCompany,
                            user,
                            typeAction: 'update_token'
                        },
                        type: 'json'
                    };
                    //console.log($data);
                    ajaxEship($data);
                }
            });
        });
    }

    function ajaxEship($data) {
        $.ajax({
            method: $data.method,
            url: $data.url,
            data: $data.content,
            dataType: $data.type,
            success: function (data) {
                if (data.error == false) {
                    if (data.redirect) {
                        $('#loader-light').show()
                        location.reload();
                    } else {
                        return data;
                    }
                } else {
                    $('#loader-light').hide()
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function selectElement() {
        if ($('#template-orders') && jQuery('.card').hasClass('show-quotes')) {
            $('#template-orders').show();
        }

        if ($('#custom')) {
            $('#custom').hide();
        }
        if (jQuery('#multipiece')) {
            $('#multipiece').hide();
        }
        if ($('section')) {
            //console.log(select);
            $('section').click(function(){
                switch ($(this).data('select')) {
                    case 'template-orders':
                        $('#template-orders').removeClass('show-quotes');
                        $('#template-orders').show();
                        $('#custom').hide();
                        $('#multipiece').hide();
                        break;
                    case 'custom':
                        $('#template-orders').hide();
                        $('#custom').show();
                        $('#multipiece').hide();
                        break;
                    case 'multipiece':
                        $('#template-orders').hide();
                        $('#custom').hide();
                        $('#multipiece').show();
                        break;
                    default:
                        //console.log('sin section');
                        break;
                }
            });
        }
    }

    function getQuotationEship() {
        $('button[href="#dashBoardEshipModalToggle"]').on('click', function (e) {
            e.preventDefault();
            let order =  $('button[href="#dashBoardEshipModalToggle"]').data('order');
            //console.log(order);
            $.ajax({
                method: 'POST',
                url:  eshipData.url,
                data: {
                    action: 'get_quotation_eship',
                    nonce: eshipData.security,
                    order_id: order,
                    typeAction: 'add_quotation'
                },
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    $('#spinner-load-data-q').remove();
                    if (data.error) {
                        $('#orders-list').append(messageApi({
                            Error: data.result
                        }));
                    } else {
                        if (data.result.object_id != 'undefined') {
                            //console.log(data.result.object_id);
                            eshipBtTbQuotation(data.result, data.order);
                        }
                    }
                },
                error: function (d, x, v) {
                    console.error('d', d);
                    console.error('x', x);
                    console.error('v', v);
                }
            });
        });
    }

    function clickGetShipment() {
        $('#dashBoardEshipModalToggle').on('click', 'button[name="shipment"]',function (e) {
            e.preventDefault();
            let url = $('#app-eship-url').data('url');
            let data = $(this).data('shipment');
            let order = $(this).data('order');
            console.log(url, data);

            if (data != '') {
                $.ajax({
                    method: 'POST',
                    url: eshipData.url,
                    data: {
                        action: 'get_shipment_eship',
                        nonce: eshipData.security,
                        rateId: data,
                        order,
                        typeAction: 'create_shipment'
                    },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);

                        let newObj = [];

                        if (data.result.status != 'ERROR') {
                            $('#spinner-load-data').remove();
                            $('#shipmentModalToggleLabel2').html(`Your Label`);
                            $('.create-shipment').html(createPdfIframe(data.result));
                        } else {
                            $('#spinner-load-data').remove();
                            $('#shipmentModalToggleLabel2').html(`ERROR`);
                            $.each(data.result.messages, function (index, object) {
                                newObj.push({
                                    source: `${imgCarriersPacks({
                                        src: object.provider_image_75,//(object.source).toLowerCase(),
                                        url
                                    })}`,
                                    text: object.text
                                });
                            });
                            $('#pack-eship-messages').show();
                            bsTb({
                                id: '#pack-eship-messages',
                                search: false,
                                pagination: false
                            }, newObj);
                        }
                    }
                });
            }
        });
    }

    function eshipBtTbQuotation(result, order) {
        $('#spinner-load-data-q').remove();
        let url = $('#app-eship-url').data('url');
        let newMessage = [];

        if (typeof result != 'undefined' && result.hasOwnProperty('Status') && result.Error) {
            $('#dashBoardEshipModalToggleLabel > i').remove();
            $('#dashBoardEshipModalToggleLabel > span').remove();
            $('#dashBoardEshipModalToggleLabel').html(`<span id="title-error-api" class="text-danger"><i class="fas fa-exclamation-circle"></i>${result.Status}</span>`);
            $('.message-api').html(messageApi(result));
            $('.message-api').show();
        } else {
            if (result.rates != 'undefined') {
                //console.log('result', result.rates);
                $.each(result.rates, function (index, object) {
                    //console.log(object);
                    let heigth = '';
                    let width = 'w-25'
                    if (object.provider == 'UPS') {
                        heigth = 'h-25'
                        width = 'w-10'
                    }
                    newMessage.push({
                        carrier: `${imgCarriersPacks({
                            src: object.provider_image_75,//(object.provider).toLowerCase(),
                            url,
                            heigth,
                            width
                        })}`,
                        service: `<strong>${object.provider}</strong> ${object.servicelevel.name}`,
                        estimatedDelivery	: `${object.days} days`,
                        amount	: `${object.amount} ${object.currency}`,
                        action	: `<button name="shipment" data-order="${order}" data-shipment="${object.rate_id}" class="page-title-action shipment" data-bs-target="#shipmentModalToggle2" data-bs-toggle="modal">Create Label</button>`
                    })

                });
                $('#custom-eship-rates').show();
                bsTb({
                        id: '#custom-eship-rates',
                        search: false,
                        pagination: false
                    },
                    newMessage
                );
            }

            if (result.messages != 'undefined') {
                $('#custom-eship-messages').show();
                $.each( result.messages, function (i,o) {
                    $('#custom-eship-messages').append(messageApi({
                        bg: 'alert-white',
                        svg: '<span class="dashicons dashicons-info-outline"></span>',
                        Error: `<strong>${o.source}</strong> - ${o.text}`
                    }));
                });
                /*
                bsTb({
                    id: '#custom-eship-messages',
                    search: false,
                    pagination: false
                }, result.messages);
                 */
            }
        }
    }
})(jQuery);