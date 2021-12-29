<div class="container">
    <div class="mt-5 mb-5">
        <h5>Connections with e-commerce platform.</h5>
        <div class="row">
            <div class="col-12 col-sm-6 offset-sm-3">
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($wc_img)) { ?>
                        <img src="<?php echo (isset($wc_img))? $wc_img : FALSE;?>" class="card-img-top" alt="...">
                        <?php } else { ?>
                            <h5 class="card-title">Woocommerce</h5>
                        <?php } ?>
                        <p class="card-text">Connect Woocommerce with E-ship</p>
                        <a href="#" class="btn btn-primary">Connect</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>