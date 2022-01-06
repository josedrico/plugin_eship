<div class="container">
    <div class="mt-5 mb-5">
        <h2 class="text-center mb-5">Conexión con ESHIP</h2>
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <span class="dashicons dashicons-rest-api"></span>
                            Cuento con el token de ESHIP
                        </h5>
                        <p class="card-text fw-bolder">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam id ipsa nulla magni aspernatur a illo officia illum recusandae beatae necessitatibus rem impedit numquam omnis enim, animi exercitationem maxime officiis.
                        </p>
                        <div class="row g-1">
                            <div class="col-12 col-md-6 offset-md-6">
                                <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#tokenEshipModal">
                                    <span class="dashicons dashicons-edit"></span> Registrar Token
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <span class="dashicons dashicons-admin-site-alt2"></span>
                            No tengo cuenta de ESHIP
                        </h5>
                        <p class="card-text fw-bolder">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam id ipsa nulla magni aspernatur a illo officia illum recusandae beatae necessitatibus rem impedit numquam omnis enim, animi exercitationem maxime officiis.
                        </p>
                        <div class="row g-1">
                            <div class="col-12 col-md-6 offset-md-6 align-text-center">
                                <a href="https://app.myeship.co/en/login" class="btn btn-secondary w-100" target="_blank">
                                    <span class="dashicons dashicons-admin-site-alt3"></span> Registrarme
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tokenEshipModal" tabindex="-1" aria-labelledby="tokenEshipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Registrar Token
                    <span class="dashicons dashicons-editor-help"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="modal-text fw-bolder">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab ad asperiores assumenda autem commodi
                    culpa facilis impedit incidunt maiores molestias, natus perferendis, quam quos repellendus sint sunt
                    veniam voluptate voluptatem!
                </p>
                <form id="tokenEshipModalForm">
                    <div class="mb-2">
                        <label for="token-input-eship" class="col-form-label">
                            Token:
                        </label>
                        <input type="text" class="form-control" id="token-input-eship">
                    </div>
                    <div class="row g-1 mb-4">
                        <div class="col-12 col-md-6">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                <span class="dashicons dashicons-no-alt"></span>
                            </button>
                        </div>
                        <div class="col-12 col-md-6">
                            <button id="tokenEshipModalBtn" type="button" class="btn btn-primary w-100">
                                <span class="dashicons dashicons-saved"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>