<div id="app-eship-url" class="app-eship" data-url="<?php echo  ESHIP_PLUGIN_DIR_URL;?>">
    <div class="container mt-3">
        <?php if(isset($error_eship)):?>
        <div class="alert alert-danger" role="alert" style="display: flex">
            <?php echo $error_eship;?>
        </div>
        <?php endif;?>
        <!-- Button trigger modal -->
        <div class="row">
            <div class="col-12">
                <button type="button" class="page-title-action w-100 mt-1" data-bs-toggle="modal" href="#dashBoardEshipModalToggle" role="button" data-order="<?php echo (isset($order))? $order : FALSE;?>">
                    Ship Now <i class="fas fa-shipping-fast"></i>
                </button>
            </div>
        </div>
        <?php (isset($modal_custom))? require_once $modal_custom : FALSE;?>

        <?php (isset($modal_token))? require_once $modal_token : FALSE;?>
        <?php if(isset($modal_shipment_pdf_show)):?>
            <!-- Button trigger modal -->
            <div class="row">
                <div class="col-12">
                    <button id="shipmentPdfModalBtn" type="button"class="page-title-action w-100 mt-1" data-bs-toggle="modal" data-bs-target="#shipmentPdfModal">
                        Shipment PDF <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>

            <?php (isset($modal_shipment_pdf))? require_once $modal_shipment_pdf : FALSE;?>
        <?php endif;?>

    </div>
</div>

