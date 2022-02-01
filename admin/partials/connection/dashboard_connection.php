<div id="app-eship-url" class="container app-eship-config" data-url="<?php echo  ESHIP_PLUGIN_DIR_URL;?>">
    <div class="mt-3">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-6 offset-md-6">
                <div id="eship-card" class="card mb-3">
                    <div class="row g-0">
                        <?php if(isset($img_title)):?>
                            <div class="col-md-4">
                                <img src="<?php echo $img_title;?>" class="img-fluid rounded-start" alt="...">
                            </div>
                        <?php endif;?>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h2 class="card-title">Configs ESHIP</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row me-5 ms-5">
            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-connection-tab" data-bs-toggle="tab" data-bs-target="#nav-connection" type="button" role="tab" aria-controls="nav-connection" aria-selected="true">
                            Connection
                        </button>
                        <button class="nav-link" id="nav-package-tab" data-bs-toggle="tab" data-bs-target="#nav-package" type="button" role="tab" aria-controls="nav-package" aria-selected="false">
                            Package
                        </button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-connection" role="tabpanel" aria-labelledby="nav-connection-tab">
                        <div class="row mt-3">
                            <div class="col-12">
                                <h3 class="text-center">Connection Configs</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10 offset-sm-1">
                                <form method="post" action="" class="row" id="<?php echo $config_data['form']?>" data-user="<?php echo $user_eship[0]->id;?>">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="token-input-eship" class="col-form-label">
                                                API Key:
                                            </label>
                                            <input type="password" class="form-control" id="token-input-eship" name="apiKeyEship" <?php echo (isset($user_eship[0]->token_eship))? "value='".$user_eship[0]->token_eship."'": '';?>>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="cs-input-eship" class="col-form-label">
                                                Consumer Secret:
                                            </label>
                                            <input type="password" class="form-control" id="cs-input-eship" name="customerSecretEship" <?php echo (isset($user_eship[0]->consumer_key))? "value='".$user_eship[0]->consumer_key."'": '';?>>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="ck-input-eship" class="col-form-label">
                                                Consumer Key:
                                            </label>
                                            <input type="password" class="form-control" id="ck-input-eship" name="customerKeyEship" <?php echo (isset($user_eship[0]->consumer_secret))? "value='".$user_eship[0]->consumer_secret."'": '';?>>
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
                                                Name Company:
                                            </label>
                                            <input type="text" class="form-control" id="name-input-eship" name="nameCompanyEship" <?php echo (isset($user_eship[0]->name))? "value='".$user_eship[0]->name."'": '';?>>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-2">
                                            <label for="email-input-eship" class="col-form-label">
                                                E-mail Company:
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
                    <div class="tab-pane fade" id="nav-package" role="tabpanel" aria-labelledby="nav-package-tab">
                        <div class="row mt-3">
                            <div class="col-12">
                                <h3 class="text-center">
                                    Package Information
                                </h3>
                            </div>
                            <div class="row">
                                <div class="col-12 border border-dark border-start-0 border-end-0 ">
                                    <h4 class="ps-5 mb-1 mt-1">Custom</h4>
                                </div>
                                <div class="col-sm-10 offset-sm-1">
                                    <form method="post" action="" class="row">
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
                                                <input type="text" class="form-control" id="cs-input-eship" name="widthEship">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-2">
                                                <label for="height-input-eship" class="col-form-label">
                                                    Height:
                                                </label>
                                                <input type="password" class="form-control" id="height-input-eship" name="heightEship">
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
                                            <div class="col-12 col-md-6 offset-md-6">
                                                <button type="submit" class="btn btn-primary w-100">
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
    </div>
</div>