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

})(jQuery);