<div class="app-eship">
    <div class="container">
        <!-- Button trigger modal -->
        <a class="btn btn-link" data-bs-toggle="modal" href="#dashBoardEshipModalToggle" role="button">
            Ship Now
        </a>

        <div class="modal fade" id="dashBoardEshipModalToggle" aria-hidden="true" aria-labelledby="dashBoardEshipModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dashBoardEshipModalToggleLabel">
                            Ship Nowx
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container" id="orders-list">
                            <div class="row">
                                <div class="col-12 col-md-8">
                                    <div class="card">
                                        <ul class="nav nav-tabs" id="myEshipOrderTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="template-eship-tab" data-bs-toggle="tab" data-bs-target="#template-eship" type="button" role="tab" aria-controls="template-eship" aria-selected="true">
                                                    Template
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="custom-eship-tab" data-bs-toggle="tab" data-bs-target="#custom-eship" type="button" role="tab" aria-controls="custom-eship" aria-selected="false">
                                                    Custom
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="multipiece-eship-tab" data-bs-toggle="tab" data-bs-target="#multipiece-eship" type="button" role="tab" aria-controls="multipiece-eship" aria-selected="false">
                                                    Multipiece
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myEshipOrderTabContent">
                                            <div class="tab-pane fade show active" id="template-eship" role="tabpanel" aria-labelledby="template-eship-tab">
                                                <div class="col-12 col-sm-6">
                                                    <a href="#" class="card">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <span class="dashicons dashicons-email"></span>
                                                            </div>
                                                            <div class="col-12 text-center">
                                                                Example Letter Envelope
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-12 col-sm-6 pt-5">
                                                    <!-- Button trigger modal -->
                                                    <a class="btn btn-light" data-bs-target="#dashBoardEshipModalToggle2" data-bs-toggle="modal">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <span class="dashicons dashicons-welcome-add-page"></span>
                                                            </div>
                                                            <div class="col-12 text-center">
                                                                Add Template
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-eship" role="tabpanel" aria-labelledby="custom-eship-tab">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="input-group input-group-sm mt-3 mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-sm">Length</span>
                                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="input-group input-group-sm mt-3 mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-sm">Width</span>
                                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="input-group input-group-sm mt-3 mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-sm">Heigth</span>
                                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <select class="form-select mt-3 mb-3" aria-label="Default select example">
                                                            <option selected>Select Units</option>
                                                            <option value="cm">cm</option>
                                                            <option value="in">in</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="input-group input-group-sm mt-3 mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-sm">Weigth</span>
                                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <select class="form-select mt-3 mb-3" aria-label="Default select example">
                                                            <option selected>Select Units</option>
                                                            <option value="kg">kg</option>
                                                            <option value="lb">lb</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <h3 id="icon-add-options">
                                                            <span class="dashicons dashicons-insert"></span> Additional options
                                                        </h3>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-text">
                                                                    <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input"> Shipping date
                                                                </div>
                                                                <input type="text" class="form-control" aria-label="Text input with checkbox" id="datepicker">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-md-8">
                                                                <div class="form-check">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-text">
                                                                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input"> Additional insurance
                                                                        </div>
                                                                        <input type="text" class="form-control" aria-label="Text input with checkbox" id="datepicker">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-4">
                                                                <select class="form-select" aria-label="Default select example">
                                                                    <option selected>Select Money Format</option>
                                                                    <option value="1">MXN</option>
                                                                    <option value="2">US</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="multipiece-eship" role="tabpanel" aria-labelledby="multipiece-eship-tab">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4> Parcels in this shipment</h4>
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Quantity</th>
                                                                <th>Dimensions</th>
                                                                <th>Weight</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td>1</td>
                                                                <td>121x12x121 cm</td>
                                                                <td>12 kg</td>
                                                                <td>
                                                                    -
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>1</td>
                                                                <td>121x12x121 cm</td>
                                                                <td>12 kg</td>
                                                                <td>
                                                                    -
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="input-group input-group-sm mt-3 mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-sm">Length</span>
                                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="input-group input-group-sm mt-3 mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-sm">Width</span>
                                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="input-group input-group-sm mt-3 mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-sm">Heigth</span>
                                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <select class="form-select mt-3 mb-3" aria-label="Default select example">
                                                            <option selected>Select Units</option>
                                                            <option value="cm">cm</option>
                                                            <option value="in">in</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="input-group input-group-sm mt-3 mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-sm">Weigth</span>
                                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <select class="form-select mt-3 mb-3" aria-label="Default select example">
                                                            <option selected>Select Units</option>
                                                            <option value="kg">kg</option>
                                                            <option value="lb">lb</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <h3 id="icon-add-options">
                                                            <span class="dashicons dashicons-insert"></span> Additional options
                                                        </h3>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-text">
                                                                    <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input"> Shipping date
                                                                </div>
                                                                <input type="text" class="form-control" aria-label="Text input with checkbox" id="datepicker">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-md-8">
                                                                <div class="form-check">
                                                                    <div class="input-group mb-3">
                                                                        <div class="input-group-text">
                                                                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input"> Additional insurance
                                                                        </div>
                                                                        <input type="text" class="form-control" aria-label="Text input with checkbox" id="datepicker">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-4">
                                                                <select class="form-select" aria-label="Default select example">
                                                                    <option selected>Select Money Format</option>
                                                                    <option value="1">MXN</option>
                                                                    <option value="2">US</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="accordion accordion-flush" id="accordionFlushEshipOrders">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOrdersItems" aria-expanded="true" aria-controls="flush-collapseOrdersItems">
                                                    Orders # Items
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOrdersItems" class="accordion-collapse collapse show" aria-labelledby="flush-headingOrdersItems" data-bs-parent="#accordionFlushEshipOrders">
                                                <div class="accordion-body">
                                                    <div class="row g-2">
                                                        <div class="col-12 offset-sm-6 col-sm-6 text-end">
                                                            <a class="btn btn-light w-100" data-bs-target="#dashBoardEshipModalToggle3" data-bs-toggle="modal" href="#orderModalToggle" role="button">Edit</a>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <td>In this parcel</td>
                                                                    <td></td>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>1 x Order items 1 (1000 g)</td>
                                                                    <td>$0.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>1 x Order items 1 (1000 g)</td>
                                                                    <td>$0.00</td>
                                                                </tr>
                                                                </tbody>
                                                                <tfooter>
                                                                    <tr>
                                                                        <th class="text-end">
                                                                            Subtotal:
                                                                        </th>
                                                                        <th>
                                                                            $0.00
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">
                                                                            Shipment:
                                                                        </th>
                                                                        <th>
                                                                            $0.00
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-end">
                                                                            Total:
                                                                        </th>
                                                                        <th>
                                                                            $0.00
                                                                        </th>
                                                                    </tr>
                                                                </tfooter>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingEshipAddresses">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEshipAddresses" aria-expanded="false" aria-controls="flush-collapseEshipAddresses">
                                                    Addresses
                                                </button>
                                            </h2>
                                            <div id="flush-collapseEshipAddresses" class="accordion-collapse collapse" aria-labelledby="flush-headingEshipAddresses" data-bs-parent="#accordionFlushEshipOrders">
                                                <div class="accordion-body">
                                                    <nav>
                                                        <div class="nav nav-tabs" id="nav-tabAddr" role="tablist">
                                                            <button class="nav-link active" id="nav-address-tab" data-bs-toggle="tab" data-bs-target="#nav-address" type="button" role="tab" aria-controls="nav-address" aria-selected="true">
                                                                Address
                                                            </button>
                                                            <button class="nav-link" id="nav-destination-tab" data-bs-toggle="tab" data-bs-target="#nav-destination" type="button" role="tab" aria-controls="nav-destination" aria-selected="false">
                                                                Destination
                                                            </button>
                                                            <button class="nav-link" id="nav-origin-tab" data-bs-toggle="tab" data-bs-target="#nav-origin" type="button" role="tab" aria-controls="nav-origin" aria-selected="false">
                                                                Origin
                                                            </button>
                                                        </div>
                                                    </nav>
                                                    <div class="tab-content" id="nav-tabAddrContent">
                                                        <div class="tab-pane fade show active" id="nav-address" role="tabpanel" aria-labelledby="nav-address-tab">
                                                            <div id="destination" class="col-12 pt-2">
                                                                <h5>
                                                                    Destination Address
                                                                </h5>
                                                                <p class="card-text">
                                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus architecto assumenda
                                                                    at aut beatae culpa cupiditate eos error eveniet, exercitationem iure numquam officia
                                                                    provident quis, quisquam tempore temporibus unde voluptate.
                                                                </p>
                                                            </div>
                                                            <div id="origin" class="pt-2 pb-2">
                                                                <h5>
                                                                    Origin Address
                                                                </h5>
                                                                <p class="card-text">
                                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus architecto assumenda
                                                                    at aut beatae culpa cupiditate eos error eveniet, exercitationem iure numquam officia
                                                                    provident quis, quisquam tempore temporibus unde voluptate.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-destination" role="tabpanel" aria-labelledby="nav-destination-tab">
                                                            <div class="col-12 mt-1 mb-1">
                                                                <div class="text-end">
                                                                    <button type="button" class="btn btn-light" data-bs-target="#dashBoardEshipModalToggle4" data-bs-toggle="modal">
                                                                        Edit
                                                                    </button>

                                                                </div>
                                                            </div>
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus architecto assumenda
                                                            at aut beatae culpa cupiditate eos error eveniet, exercitationem iure numquam officia
                                                            provident quis, quisquam tempore temporibus unde voluptate.
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-origin" role="tabpanel" aria-labelledby="nav-origin-tab">
                                                            <div class="col-12 mt-1 mb-1">
                                                                <div class="text-end">
                                                                    <button type="button" class="btn btn-light" data-bs-target="#dashBoardEshipModalToggle5" data-bs-toggle="modal">
                                                                        Edit
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus architecto assumenda
                                                            at aut beatae culpa cupiditate eos error eveniet, exercitationem iure numquam officia
                                                            provident quis, quisquam tempore temporibus unde voluptate.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        <!-- Modal 2-->
        <div class="modal fade" id="dashBoardEshipModalToggle2" aria-hidden="true" aria-labelledby="dashBoardEshipModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dashBoardEshipModalToggleLabel2">
                            Add Template
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="mt-3 mb-3">
                                    <label for="exampleDataList" class="form-label">The name of your template</label>
                                    <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                                    <datalist id="datalistOptions">
                                        <option value="Big Box">
                                        <option value="Documents">
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group input-group-sm mt-3 mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Length</span>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group input-group-sm mt-3 mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Width</span>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group input-group-sm mt-3 mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Heigth</span>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <select class="form-select mt-3 mb-3" aria-label="Default select example">
                                    <option selected>Select Units</option>
                                    <option value="cm">cm</option>
                                    <option value="in">in</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group input-group-sm mt-3 mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Weigth</span>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <select class="form-select mt-3 mb-3" aria-label="Default select example">
                                    <option selected>Select Units</option>
                                    <option value="kg">kg</option>
                                    <option value="lb">lb</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <h3 id="icon-add-options">
                                    <span class="dashicons dashicons-insert"></span> Additional options
                                </h3>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input"> Shipping date
                                        </div>
                                        <input type="text" class="form-control" aria-label="Text input with checkbox" id="datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-8">
                                        <div class="form-check">
                                            <div class="input-group mb-3">
                                                <div class="input-group-text">
                                                    <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input"> Additional insurance
                                                </div>
                                                <input type="text" class="form-control" aria-label="Text input with checkbox" id="datepicker">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4">
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected>Select Money Format</option>
                                            <option value="1">MXN</option>
                                            <option value="2">US</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  data-bs-target="#dashBoardEshipModalToggle" data-bs-toggle="modal">Back</button>
                        <button type="button" class="btn btn-primary" data-bs-target="#dashBoardEshipModalToggle" data-bs-toggle="modal">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal 3-->
        <div class="modal fade" id="dashBoardEshipModalToggle3" aria-hidden="true" aria-labelledby="dashBoardEshipModalToggleLabel3" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dashBoardEshipModalToggleLabel3">Modal 3</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Hide this modal and show the first with the button below.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  data-bs-target="#dashBoardEshipModalToggle" data-bs-toggle="modal">Back</button>
                        <button type="button" class="btn btn-primary" data-bs-target="#dashBoardEshipModalToggle" data-bs-toggle="modal">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal 4-->
        <div class="modal fade" id="dashBoardEshipModalToggle4" aria-hidden="true" aria-labelledby="dashBoardEshipModalToggleLabel4" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dashBoardEshipModalToggleLabel4">Modal 4</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Hide this modal and show the first with the button below.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  data-bs-target="#dashBoardEshipModalToggle" data-bs-toggle="modal">Back</button>
                        <button type="button" class="btn btn-primary" data-bs-target="#dashBoardEshipModalToggle" data-bs-toggle="modal">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal 5-->
        <div class="modal fade" id="dashBoardEshipModalToggle5" aria-hidden="true" aria-labelledby="dashBoardEshipModalToggleLabel5" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dashBoardEshipModalToggleLabel5">Modal 5</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Hide this modal and show the first with the button below.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  data-bs-target="#dashBoardEshipModalToggle" data-bs-toggle="modal">Back</button>
                        <button type="button" class="btn btn-primary" data-bs-target="#dashBoardEshipModalToggle" data-bs-toggle="modal">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
