<div class="modal fade" id="dashBoardEshipModalToggle" aria-hidden="true" aria-labelledby="dashBoardEshipModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dashBoardEshipModalToggleLabel">
                    <i class="fas fa-shipping-fast"></i> Select to service
                    <?php if(!empty($post)): ?>
                        <span class="badge bg-secondary">
                            Order: <?php echo $post;?>
                        </span>
                    <?php endif;?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container" id="orders-list">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            echo "<pre>";
                            //var_dump($res);
                            //var_dump($shipping);
                            //var_dump($shipping_lines);
                            //var_dump($lines_items);
                            var_dump($arr_product_line);
                            //var_dump($res_wc_settings);
                            echo "</pre>";
                            ?>
                            <table id="custom-eship" class="table">
                                <thead>
                                <tr>
                                    <th data-field="carrier">Carrier</th>
                                    <th data-field="services">Services</th>
                                    <th data-field="shipDate">Ship date</th>
                                    <th data-field="actions"></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>