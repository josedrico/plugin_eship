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
                        <?php echo (isset($text_modal_ak))? esc_html($text_modal_ak) : '';?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <span class="dashicons dashicons-rest-api"></span>
                                <?php echo (isset($btn_account_ak))? esc_html($btn_account_ak) : '';?>
                            </h5>
                            <?php if (isset($btn_account_ak_text)):?>
                            <p class="card-text fw-bolder">
                                <?php echo esc_html($btn_account_ak_text);?>
                            </p>
                            <?php endif;?>
                            <div class="row g-1">
                                <div class="col-12 col-md-6 offset-md-6">
                                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#<?php echo (isset($id_api_key))? esc_attr($id_api_key) : 'tokenEshipModal'?>">
                                        <span class="dashicons dashicons-edit"></span>
                                        <?php echo (isset($btn_account_ak_modal))? esc_html($btn_account_ak_modal) : '';?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <span class="dashicons dashicons-admin-site-alt2"></span>
                                <?php echo (isset($title_eship_account))? esc_html($title_eship_account) : '';?>
                            </h5>
                            <?php if (isset($text_eship_account) && !empty($text_eship_account)):?>
                            <p class="card-text fw-bolder">
                                <?php echo esc_html($text_eship_account);?>
                            </p>
                            <?php endif;?>
                            <div class="row g-1">
                                <div class="col-12 col-md-6 offset-md-6 align-text-center">
                                    <a href="<?php echo (isset($btn_account_link))? esc_url($btn_account_link) : '';?>" class="btn btn-secondary w-100" target="_blank">
                                        <span class="dashicons dashicons-admin-site-alt3"></span>
                                        <?php echo (isset($btn_account))? esc_html($btn_account) :  ''?>
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
    <?php if (isset($modal_token)):?>
    <?php require_once $modal_token;?>
    <?php endif;?>
</div>


