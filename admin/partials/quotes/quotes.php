<div class="container">
    <div class="mt-5 mb-5">
        <h5>Connections with e-commerce platform.</h5>
        <div class="row">
            <?php
            //echo "<pre>";
            //var_dump(gettype($res_quotation));
                //var_dump($res_quotation['body']);
            //var_dump(gettype($list_orders));
            //var_dump($list_orders);
            //echo "</pre>";
            ?>
            <div class="col-12">
                <div class="col-12">
                    <table id="quotes" class="table" data-url="<?php echo $json;?>">
                        <thead>
                        <tr>
                            <th data-field="id">ID</th>
                            <th data-field="status">status</th>
                            <th data-field="currency">currency</th>
                            <th data-field="date_created">date_created</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>