eshipBtTbQuotation();
modalInsertToken();
selectElement();
clickGetShipment();

function bsTb(config, data) {
    jQuery(`${config.id}`).bootstrapTable({
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
    return `<div ${(id)? "id=" + id : ''} class="alert alert-danger alert-dismissible fade show" role="alert">
                ${data.Error}
            </div>`;
}

function imgCarriersPacks(data) {
    return `<img class="img-fluid w-25" src="${data.url}admin/img/paqueterias/${data.src}.png">`;
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

function clickGetShipment() {
    jQuery('#dashBoardEshipModalToggle').on('click', 'button[name="shipment"]',function (e) {
        e.preventDefault();
        let url = jQuery('#result-custom').data('url');
        let data = jQuery(this).data('shipment');

        if (data != '') {
            jQuery.ajax({
                method: 'POST',
                url: eshipData.url,
                data: {
                    action: 'get_shipment_eship',
                    nonce: eshipData.security,
                    rateId: data,
                    typeAction: 'create_shipment'
                },
                dataType: 'json',
                success: function (data) {
                    let newObj = [];

                    if (data.result.status != 'ERROR') {
                        jQuery('#spinner-load-data').remove();
                        jQuery('#shipmentModalToggleLabel2').html(`Your Label`);
                        jQuery('.create-shipment').html(createPdfIframe(data.result));
                    } else {
                        jQuery('#spinner-load-data').remove();
                        jQuery('#shipmentModalToggleLabel2').html(`ERROR`);
                        jQuery.each(data.result.messages, function (index, object) {
                            newObj.push({
                                source: `${imgCarriersPacks({
                                    src: (object.source).toLowerCase(),
                                    url
                                })}`,
                                text: object.text
                            });
                        });
                        jQuery('#pack-eship-messages').show();
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

function eshipBtTbQuotation() {
    jQuery('a[href="#dashBoardEshipModalToggle"]').click(function () {
        let result  = jQuery('#result-custom').data('result');
        let url = jQuery('#result-custom').data('url');
        let newData = [];

        if (typeof result != 'undefined' && result.hasOwnProperty('Status') && result.Error) {
            jQuery('#dashBoardEshipModalToggleLabel > i').remove();
            jQuery('#dashBoardEshipModalToggleLabel > span').remove();
            jQuery('#dashBoardEshipModalToggleLabel').html(`<span id="title-error-api" class="text-danger"><i class="fas fa-exclamation-circle"></i>${result.Status}</span>`);
            jQuery('.message-api').html(messageApi(result));
            jQuery('.message-api').show();
        } else {
            if ((result.messages).length > 0) {
                //console.log('result', result.rates);
                jQuery.each(result.rates, function (index, object) {
                    //console.log(object);
                    newData.push({
                        carrier: `${imgCarriersPacks({
                            src: (object.provider).toLowerCase(),
                            url
                        })}`,
                        service: `${object.servicelevel.name}`,
                        estimatedDelivery	: `${object.days} days`,
                        amount	: `${object.amount} ${object.currency}`,
                        action	: `<button name="shipment" data-shipment="${object.rate_id}" class="page-title-action shipment" data-bs-target="#shipmentModalToggle2" data-bs-toggle="modal">Create Label</button>`
                    })

                });
                jQuery('#custom-eship-messages').hide();
                jQuery('#custom-eship-rates').show();
                bsTb({
                        id: '#custom-eship-rates',
                        search: false,
                        pagination: false
                    },
                    newData
                );
            } else {
                //console.log('result.messages', result.messages);
                jQuery.each(result.messages, function (index, object) {
                    newData.push({
                        source: `${imgCarriersPacks((object.source).toLowerCase())}`,
                        text: object.text,
                    });
                });
                jQuery('#custom-eship-messages').show();
                jQuery('#custom-eship-rates').hide();
                bsTb({
                    id: '#custom-eship-messages',
                        search: false,
                        pagination: false
                }, newData);
            }
        }
    });
}

function modalInsertToken() {
    jQuery('#tokenEshipModalBtn').on('click', function () {
        let formDataToken = jQuery('#token-input-eship').val();
        let formDataCs = jQuery('#cs-input-eship').val();
        let formDataCk = jQuery('#ck-input-eship').val();
        let formPhoneCompany = jQuery('#phone-input-eship').val();
        let formNameCompany = jQuery('#name-input-eship').val();
        let inc = 0;

        jQuery('#errorsTokenDiv').remove();
        jQuery('#errorsCsDiv').remove();
        jQuery('#errorsCkDiv').remove();
        jQuery('#errorsPhoneDiv').remove();
        jQuery('#errorsNameDiv').remove();

        if (formDataToken == '') {
            jQuery('#errorsToken').append(messageApi({
                Error: 'El campo token no puede estar vacío'
            }, 'errorsTokenDiv'));
            inc += 1;
        }

        if (formDataCs == '') {
            jQuery('#errorsCs').append(messageApi({
                Error: 'El campo Consumer Secret no puede estar vacío'
            }, 'errorsCsDiv'));
            inc += 1;
        }

        if (formDataCk == '') {
            jQuery('#errorsCk').append(messageApi({
                Error: 'El campo Consumer Key no puede estar vacío'
            }, 'errorsCkDiv'));
            inc += 1;
        }

        if (formNameCompany == '') {
            jQuery('#errorsName').append(messageApi({
                Error: 'El campo Name Company no puede estar vacío'
            }, 'errorsNameDiv'));
            inc += 1;
        }

        if (formPhoneCompany == '') {
            jQuery('#errorsPhone').append(messageApi({
                Error: 'El campo Phone Company no puede estar vacío'
            }, 'errorsPhoneDiv'));
            inc += 1;
        }

        if (inc == 0) {

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
}

function ajaxEship($data) {
    jQuery.ajax({
        method: $data.method,
        url: $data.url,
        data: $data.content,
        dataType: $data.type,
        success: function (data) {
            if (data.error == false) {
                if (data.redirect) {
                    jQuery('#loader-light').show()
                    location.reload();
                } else {
                    return data;
                }
            } else {
                jQuery('#loader-light').hide()
            }
        },
        error: function (d, x, v) {
            console.error('d', d);
            console.error('x', x);
            console.error('v', v);
        }
    });
}

function selectElement() {
    if (jQuery('#template-orders') && jQuery('.card').hasClass('show-quotes')) {
        jQuery('#template-orders').show();
    }

    if (jQuery('#custom')) {
        jQuery('#custom').hide();
    }
    if (jQuery('#multipiece')) {
        jQuery('#multipiece').hide();
    }
    if (jQuery('section')) {
        //console.log(select);
        jQuery('section').click(function(){
            switch (jQuery(this).data('select')) {
                case 'template-orders':
                    jQuery('#template-orders').removeClass('show-quotes');
                    jQuery('#template-orders').show();
                    jQuery('#custom').hide();
                    jQuery('#multipiece').hide();
                    break;
                case 'custom':
                    jQuery('#template-orders').hide();
                    jQuery('#custom').show();
                    jQuery('#multipiece').hide();
                    break;
                case 'multipiece':
                    jQuery('#template-orders').hide();
                    jQuery('#custom').hide();
                    jQuery('#multipiece').show();
                    break;
                default:
                    //console.log('sin section');
                    break;
            }
        });
    }
}
