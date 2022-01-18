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
                        <div id="result-custom" class="col-12" data-result="<?php echo (isset($result))? $result : FALSE;?>">
                            <div class="message-api"></div>
                            <table id="custom-eship-rates" class="table">
                                <thead>
                                <tr>
                                    <th data-field="carrier">Carrier</th>
                                    <th data-field="service">Service</th>
                                    <th data-field="estimatedDelivery">Estimated Delivery	</th>
                                    <th data-field="amount">currency</th>
                                    <th data-field="action">days</th>
                                </tr>
                                </thead>
                            </table>
                            <table id="custom-eship-messages" class="table">
                                <thead>
                                <tr>
                                    <th data-field="source">Source</th>
                                    <th data-field="text">Text</th>
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