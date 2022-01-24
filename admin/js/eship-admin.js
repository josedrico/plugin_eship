(function($){
    eshipBtTbQuotation();
    modalInsertToken();
    selectElement();
    clickGetShipment();

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
        $('#dashBoardEshipModalToggle').on('click', 'button[name="shipment"]',function (e) {
            e.preventDefault();
            let url = $('#result-custom').data('url');
            let data = $(this).data('shipment');

            if (data != '') {
                $.ajax({
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
                            $('#spinner-load-data').remove();
                            $('#shipmentModalToggleLabel2').html(`Your Label`);
                            $('.create-shipment').html(createPdfIframe(data.result));
                        } else {
                            $('#spinner-load-data').remove();
                            $('#shipmentModalToggleLabel2').html(`ERROR`);
                            $.each(data.result.messages, function (index, object) {
                                newObj.push({
                                    source: `${imgCarriersPacks({
                                        src: (object.source).toLowerCase(),
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

    function eshipBtTbQuotation() {
        $('a[href="#dashBoardEshipModalToggle"]').on('click',function () {
            let result  = $('#result-custom').data('result');
            let url = $('#result-custom').data('url');
            let newData = [];

            if (typeof result != 'undefined' && result.hasOwnProperty('Status') && result.Error) {
                $('#dashBoardEshipModalToggleLabel > i').remove();
                $('#dashBoardEshipModalToggleLabel > span').remove();
                $('#dashBoardEshipModalToggleLabel').html(`<span id="title-error-api" class="text-danger"><i class="fas fa-exclamation-circle"></i>${result.Status}</span>`);
                $('.message-api').html(messageApi(result));
                $('.message-api').show();
            } else {
                if ((result.messages).length > 0) {
                    //console.log('result', result.rates);
                    $.each(result.rates, function (index, object) {
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
                    $('#custom-eship-messages').hide();
                    $('#custom-eship-rates').show();
                    bsTb({
                            id: '#custom-eship-rates',
                            search: false,
                            pagination: false
                        },
                        newData
                    );
                } else {
                    //console.log('result.messages', result.messages);
                    $.each(result.messages, function (index, object) {
                        newData.push({
                            source: `${imgCarriersPacks((object.source).toLowerCase())}`,
                            text: object.text,
                        });
                    });
                    $('#custom-eship-messages').show();
                    $('#custom-eship-rates').hide();
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
        $('#tokenEshipModalBtn').on('click', function (e) {
            //e.preventDefault();
            let formDataToken = $('#token-input-eship').val();
            let formDataCs = $('#cs-input-eship').val();
            let formDataCk = $('#ck-input-eship').val();
            let formPhoneCompany = $('#phone-input-eship').val();
            let formNameCompany = $('#name-input-eship').val();

            $("#tokenEshipModalForm").validate({
                rules: {
                    apiKey: {
                        required: true
                    },
                    customerSecret: {
                        required: true
                    },
                    customerKey: {
                        required: true
                    },
                    phoneCompany: {
                        required: true,
                        digits: true
                    },
                    nameCompany: {
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
            error: function (d, x, v) {
                console.error('d', d);
                console.error('x', x);
                console.error('v', v);
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
})(jQuery);