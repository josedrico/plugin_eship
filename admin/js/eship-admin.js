(function($){
    /**
     * Load functions
     */
    modalInsertTokenEship();
    modalUpdateTokenEship();
    modalInsertDimensionsEship();
    getDimensionsEship();
    modalInsertDimensionsEship();
    modalEditDimensionsEship();
    deleteDimensionsEship();
    changeStatusDimEship();
    changeStatusActiveEship();
    modalQuotationsEship();
    modalShipmentsEship();
    getQuotationEship();
    getShipmentEship();
    closeReloadEship();

    /**
     * Abstract
     */
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
                            text: (typeof data.msgText != 'undefined' && data.msgText != '')? data.msgText : '',
                            icon: "error",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        swal({
                            title: "Done! " + ((typeof data.message != 'undefined')? data.message : ''),
                            text: (typeof data.msgText != 'undefined')? data.msgText : '',
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
                    location.reload();
                });
            }
        });
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

    function closeReloadEship() {
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

    /**
     * Api key Ajax
     */
    function modalInsertTokenEship() {
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

    function modalUpdateTokenEship() {
        $('#updateDataEshipModalBtn').on('click', function () {
            let formDataToken = $('#token-input-eship').val();
            let formPhoneCompany = $('#phone-input-eship').val();
            let formNameCompany = $('#name-input-eship').val();
            let formEmailCompany = $('#email-input-eship').val();
            let user =  $('#updateDataEshipModalForm').data('user');

            $("#updateDataEshipModalForm").validate({
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
                            action: 'update_token_eship',
                            nonce: eshipData.security,
                            token: formDataToken,
                            phone: formPhoneCompany,
                            name: formNameCompany,
                            email: formEmailCompany,
                            user,
                            typeAction: 'update_token'
                        },
                        type: 'json'
                    };
                    ajaxEship($data);
                }
            });
        });
    }

    /**
     * Dimensions Ajax
     */
    function getDimensionsEship() {
        $('#nav-package-tab').on('click', function () {
            $('#loader-light').show();
            $.ajax({
                method: 'POST',
                url:  eshipData.url,
                data: {
                    action: 'get_dimensions_eship',
                    nonce: eshipData.security,
                    typeAction: 'get_dimensions'
                },
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    $('#loader-light').hide();
                    if (data.error) {
                        swal({
                            title: "Error! " + data.message,
                            icon: "error",
                        }).then((value) => {
                            $('#eship-dim-weigth').hide();
                            let modal = new bootstrap.Modal(document.getElementById('eshipDimWeModal'));
                            let modalShow = document.getElementById('eshipDimWeModal');
                            modal.show(modalShow);
                        });
                    } else {
                        let newArr = [];
                        $.each(data.result, function (index, object) {
                            let yes = '';
                            if (object.status == 1) {
                                yes = 'checked="true"';
                            }

                            let no = '';
                            if (object.status == 0) {
                                no = 'checked="true"';
                            }
                            newArr.push({
                                name: object.name,
                                length_dim: object.length_dim,
                                width_dim: object.width_dim,
                                height_dim: object.height_dim,
                                unit_dim: object.unit_dim,
                                weight_w: object.weight_w,
                                unit_w: object.unit_w,
                                status: `<div class="btn-group-vertical" role="group" aria-label="EShip Status">
                                          <input data-status-dim-eship data-dim-id="${object.id}" type="radio" class="btn-check" name="btnStatusEship${index}" value="1" id="btnradio${index}_yes" autocomplete="off" ${yes}>
                                          <label class="btn btn-outline-primary w-100" for="btnradio${index}_yes">
                                                <span class="dashicons dashicons-products"></span> Per product
                                          </label>
                                        
                                          <input data-status-dim-eship data-dim-id="${object.id}" type="radio" class="btn-check" name="btnStatusEship${index}" value="0" id="btnradio${index}_no" autocomplete="off" ${no}>
                                          <label class="btn btn-outline-primary" for="btnradio${index}_no">
                                            <span class="dashicons dashicons-archive"></span> Per Order
                                          </label>
                                        </div>`,
                                actions: `<button type="button" data-eship="edit" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editEshipDimModal${object.id}">
                                            <span class="dashicons dashicons-edit"></span>
                                          </button>
                                          <button type="button" data-eship="deleted" class="btn btn-outline-danger" data-dim-delete-id="${object.id}">
                                              <span class="dashicons dashicons-table-row-delete"></span>
                                          </button>
                                          <!-- Modal -->
                                          <div class="modal fade" id="editEshipDimModal${object.id}" tabindex="-1" aria-labelledby="editEshipDimModalLabel${object.id}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editEshipDimModalLabel${object.id}">Edit ${object.name}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                  <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-10 offset-sm-1">
                                                            <form method="post" action="" class="row" id="eshipDimEditModalForm${object.id}" data-form-eship="${object.id}">
                                                                <div class="col-12">
                                                                    <div class="mb-2">
                                                                        <label for="length-input-eship${object.id}" class="col-form-label">
                                                                            Alias:
                                                                        </label>
                                                                        <input type="text" class="form-control" id="alias-input-eship${object.id}" name="aliasEship" value="${object.name}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <h5>Dimensions</h5>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-2">
                                                                        <label for="length-input-eship${object.id}" class="col-form-label">
                                                                            Length:
                                                                        </label>
                                                                        <input type="text" class="form-control" id="length-input-eship${object.id}" name="lengthEship" value="${object.length_dim}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-2">
                                                                        <label for="width-input-eship${object.id}" class="col-form-label">
                                                                            Width:
                                                                        </label>
                                                                        <input type="text" class="form-control" id="width-input-eship${object.id}" name="widthEship" value="${object.width_dim}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-2">
                                                                        <label for="height-input-eship${object.id}" class="col-form-label">
                                                                            Height:
                                                                        </label>
                                                                        <input type="text" class="form-control" id="height-input-eship${object.id}" name="heightEship" value="${object.height_dim}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-2">
                                                                        <label for="unit-input-eship${object.id}" class="col-form-label">
                                                                            Unit:
                                                                        </label>
                                                                        <select class="form-select" name="unitDimensionsEship" id="unit-input-eship${object.id}">
                                                                            <option value="cm" ${(object.unit_dim == 'cm')? 'selected':'' }>cm</option>
                                                                            <option value="in" ${(object.unit_dim == 'in')? 'selected':'' }>in</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <h5>Weight</h5>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-2">
                                                                        <label for="weight-input-eship${object.id}" class="col-form-label">
                                                                            Weight:
                                                                        </label>
                                                                        <input type="text" class="form-control" id="weigth-input-eship${object.id}" name="weightEship" value="${object.weight_w}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-2">
                                                                        <label for="unitWeigth-input-eship${object.id}" class="col-form-label">
                                                                            Unit:
                                                                        </label>
                                                                        <select class="form-select" name="unitWeigthEship" id="unitWeigth-input-eship${object.id}">
                                                                            <option value="kg" ${(object.unit_w == 'kg')? 'selected':'' }>kg</option>
                                                                            <option value="lb" ${(object.unit_dim == 'lb')? 'selected':'' }>lb</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="row g-1 mb-4">
                                                                    <div class="col-12 col-md-6">
                                                                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <button type="submit" class="btn btn-primary w-100" id="eshipDimEditModalBtn${object.id}" data-dim-btn-id="${object.id}">
                                                                            <span class="dashicons dashicons-saved"></span>
                                                                            <div id="loader-light" class="spinner-border text-light" role="status" style="width: 1.2rem; height: 1.2rem; display: none;">
                                                                                <span class="visually-hidden">Loading...</span>
                                                                            </div>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>`
                            });
                        });
                        $('#eship-dim-weigth').show();
                        bsTb({
                            id: '#eship-dim-weigth',
                            search: false,
                            pagination: false
                        }, newArr);
                    }
                },
                error: function (error) {
                    console.error('error', error);
                }
            });
        });
    }

    function modalInsertDimensionsEship() {
        $('#eshipDimWeModalBtn').on('click', function () {
            $('#loader-light').show()
            $("#eshipDimWeModalForm").validate({
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
                            action: 'insert_dimensions_eship',
                            nonce: eshipData.security,
                            typeAction: 'add_dimensions',
                            aliasEship: $('#alias-input-eship').val(),
                            lengthEship: $('#length-input-eship').val(),
                            widthEship: $('#width-input-eship').val(),
                            heightEship: $('#height-input-eship').val(),
                            unitDimensionsEship: $('#unit-input-eship').val(),
                            weightEship: $('#weigth-input-eship').val(),
                            unitWeigthEship: $('#unitWeigth-input-eship').val(),
                            statusEship: 1
                        },
                        type: 'json'
                    };
                    ajaxEship($data);
                }
            });
        });
    }

    function modalEditDimensionsEship() {
        $('#eship-dim-weigth').on('click', 'button[data-dim-btn-id]',function () {
            let dataForm = $(this).data('dim-btn-id');
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
                            dim: dataForm,
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

    function deleteDimensionsEship() {
        $('#eship-dim-weigth').on('click', 'tr button[data-eship="deleted"]',function () {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
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

    function changeStatusDimEship(){
        $('#eship-dim-weigth').on('click', 'input[data-status-dim-eship]',function () {
            if (typeof $(this).data('dim-id') != 'undefined') {
                let dimId = $(this).data('dim-id');
                let input = $(this).val();

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
                ajaxEship($data);
            }
        });
    }

    function changeStatusActiveEship(){
        $('#radioDimSts2').on('click',function () {
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
            ajaxEship($data);
        });

        $('#radioDimSts1').on('click',function () {
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
            ajaxEship($data);
        });
    }

    function modalQuotationsEship(){

        let url = window.location;
        let str = url.href;
        let segment = str.split(/countEship/i);
        
        if (segment.length > 1) {
            let modal = new bootstrap.Modal(document.getElementById('ordersQuotationsEshipModalToggle'));
            let modalShow = document.getElementById('ordersQuotationsEshipModalToggle');
            modal.show(modalShow);
            let orders = $('#ordersQuotationsEshipModalToggle').data('orders-eship');
            $('#ordersQuotationsEshipModalToggleBtn').attr('disabled', true);

            if (typeof orders != 'undefined' && (orders != '' || orders != 0)) {
                $.ajax({
                    method: 'POST',
                    url:  eshipData.url,
                    data: {
                        action: 'get_quotations_orders_eship',
                        nonce: eshipData.security,
                        orders,
                        typeAction: 'add_quotations_orders'
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#ordersQuotationsEshipModalToggleBtn').attr('disabled', false);
                        //console.log('modalQuotationsEship', data);
                        $('#spinner-eship-orders').remove();

                        let selectFun = function (data) {
                            let html = `<select class="form-select" name="order${data.increment}">`;
                            let rates = data.rates;
                            if (rates != 'undefined') {
                                $.each(rates, function (i, o) {
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
                                let provArr = [];
                                $.each(o.rates, function (index, prov) {
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
                                html +=  messageApi({
                                    Error: data.result
                                });
                            });

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

    function modalShipmentsEship(){
        $('#ordersQuotationsEshipModalToggleBtn').on('click', function () {
            let select = $('#ordersModalForms').serializeArray();

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
                        //console.log('modalShipmentsEship', data);
                        $('#spinner-eship-orders-pdf').remove();
                        let status = data.result;
                        //console.log('status', status.result.status);
                        if (! data.error && status.result.status == "SUCCESS"){
                            let result = data.result;
                            //console.log('result', result);
                            let newArr = [];
                            let nameUser = result.res;
                            let types = result.types;
                            let fulfillment = result.result.batch_labels;

                            $.each(fulfillment, function (i,o) {
                                if (o.status == 'SUCCESS') {
                                    newArr.push({
                                        order: o.fulfillment.order_num,
                                        client: nameUser[i],
                                        services: `<strong>${o.provider}</strong> ${types[i]}`,
                                        trackingNumber: `<a href="${o.tracking_url_provider}" target="_blank">${o.tracking_number}</a>`,
                                        tracking: `<a class="page-title-action btn btn-light" href="${o.label_url}" target="_blank">Download Label <i class="fas fa-file-pdf"></i></a>`,
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
                                    });
                                }
                            });
                            $('#orders-multiple-eship-pdf').show();
                            $('#ordersMultipleLabels').append(`<a class="btn btn-secondary" target="_blank" href="${result.result.batch_labels_url}">Download</a>`);
                            bsTb({
                                    id: '#orders-multiple-eship-pdf',
                                    search: false,
                                    pagination: false
                                },
                                newArr
                            );
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            }
        });
    }

    function getQuotationEship() {
        $('button[href="#dashBoardEshipModalToggle"]').on('click', function () {
            let order =  $('button[href="#dashBoardEshipModalToggle"]').data('order');
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
                    //console.log('getQuotationEship', data);
                    $('#spinner-load-data-q').remove();
                    if (data.error) {
                        $('#orders-list').append(messageApi({
                            Error: data.result
                        }));
                    } else {
                        if (typeof data.result.object_id != 'undefined') {
                            eshipBtTbQuotation({
                                result: data.result,
                                order: order
                            });
                        }
                    }
                },
                error: function (error) {
                    console.error('d', error);
                }
            });
        });
    }

    function eshipBtTbQuotation($data) {
        $('#spinner-load-data-q').remove();
        let url = $('#app-eship-url').data('url');
        let newMessage = [];
        let result = $data.result;

        if (typeof result != 'undefined' && result.hasOwnProperty('Status') && result.Error) {
            $('#dashBoardEshipModalToggleLabel > i').remove();
            $('#dashBoardEshipModalToggleLabel > span').remove();
            $('#dashBoardEshipModalToggleLabel').html(`<span id="title-error-api" class="text-danger"><i class="fas fa-exclamation-circle"></i>${result.Status}</span>`);
            $('.message-api').html(messageApi(result));
            $('.message-api').show();
        } else {
            if (typeof result.rates != 'undefined') {
                //console.log('eshipBtTbQuotation', result.rates);
                $.each(result.rates, function (index, object) {
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
                        action	: `<button name="shipment" data-order="${$data.order}" data-shipment="${object.rate_id}" class="page-title-action shipment" data-bs-target="#shipmentModalToggle2" data-bs-toggle="modal">Create Label</button>`
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

            if (typeof result.messages != 'undefined') {
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

    function getShipmentEship() {
        $('#dashBoardEshipModalToggle').on('click', 'button[name="shipment"]',function (e) {
            e.preventDefault();
            let url = $('#app-eship-url').data('url');
            let data = $(this).data('shipment');
            let order = $(this).data('order');

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
                        //console.log('getShipmentEship', data);

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
                                        src: object.provider_image_75,
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

})(jQuery);