<div class="container">
    <div class="mt-5 mb-5">
        <div class="row">
            <div class="col-12 col-md-6">
                <h5>Cotización.</h5>
            </div>
            <div class="col-12 col-md-6 ">
                <div class="text-end">
                    <a href="<?php echo admin_url() . $redirect_url; ?>" class="btn btn-secondary">
                        Regresar
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <section class="card show-quotes" data-select="template">
                                Template
                            </section>
                        </div>
                        <div class="col-12 col-sm-4">
                            <section class="card" data-select="custom">
                                Custom
                            </section>
                        </div>
                        <div class="col-12 col-sm-4">
                            <section class="card" data-select="multipiece">
                                Multi-piece
                            </section>
                        </div>
                    </div>
                    <div class="row mt-2" id="template">
                        <div class="col-12 col-sm-4">
                            <a href="#" class="card">
                                Letter Envelope
                            </a>
                        </div>
                        <div class="col-12 col-sm-4">
                            <!-- Button trigger modal -->
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTemplateModal">
                                Add Template
                            </a>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-sm mt-3 mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Length</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2" id="custom">
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-sm mt-3 mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Length</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-sm mt-3 mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Width</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-sm mt-3 mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Heigth</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <select class="form-select mt-3 mb-3" aria-label="Default select example">
                                <option selected>Select Units</option>
                                <option value="cm">cm</option>
                                <option value="in">in</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-sm mt-3 mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Weigth</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <select class="form-select mt-3 mb-3" aria-label="Default select example">
                                <option selected>Select Units</option>
                                <option value="kg">kg</option>
                                <option value="lb">lb</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2" id="multipiece">
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
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-sm mt-3 mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Length</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-sm mt-3 mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Width</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-sm mt-3 mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Heigth</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <select class="form-select mt-3 mb-3" aria-label="Default select example">
                                <option selected>Select Units</option>
                                <option value="cm">cm</option>
                                <option value="in">in</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-sm mt-3 mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Weigth</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <select class="form-select mt-3 mb-3" aria-label="Default select example">
                                <option selected>Select Units</option>
                                <option value="kg">kg</option>
                                <option value="lb">lb</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="row g-2">
                                <div class="col-12 col-sm-8">
                                    <h5>Order # Items</h5>
                                </div>
                                <div class="col-12 col-sm-4 text-end">
                                    <a class="btn btn-light w-100" data-bs-toggle="modal" href="#orderModalToggle" role="button">Edit</a>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="row g-2">
                                <div class="col-12 mt-1 mb-1">
                                    <h5>Addresses</h5>
                                </div>
                            </div>
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
                                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#destinationModal">
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
                                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#originModal">
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

<!-- Modal Add Template-->
<div class="modal fade" id="addTemplateModal" tabindex="-1" aria-labelledby="addTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTemplateModalLabel">
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Destination-->
<div class="modal fade" id="destinationModal" tabindex="-1" aria-labelledby="destinationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="destinationModalLabel">Destination Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Origin-->
<div class="modal fade" id="originModal" tabindex="-1" aria-labelledby="originModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="originModalLabel">Origin Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Order-->
<div class="modal fade" id="orderModalToggle" aria-hidden="true" aria-labelledby="orderModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalToggleLabel">
                    Order # Items
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6">
                        <h3>Ship Now</h3>
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="btn btn-light" data-bs-target="#orderModalToggle2" data-bs-toggle="modal">Edit</button>
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="btn btn-light" data-bs-target="#orderModalToggle3" data-bs-toggle="modal">Add</button>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-12 col-md-6">
                        <h4>In this shipment</h4>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur corporis dignissimos,
                        odit officiis porro quisquam quo tenetur ullam. Blanditiis dolor doloremque exercitationem magni,
                        nam odio omnis vel! Culpa, dolorem nemo.
                    </div>
                    <div class="col-12 col-md-6">
                        <h4>Send later</h4>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur corporis dignissimos,
                        odit officiis porro quisquam quo tenetur ullam. Blanditiis dolor doloremque exercitationem magni,
                        nam odio omnis vel! Culpa, dolorem nemo.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="orderModalToggle2" aria-hidden="true" aria-labelledby="orderModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalToggleLabel2">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Hide this modal and show the first with the button below.
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-target="#orderModalToggle" data-bs-toggle="modal">Back to first</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="orderModalToggle3" aria-hidden="true" aria-labelledby="orderModalToggleLabel3" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalToggleLabel3">Add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Hide this modal and show the first with the button below.
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-target="#orderModalToggle" data-bs-toggle="modal">Finish</button>
            </div>
        </div>
    </div>
</div>

