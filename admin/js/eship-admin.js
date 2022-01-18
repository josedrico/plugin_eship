eshipBtTbQuotation();
modalInsertToken();
selectElement();

function bsTb(id, data) {
    jQuery(`${id}`).bootstrapTable({
        toggle: 'table',
        search: true,
        searchHighlight: true,
        searchOnEnterKey: true,
        showSearchButton: true,
        iconsPrefix: 'dashicons',
        icons: {
            search: 'dashicons-search'
        },
        searchAlign: 'left',
        pagination: true,
        sidePagination: "server",
        pageList: "[25, 50, 100, ALL]",
        pageSize: "25",
        data: data
    });
}

function messageApi(data) {
    return `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${data.Error}
            </div>`;
}

function imgCarriersPacks(data) {
    return `<img class="img-fluid w-50" src="/wp-content/plugins/plugin_eship/admin/img/paqueterias/${data}.png">`;
}

function redirectQuotesEship(href, btnClass, contentText, moreClass = '') {
    let html = `<a class="btn btn-${btnClass}${moreClass} w-100" href="/wp-admin/admin.php?page=${href}">
                    ${contentText}
                </a>`;

    return html;
}

function eshipBtTbQuotation() {
    jQuery('a[href="#dashBoardEshipModalToggle"]').click(function () {
        let result  = jQuery('#result-custom').data('result');
        //console.log(result);
        let newData = [];

        if (typeof result != 'undefined' && result.hasOwnProperty('Status') && result.Error) {
            jQuery('#dashBoardEshipModalToggleLabel > i').remove();
            jQuery('#dashBoardEshipModalToggleLabel > span').remove();
            jQuery('#dashBoardEshipModalToggleLabel').html(`<span id="title-error-api" class="text-danger"><i class="fas fa-exclamation-circle"></i>${result.Status}</span>`);
            jQuery('.message-api').html(messageApi(result));
            jQuery('.message-api').show();
        } else {
            if ((result.rates).length > 0) {
                console.log('result', result.rates);
                jQuery.each(result.rates, function (index, object) {
                    console.log(object);
                    newData.push({
                        carrier: `${imgCarriersPacks((object.provider).toLowerCase())}`,
                        service: `${object.provider}`,
                        estimatedDelivery	: `${object.servicelevel.name}`,
                        amount	: `${object.amount} ${object.currency}`,
                        action	: `<a href="${object.object_id}">${object.provider}</a>`
                    })

                });
                jQuery('#custom-eship-messages').hide();
                jQuery('#custom-eship-rates').show();
                bsTb('#custom-eship-rates', newData);
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
                bsTb('#custom-eship-messages', newData);
            }
        }

        /*jQuery.ajax({
            url: '/wp-admin/admin-ajax.php?action=get_quotation_data_eship',
        }).done(function (data) {
            console.log(data);
            /
        });*///.fail(function (data) {
        //bsTb('#quotes', false);
        //});
    });
}

function modalInsertToken() {
    jQuery('#tokenEshipModalBtn').on('click', function (e) {
        e.preventDefault();
        let formData = jQuery('#token-input-eship').val();

        if (formData != '') {

            let $data = {
                method: 'POST',
                url: eshipData.url,
                content: {
                    action: 'insert_token_eship',
                    nonce: eshipData.security,
                    token: formData,
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
                console.log('success', data);
                //reload
                if (data.redirect != undefined) {
                    setTimeout(function () {
                        location.href = data.redirect
                    }, 1300);
                } else {
                    return data;
                }
            } else {
                console.log('error datos', data);
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
                    console.log('sin section');
                    break;
            }
        });
    }
}
