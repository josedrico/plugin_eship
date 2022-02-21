<div id="app-eship-url" class="container app-eship-config" data-url="<?php echo  ESHIP_PLUGIN_DIR_URL;?>">
    <div class="mt-3">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-6 offset-md-6">
                <div id="eship-card" class="card mb-3">
                    <div class="row g-0">
                        <?php if(isset($img_title)):?>
                            <div class="offset-md-8 col-md-4">
                                <img src="<?php echo $img_title;?>" class="img-fluid rounded-start" alt="Eship Logo">
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row me-5 ms-5">
            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-connection-tab" data-bs-toggle="tab" data-bs-target="#nav-connection" type="button" role="tab" aria-controls="nav-connection" aria-selected="true">
                            Connection Settings
                        </button>
                        <?php if (!is_null($user_eship)):?>
                        <button class="nav-link" id="nav-package-tab" data-bs-toggle="tab" data-bs-target="#nav-package" type="button" role="tab" aria-controls="nav-package" aria-selected="false">
                            Shipments
                        </button>
                        <?php endif;?>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-connection" role="tabpanel" aria-labelledby="nav-connection-tab">
                        <div class="row mt-3">
                            <div class="col-12">
                                <h3 class="text-center">Connection Settings</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10 offset-sm-1">
                                <form method="post" action="" class="row" id="<?php echo $config_data['form']?>" data-user="<?php echo $user_eship[0]->id;?>">
                                    <?php if (isset($text_api_key)):?>

                                    <div class="col-12 mt-2 mb-2">
                                        <div class="alert alert-secondary" role="alert">
                                            <?php echo $text_api_key;?>
                                        </div>
                                    </div>
                                    <?php endif;?>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="token-input-eship" class="col-form-label">
                                                API Key:
                                            </label>
                                            <input type="password" class="form-control" id="token-input-eship" name="apiKeyEship" <?php echo (isset($user_eship[0]->api_key_eship))? "value='".$user_eship[0]->api_key_eship . "'": '';?>>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="phone-input-eship" class="col-form-label">
                                                Phone:
                                            </label>
                                            <input type="text" class="form-control" id="phone-input-eship" name="phoneCompanyEship" <?php echo (isset($user_eship[0]->phone))? "value='".$user_eship[0]->phone."'": '';?>>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="name-input-eship" class="col-form-label">
                                                Company Name:
                                            </label>
                                            <input type="text" class="form-control" id="name-input-eship" name="nameCompanyEship" <?php echo (isset($user_eship[0]->name))? "value='".$user_eship[0]->name."'": '';?>>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="email-input-eship" class="col-form-label">
                                                Company E-mail:
                                            </label>
                                            <input type="email" class="form-control" id="email-input-eship" name="emailCompanyEship" <?php echo (isset($user_eship[0]->email))? "value='".$user_eship[0]->email."'": '';?>>
                                        </div>
                                    </div>
                                    <div class="row g-1 mb-4">
                                        <div class="col-12 col-md-6 offset-md-6">
                                            <button type="submit" class="btn btn-primary w-100" id="<?php echo $config_data['btn'];?>">
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
                    <div class="tab-pane fade" id="nav-package" role="tabpanel" aria-labelledby="nav-package-tab" data-dimensions="<?php echo (isset($user_eship[0]->dimensions))? $user_eship[0]->dimensions : '';?>">
                        <div class="row mt-4 ms-3" >
                            <div class="col-12 col-md-6">
                                <h5 class="pt-1 pb-2">Dimensions & Weight Settings</h5>
                                <div class="mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioDimSts" id="radioDimSts2" value="default" <?php echo (isset($user_eship[0]->dimensions) && $user_eship[0]->dimensions == 1)? 'checked' : '';?>>
                                        <label class="form-check-label" for="radioDimSts2">
                                            Use items weight and dimensions for shipments
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioDimSts" id="radioDimSts1" value="template" <?php echo (isset($user_eship[0]->dimensions) && $user_eship[0]->dimensions == 0)? 'checked' : '';?>>
                                        <label class="form-check-label" for="radioDimSts1">
                                            Use a package template
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php if (!$dimensions):?>
                                <div class="col-12 col-md-6 text-end" data-show-eship-btn>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eshipDimWeModal">
                                        Create Dimensions
                                    </button>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="row mt-1" data-show-eship-div>
                            <div class="col-12 mt-2">
                                <div id="error-eship-dim-w" style="display: none;"></div>
                                <table id="eship-dim-weigth" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th colspan="5">Dimensions</th>
                                        <th colspan="4">Weight</th>
                                    </tr>
                                    <tr>
                                        <th data-field="name">Name</th>
                                        <th data-field="length_dim">Length</th>
                                        <th data-field="width_dim">Width</th>
                                        <th data-field="height_dim">Height</th>
                                        <th data-field="unit_dim">Unit</th>
                                        <th data-field="weight_w">weight</th>
                                        <th data-field="unit_w">Unit</th>
                                        <th data-field="status">Status</th>
                                        <th data-field="actions">Actions</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="eshipDimWeModal" tabindex="-1" aria-labelledby="eshipDimWeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eshipDimWeModalLabel">
                        Create Package Template
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10 offset-sm-1">
                            <form method="post" action="" class="row" id="eshipDimWeModalForm">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="length-input-eship" class="col-form-label">
                                            Alias:
                                        </label>
                                        <input type="text" class="form-control" id="alias-input-eship" name="aliasEship">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5>Dimensions</h5>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="length-input-eship" class="col-form-label">
                                            Length:
                                        </label>
                                        <input type="text" class="form-control" id="length-input-eship" name="lengthEship">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="width-input-eship" class="col-form-label">
                                            Width:
                                        </label>
                                        <input type="text" class="form-control" id="width-input-eship" name="widthEship">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="height-input-eship" class="col-form-label">
                                            Height:
                                        </label>
                                        <input type="text" class="form-control" id="height-input-eship" name="heightEship">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="unit-input-eship" class="col-form-label">
                                            Unit:
                                        </label>
                                        <select class="form-select" name="unitDimensionsEship" id="unit-input-eship">
                                            <option value="cm" selected>cm</option>
                                            <option value="in">in</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5>Weight</h5>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="weight-input-eship" class="col-form-label">
                                            Weight:
                                        </label>
                                        <input type="text" class="form-control" id="weigth-input-eship" name="weightEship">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-2">
                                        <label for="unitWeigth-input-eship" class="col-form-label">
                                            Unit:
                                        </label>
                                        <select class="form-select" name="unitWeigthEship" id="unitWeigth-input-eship">
                                            <option value="kg" selected>kg</option>
                                            <option value="lb">lb</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-1 mb-4">
                                    <div class="col-12 col-md-6">
                                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-primary w-100" id="eshipDimWeModalBtn">
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
    </div>
</div>
