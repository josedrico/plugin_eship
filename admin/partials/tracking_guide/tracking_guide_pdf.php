<div class="app-eship">
    <div class="container">
        <!-- Button trigger modal -->
        <a class="btn btn-link" data-bs-toggle="modal" href="#trackingPdfEshipModalToggle" role="button">
            Tracking PDF
        </a>

        <div class="modal fade" id="trackingPdfEshipModalToggle" aria-hidden="true" aria-labelledby="trackingPdfEshipModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="trackingPdfEshipModalToggleLabel">
                            Tracking number:
                            <a class="btn btn-light" data-bs-target="#trackingPdfEshipModalToggle2" data-bs-toggle="modal">288466951655</a>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="ratio ratio-16x9">
                            <iframe id="inlineFrameExample"
                                    title="Inline Frame Example"
                                    src="https://s3.us-east-2.amazonaws.com/eship-prod/label/61d77b30b9f45.pdf">
                            </iframe>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal 2-->
    <div class="modal fade" id="trackingPdfEshipModalToggle2" aria-hidden="true" aria-labelledby="trackingPdfEshipModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trackingPdfEshipModalToggleLabel2">
                        Add Template
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h1>Fedex</h1>
                            <a href="https://www.fedex.com/fedextrack/?trknbr=288466951655&trkqual=2459586000~288466951655~FX" target="_blank">
                                288466951655
                            </a>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    Jan 6
                                    06:28 pm
                                </div>
                                <div class="col-12 col-md-4">
                                    PDF ICON
                                </div>
                                <div class="col-12 col-md-4">
                                    LABEL CREATED
                                    The shipment status would be updated soon.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-bs-target="#trackingPdfEshipModalToggle" data-bs-toggle="modal">Back</button>
                </div>
            </div>
        </div>
    </div>
</div>
