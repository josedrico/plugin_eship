<div class="modal fade" id="ordersQuotationsEshipModalToggle" aria-hidden="true" aria-labelledby="ordersQuotationsEshipModalToggleLabel" tabindex="-1" data-orders-eship="<?php echo (isset($orders_eship))? $orders_eship : '';?>">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ordersQuotationsEshipModalToggleLabel">Select to Services</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="ordersModalForms">
                <div id="spinner-eship-orders" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <table id="orders-multiple-eship" class="table" style="display: none;">
                    <thead>
                    <tr>
                        <th data-field="order">Order (Date)</th>
                        <th data-field="ship">Shipping Method</th>
                        <th data-field="services">Services</th>
                    </tr>
                    </thead>
                </table>
                </form>
            </div>
            <div class="modal-footer">
                <button id="ordersQuotationsEshipModalToggleBtn" class="btn btn-primary" data-bs-target="#ordersQuotationsEshipModalToggle2" data-bs-toggle="modal">
                    Create Shipments
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ordersQuotationsEshipModalToggle2" aria-hidden="true" aria-labelledby="ordersQuotationsEshipModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ordersQuotationsEshipModalToggleLabel2">Your Labels</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="spinner-eship-orders-pdf" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="orders-multiple-eship-div" style="display: none;"></div>
                <table id="orders-multiple-eship-pdf" class="table" style="display: none;">
                    <thead>
                    <tr>
                        <th data-field="order">Order</th>
                        <th data-field="client">Client</th>
                        <th data-field="services">Services</th>
                        <th data-field="trackingNumber"># Tracking</th>
                        <th data-field="tracking">Tracking Guide</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <span id="ordersMultipleLabels"></span>
            </div>
        </div>
    </div>
</div>
