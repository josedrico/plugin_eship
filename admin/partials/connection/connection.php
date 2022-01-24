<div class="app-eship" class="container">
    <!-- Button trigger modal -->
    <button type="button" class="page-title-action" data-bs-toggle="modal" data-bs-target="#registerEshipModal">
        Activate ESHIP
    </button>

    <!-- Modal -->
    <div class="modal fade" id="registerEshipModal" tabindex="-1" aria-labelledby="registerEshipModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="registerEshipModalLabel">
                        <?php echo (isset($text_modal_ak))? $text_modal_ak : '';?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <span class="dashicons dashicons-rest-api"></span>
                                <?php echo (isset($btn_account_ak))? $btn_account_ak : '';?>
                            </h5>
                            <?php if (isset($btn_account_ak_text)):?>
                            <p class="card-text fw-bolder">
                                <?php echo $btn_account_ak_text;?>
                            </p>
                            <?php endif;?>
                            <div class="row g-1">
                                <div class="col-12 col-md-6 offset-md-6">
                                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#tokenEshipModal">
                                        <span class="dashicons dashicons-edit"></span>
                                        <?php echo (isset($btn_account_ak_modal))? $btn_account_ak_modal : '';?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <span class="dashicons dashicons-admin-site-alt2"></span>
                                <?php echo (isset($title_eship_account))? $title_eship_account : '';?>
                            </h5>
                            <?php if (isset($text_eship_account) && !empty($text_eship_account)):?>
                            <p class="card-text fw-bolder">
                                <?php echo $text_eship_account;?>
                            </p>
                            <?php endif;?>
                            <div class="row g-1">
                                <div class="col-12 col-md-6 offset-md-6 align-text-center">
                                    <a href="<?php echo (isset($btn_account_link))? $btn_account_link : '';?>" class="btn btn-secondary w-100" target="_blank">
                                        <span class="dashicons dashicons-admin-site-alt3"></span>
                                        <?php echo (isset($btn_account))? $btn_account :  ''?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-12 offset-md-3 col-md-6">
                            <div class="text-center">
                                <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tokenEshipModal" tabindex="-1" aria-labelledby="tokenEshipModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <?php echo (isset($text_title_api_key))? $text_title_api_key : '';?>
                        <span class="dashicons dashicons-editor-help"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="modal-text fw-bolder">
                        <?php echo (isset($text_api_key))? $text_api_key : '';?>
                    </p>
                    <form action=""></form>
                    <form id="tokenEshipModalForm" method="post" action="">
                        <div class="mb-2">
                            <label for="token-input-eship" class="col-form-label">
                                API Key:
                            </label>
                            <input type="text" class="form-control" id="token-input-eship" data-form="eship-register" name="apiKey">
                        </div>
                        <div class="mb-2">
                            <label for="cs-input-eship" class="col-form-label">
                                Consumer Secret:
                            </label>
                            <input type="text" class="form-control" id="cs-input-eship" data-form="eship-register" name="customerSecret">
                        </div>
                        <div class="mb-2">
                            <label for="ck-input-eship" class="col-form-label">
                                Consumer Key:
                            </label>
                            <input type="text" class="form-control" id="ck-input-eship" data-form="eship-register" name="customerKey">
                        </div>
                        <div class="mb-2">
                            <label for="phone-input-eship" class="col-form-label">
                                Phone:
                            </label>
                            <input type="text" class="form-control" id="phone-input-eship" data-form="eship-register" name="phoneCompany">
                        </div>
                        <div class="mb-2">
                            <label for="name-input-eship" class="col-form-label">
                                Name Company:
                            </label>
                            <input type="text" class="form-control" id="name-input-eship" data-form="eship-register" name="nameCompany">
                        </div>
                        <div class="row g-1 mb-4">
                            <div class="col-12 col-md-6">
                                <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                    <span class="dashicons dashicons-no-alt"></span>
                                </button>
                            </div>
                            <div class="col-12 col-md-6">
                                <button id="tokenEshipModalBtn" type="submit" class="btn btn-primary w-100">
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


