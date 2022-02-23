<!-- Modal -->
<div class="modal fade" id="shipmentPdfModal" tabindex="-1" aria-labelledby="shipmentPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shipmentModalToggleLabel2">
                        Tracking number: <a href="https://app.myeship.co/en/track/track?no=<?php echo (isset($pdf_arr['tracking_number']))? $pdf_arr['tracking_number'] : '';?>" target="_blank"><?php echo (isset($pdf_arr['tracking_number']))? $pdf_arr['tracking_number'] : '';?></a>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="ratio ratio-16x9">
                        <iframe src="<?php echo $pdf_arr['tracking_link'];?>" title="<?php echo $pdf_arr['provider'];?>" allowfullscreen></iframe>
                    </div>
                </div>
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
