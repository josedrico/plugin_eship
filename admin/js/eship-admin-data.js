(function($){

    getQuotationEship();
    selectElement();
    clickGetShipment();
    modalOrdersEship();
    modalShipmentEship();
    getDimensionsEship();

    clickDelDimEship();
    clickEditDimEship();
    changeStatusDimEship();
    changeStatusActiveEship();
    closeReload();

    function checkErrorsEshipWooConn() {
        let $data = {
            method: 'POST',
            url: eshipData.url,
            content: {
                action: 'get_check_woo_errors_eship',
                nonce: eshipData.security,
                typeAction: 'check_woo_errors_all'
            },
            type: 'json'
        };

        $.ajax({
            method: $data.method,
            url: $data.url,
            data: $data.content,
            dataType: $data.type,
        }).then((data) => {
            console.log('error', data);
            if (data.error) {
                $('#woocommerce-order-eship').remove();
                $('#bulk-action-selector-top option[value="eship_quotations"]').remove();
                swal({
                    title: "Error!",
                    text: data.message + "\nESHIP",
                    icon: "error",
                });
                return true;
            } else {
                return false;
            }

        }).fail((error)=> {
            console.error(error)
            return true;
        });
    }

    function closeReload() {
        $('#show-pdf-eship').click(function () {
            location.reload();
        });

        $('#shipmentPdfModal .btn-close').click(function(){
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

    function ajaxEship($data) {
        $.ajax({
            method: $data.method,
            url: $data.url,
            data: $data.content,
            dataType: $data.type,
            success: function (data) {
                console.log(data);
                if (data.error == false) {
                    if (data.redirect) {
                        $('#loader-light').show()
                        location.reload();
                    } else if (data.updateEffect) {
                        if (!data.error) {
                            swal({
                                title: "Done! " + ((typeof data.message != 'undefined')? data.message : ''),
                                icon: "success",
                            }).then((value) => {
                                //console.log(value)
                                location.reload();
                            });
                        } else {
                            swal({
                                title: "Error! " + ((typeof data.message != 'undefined')? data.message : ''),
                                icon: "error",
                            }).then((value) => {
                                location.reload();
                                //console.log(value)
                            });
                        }
                    } else {
                        swal({
                            title: "Error! " + ((typeof data.message != 'undefined')? data.message : ''),
                            icon: "error",
                        }).then((value) => {
                            location.reload();
                        });
                    }
                } else {
                    swal({
                        title: "Error! " + ((typeof data.message != 'undefined')? data.message : ''),
                        icon: "error",
                    }).then((value) => {
                        if (typeof data.result.resource != 'undefined' && data.result.resource == 'eshipDimWeModal') {
                            console.log(data.result);
                            let modal = new bootstrap.Modal(document.getElementById('eshipDimWeModal'));
                            let modalShow = document.getElementById('eshipDimWeModal');
                            modal.show(modalShow);
                        } else {
                            location.reload();
                        }
                    });
                    $('#loader-light').hide()
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
            //e.preventDefault();
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
                    console.log(data);
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
                                        width: 'w-15',
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
                console.log('imagen', result.rates);
                $.each(result.rates, function (index, object) {
                    //console.log(object);
                    let heigth = '';
                    let width = 'w-25'
                    if (object.provider == 'UPS') {
                        heigth = 'h-25'
                        width = 'w-10'
                    }

                    if (object.provider == 'FedEx') {
                        width = 'w-15'
                        heigth = 'h-15'
                    }
                    newMessage.push({
                        carrier: `${imgCarriersPacks({
                            src: object.provider_image_75,
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
            }
        }
    }

    function modalOrdersEship(){

        let url = window.location;
        let str = url.href;
        let segment = str.split(/countEship/i);
        if (segment.length > 1) {
            let modal = new bootstrap.Modal(document.getElementById('ordersQuotationsEshipModalToggle'));
            let modalShow = document.getElementById('ordersQuotationsEshipModalToggle');
            modal.show(modalShow);
            let orders =  $('#ordersQuotationsEshipModalToggle').data('orders-eship');
            if (typeof orders != 'undefined' && orders != '') {
                $.ajax({
                    method: 'POST',
                    url:  eshipData.url,
                    data: {
                        action: 'get_quotation_orders_eship',
                        nonce: eshipData.security,
                        orders,
                        typeAction: 'add_quotation_orders'
                    },
                    dataType: 'json',
                    success: function (data) {
                        //console.log(data);
                        $('#spinner-eship-orders').remove();

                        let selectFun = function (data) {
                            let html = `<select class="form-select" name="order${data.increment}">`;
                            let rates = data.rates;
                            if (rates != 'undefined') {
                                $.each(rates, function (i, o) {
                                    //console.log(i);
                                    let sel = '';
                                    if (i == 0) {
                                        sel = 'selected';
                                    }
                                    html += `<option value="${o.rate_id}_${data.orderId}_${data.id}_${o.servicelevel.name}" ${sel}>
                                            ${o.provider} ${o.servicelevel.name} / ${o.days} days / ${o.base_charge} ${o.currency} 
                                            </option>`;
                                });
                            }
                            html += `</select>`;

                            return html;
                        };

                        if (! data.error) {
                            let newArr = [];
                            $.each(data.result, function (i,o) {
                                //console.log(i, o);
                                let provArr = [];
                                $.each(o.rates, function (index, prov) {
                                    //console.log(prov.provider);
                                    provArr.push(prov.provider);
                                });

                                newArr.push({
                                    order: `${o.order_id} (${o.date_final})`,
                                    ship: 'Not specified',//`${(provArr.length > 0)? provArr.join(' / ') : provArr.join('')}`,
                                    services: `${selectFun({
                                        increment: i,
                                        id: o.object_id,
                                        rates: o.rates,
                                        orderId: o.order_id
                                    })}`,
                                });
                            });

                            //console.log(newArr);
                            $('#orders-multiple-eship').show();
                            bsTb({
                                    id: '#orders-multiple-eship',
                                    search: false,
                                    pagination: false
                                },
                                newArr
                            );
                        } else {
                            let html = '';
                            $.each(data.result, function (index, object) {
                                console.log(object);
                                html +=  messageApi({
                                    Error: data.result
                                });
                                /*messageApi({
                                    Error: data.result
                                });*/
                            });
                            console.log(html);
                            $('#orders-multiple-eship-div').append(html);
                            $('#error-eship-dim-w').show();
                            $('#orders-multiple-eship').hide();
                        }
                    },
                    error: function (error) {
                        $('#spinner-eship-orders').remove();
                        $('#orders-multiple-eship-div').append(
                            messageApi({
                                Error: error.responseText
                            })
                        );
                        $('#error-eship-dim-w').show();
                        console.error('error', error.responseText);
                    }
                });
            }
        }
    }

    function modalShipmentEship(){
        $('#ordersQuotationsEshipModalToggleBtn').on('click', function () {
            let select = $('#ordersModalForms').serializeArray();
            //console.log('modalShipmentEship', select);
            if (select.length > 0) {
                $.ajax({
                    method: 'POST',
                    url:  eshipData.url,
                    data: {
                        action: 'get_shipments_orders_eship',
                        nonce: eshipData.security,
                        content: select,
                        typeAction: 'add_shipments'
                    },
                    dataType: 'json',
                    success: function (data) {
                        //console.log(data);
                        $('#spinner-eship-orders-pdf').remove();
                        if (! data.error && data.result.status == 'SUCCESS'){
                            let newArr = [];
                            let nameUser = data.res;
                            let types = data.types;
                            let fulfillment = data.result.batch_labels;
                            $.each(fulfillment, function (i,o) {
                                //console.log('o', o);
                                if (o.status == 'SUCCESS') {
                                    newArr.push({
                                        order: o.fulfillment.order_num,
                                        client: nameUser[i],
                                        services: `<strong>${o.provider}</strong> ${types[i]}`,
                                        trackingNumber: `<a href="${o.tracking_url_provider}" target="_blank">${o.tracking_number}</a>`,
                                        tracking: `<a class="page-title-action btn btn-light" href="${o.label_url}" target="_blank">Download Label <i class="fas fa-file-pdf"></i></a>`,
                                        //label_url
                                        //tracking_url_provider
                                    });
                                } else {
                                    $('#orders-multiple-eship-div').show();
                                    $.each( fulfillment, function (i,o) {
                                        $.each( o.messages, function (ind,obj) {
                                            $('#orders-multiple-eship-div').append(messageApi({
                                                bg: 'alert-white',
                                                svg: '<span class="dashicons dashicons-info-outline"></span>',
                                                Error: `<strong>${obj.source}</strong> - ${obj.text}`
                                            }));
                                        });
                                        //console.log('error',o.messages);
                                    });
                                }
                            });
                            //orders-multiple-eship-pdf
                            $('#orders-multiple-eship-pdf').show();
                            $('#ordersMultipleLabels').append(`<a class="btn btn-secondary" target="_blank" href="${data.result.batch_labels_url}">Download</a>`);
                            bsTb({
                                    id: '#orders-multiple-eship-pdf',
                                    search: false,
                                    pagination: false
                                },
                                newArr
                            );
                        }
                    },
                    error: function (d, x, v) {
                        console.error('d', d);
                        console.error('x', x);
                        console.error('v', v);
                    }
                });
            }
        });
    }

    function clickDelDimEship() {
        $('#eship-dim-weigth').on('click', 'tr button[data-eship="deleted"]',function () {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    //console.log(willDelete);
                    if (willDelete) {
                        let delId = $(this).data('dim-delete-id');

                        let $data = {
                            method: 'POST',
                            url: eshipData.url,
                            content: {
                                action: 'delete_dimensions_eship',
                                nonce: eshipData.security,
                                delId,
                                typeAction: 'delete_dimension'
                            },
                            type: 'json'
                        };

                        ajaxEship($data);
                    } else {
                        swal("Your data is safe!");
                    }
                });
        });
    }

    function clickEditDimEship() {
        $('#eship-dim-weigth').on('click', 'button[data-dim-btn-id]',function (e) {
            //e.preventDefault()
            let dataForm = $(this).data('dim-btn-id');
            //console.log(dataForm);
            $("#eshipDimEditModalForm" + dataForm).validate({
                rules: {
                    aliasEship: {
                        required: true
                    },
                    lengthEship: {
                        required: true
                    },
                    widthEship: {
                        required: true
                    },
                    heightEship: {
                        required: true
                    },
                    unitDimensionsEship: {
                        required: true
                    },
                    weightEship: {
                        required: true
                    },
                    unitWeigthEship: {
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
                            action: 'update_dimensions_eship',
                            nonce: eshipData.security,
                            typeAction: 'update_dimensions',
                            dim: dataForm,//$('button[data-dim-btn-id]').data('dim-btn-id'),
                            aliasEship: $('#alias-input-eship' + dataForm).val(),
                            lengthEship: $('#length-input-eship'+ dataForm).val(),
                            widthEship: $('#width-input-eship'+ dataForm).val(),
                            heightEship: $('#height-input-eship'+ dataForm).val(),
                            unitDimensionsEship: $('#unit-input-eship'+ dataForm).val(),
                            weightEship: $('#weigth-input-eship'+ dataForm).val(),
                            unitWeigthEship: $('#unitWeigth-input-eship'+ dataForm).val()
                        },
                        type: 'json'
                    };
                    ajaxEship($data);
                }
            });
        });
    }

    function changeStatusDimEship(){
        $('#eship-dim-weigth').on('click', 'input[data-status-dim-eship]',function () {
            if (typeof $(this).data('dim-id') != 'undefined') {
                let dimId = $(this).data('dim-id');
                let input = $(this).val();
                console.log(input);
                let $data = {
                    method: 'POST',
                    url: eshipData.url,
                    content: {
                        action: 'update_dimensions_eship',
                        nonce: eshipData.security,
                        dimId,
                        status: input,
                        typeAction: 'update_status_dimension'
                    },
                    type: 'json'
                };
                //console.log($data);
                ajaxEship($data);
            }

        });
    }

    function changeStatusActiveEship(){
        $('#radioDimSts2').on('click',function () {
            console.log($(this).is(':checked'));

            let $data = {
                method: 'POST',
                url: eshipData.url,
                content: {
                    action: 'update_token_eship',
                    nonce: eshipData.security,
                    status: 'default',
                    typeAction: 'update_status_dimension'
                },
                type: 'json'
            };
            //console.log($data);
            ajaxEship($data);
        });

        $('#radioDimSts1').on('click',function () {
            console.log($(this).is(':checked'));
            let $data = {
                method: 'POST',
                url: eshipData.url,
                content: {
                    action: 'update_token_eship',
                    nonce: eshipData.security,
                    status: 'template',
                    typeAction: 'update_status_dimension'
                },
                type: 'json'
            };
            //console.log($data);
            ajaxEship($data);
        });
    }

})(jQuery);