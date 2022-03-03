<?php if(isset($show_btn_update) && $show_btn_update):?>
        <div class="row">
            <div class="col-12">
                <button type="button" class="page-title-action mt-2 w-100" data-bs-toggle="modal" data-bs-target="#<?php echo (isset($id_api_key))? $id_api_key : 'tokenEshipModal'?>">
                    <span class="dashicons dashicons-edit"></span>
                    <?php echo (isset($btn_account_ak_modal))? $btn_account_ak_modal : '';?>
                </button>
            </div>
        </div>
<?php endif;?>


<div class="modal fade" id="<?php echo (isset($id_api_key))? $id_api_key : 'tokenEshipModal'?>" tabindex="-1" aria-labelledby="<?php echo (isset($id_api_key))? $id_api_key : 'tokenEshipModal'?>Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="<?php echo (isset($id_api_key))? $id_api_key : 'tokenEshipModal'?>Label">
                    <?php echo (isset($text_title_api_key))? $text_title_api_key : '';?>
                    <span class="dashicons dashicons-editor-help"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="modal-text fw-bolder">
                    <?php echo (isset($text_api_key))? $text_api_key : '';?>
                </p>
                <form action="">
                </form>
                <form id="<?php echo (isset($id_api_key))? $id_api_key : 'tokenEshipModal'?>Form" method="post" action="" <?php if(isset($form_data[0]->id)):?>data-user="<?php echo $form_data[0]->id;?>"<?php endif;?>>
                    <div class="mb-2">
                        <label for="token-input-eship" class="col-form-label">
                            API Key:
                        </label>
                        <input type="password" class="form-control" id="token-input-eship" data-form="eship-register" name="apiKeyEship" <?php if(isset($form_data[0]->api_key_eship)):?>value="<?php echo sanitize_text_field($form_data[0]->api_key_eship);?>"<?php endif;?>>
                    </div>
                    <div class="mb-2">
                        <label for="phone-input-eship" class="col-form-label">
                            Phone:
                        </label>
                        <input type="text" class="form-control" id="phone-input-eship" data-form="eship-register" name="phoneCompanyEship" <?php if(isset($form_data[0]->phone)):?>value="<?php echo sanitize_text_field($form_data[0]->phone);?>"<?php endif;?>>
                    </div>
                    <div class="mb-2">
                        <label for="name-input-eship" class="col-form-label">
                            Name Company:
                        </label>
                        <input type="text" class="form-control" id="name-input-eship" data-form="eship-register" name="nameCompanyEship" <?php if(isset($form_data[0]->name)):?>value="<?php echo sanitize_text_field($form_data[0]->name);?>"<?php endif;?>>
                    </div>
                    <div class="row g-1 mb-4">
                        <div class="col-12 col-md-6">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                <span class="dashicons dashicons-no-alt"></span>
                            </button>
                        </div>
                        <div class="col-12 col-md-6">
                            <button id="<?php echo (isset($id_api_key))? $id_api_key : 'tokenEshipModal'?>Btn" type="submit" class="btn btn-primary w-100">
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
