<div class="app-eship">
    <div class="container">
        <!-- Button trigger modal -->
        <a class="btn btn-link" data-bs-toggle="modal" href="#dashBoardEshipModalToggle" role="button">
            Ship Now <i class="fas fa-shipping-fast"></i>
        </a>
        <?php (isset($modal_custom))? require_once $modal_custom : FALSE;?>
    </div>
</div>

