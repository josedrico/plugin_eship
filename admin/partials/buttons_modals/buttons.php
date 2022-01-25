<div class="app-eship">
    <div class="container mt-3">
        <?php if(isset($error_eship)):?>
        <div class="alert alert-danger" role="alert" style="display: flex">
            <?php echo $error_eship;?>
        </div>
        <?php endif;?>
        <!-- Button trigger modal -->
        <a class="page-title-action" data-bs-toggle="modal" href="#dashBoardEshipModalToggle" role="button">
            Ship Now <i class="fas fa-shipping-fast"></i>
        </a>
        <?php (isset($modal_custom))? require_once $modal_custom : FALSE;?>
    </div>
</div>

