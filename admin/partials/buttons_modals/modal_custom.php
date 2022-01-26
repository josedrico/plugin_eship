<!-- Modal Custom -->
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
                    <div id="spinner-load-data-q" class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="message-api"></div>
                            <table id="custom-eship-rates" class="table">
                                <thead>
                                <tr>
                                    <th data-field="carrier">Carrier</th>
                                    <th data-field="service">Service</th>
                                    <th data-field="estimatedDelivery">Transit Days</th>
                                    <th data-field="amount">Estimated Rate</th>
                                    <th data-field="action"></th>
                                </tr>
                                </thead>
                            </table>
                            <!--
                            <table id="custom-eship-messages" class="table mt-5 text-danger">
                                <thead>
                                <tr>
                                    <th data-field="source">Source</th>
                                    <th data-field="text">Text</th>
                                </tr>
                                </thead>
                            </table>
                            -->
                            <div id="custom-eship-messages"></div>
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

<div class="modal fade" id="shipmentModalToggle2" aria-hidden="true" aria-labelledby="shipmentModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shipmentModalToggleLabel2">Tracking Number: <span id="tracking-number"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="spinner-load-data" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="create-shipment">

                </div>
                <table id="pack-eship-messages" class="table">
                    <thead>
                    <tr>
                        <th data-field="source">Source</th>
                        <th data-field="text">Text</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!--
                <button class="btn btn-secondary" data-bs-target="#dashBoardEshipModalToggle" data-bs-toggle="modal">Back</button>
                -->
            </div>
        </div>
    </div>
</div>
