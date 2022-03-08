<div id="app-eship-url" class="app-eship" data-url="<?php echo  esc_url(ESHIP_PLUGIN_DIR_URL);?>">
    <div class="container mt-3">
        <!-- Button trigger modal -->
        <div class="row">
            <div class="col-12">
                <button type="button" class="page-title-action w-100 mt-1" data-bs-toggle="modal" href="#dashBoardEshipModalToggle" role="button" data-order="<?php echo (isset($order))? esc_attr($order) : FALSE;?>">
                    <?php echo (isset($button_quotation_eship))? esc_html($button_quotation_eship) : '';?>
                    <i class="fas fa-shipping-fast"></i>
                </button>
            </div>
        </div>
        <?php (isset($modal_custom))? require_once $modal_custom : FALSE;?>

        <?php (isset($modal_token))? require_once $modal_token : FALSE;?>
        <?php if(isset($modal_shipment_pdf_show)):?>
            <!-- Button trigger modal -->
            <?php if (isset($pdf_arr['tracking_url']) && !empty($pdf_arr['tracking_url'])):?>
            <div class="row">
                <div class="col-12">
                    <a href="<?php echo esc_url($pdf_arr['tracking_url']);?>" target="_blank">
                    <button type="button" class="page-title-action w-100 mt-1">
                        Track Shipment <i class="fas fa-file-pdf"></i>
                    </button>
                    </a>
                </div>
            </div>
            <?php endif;?>
            <div class="row">
                <div class="col-12">
                    <button id="shipmentPdfModalBtn" type="button" class="page-title-action w-100 mt-1" data-bs-toggle="modal" data-bs-target="#shipmentPdfModal">
                        View Shipping Label <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>

            <?php (isset($modal_shipment_pdf))? require_once $modal_shipment_pdf : FALSE;?>
        <?php endif;?>

    </div>
</div>

