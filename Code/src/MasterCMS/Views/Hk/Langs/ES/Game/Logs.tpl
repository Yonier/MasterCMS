<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-6 col-lg-6"><button class="btn btn-primary btn-block" type="submit" id="update"><i class="fa fa-repeat"></i> Actualizar</button></div>
        <div class="col-md-6 col-lg-6"><button class="btn btn-primary btn-block" type="submit" id="deleteAll"><i class="fa fa-times"></i> Eliminar todo</button></div>
        <div class="col-md-12 col-lg-12"><div id="forerror"></div></div>
        <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header" data-background-color="purple">
                                <h4 class="title">Lista de movimientos</h4>
                                <p class="category">A continuaci&oacute;n podra ver la lista de todos los movimientos de staffs en cms de {@name}:</p>
                            </div>
                            <div class="card-content table-responsive">
                                <div style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-hover">
                                        <thead class="text-primary">
                                            <th>ID</th>
                                            <th>Staff</th>
                                            <th>Accion</th>
                                            <th>Tiempo</th>
                                        </thead>
                                        <tbody id="logsContainer">
                                            
                                        </tbody>
                                    </table>
                                    <div id="loader_live1" style="margin-top: 5px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{@hk_cdn}/js/forms/dashboardLogs.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        deleteClientLogsForm();
        updateClientLogs();
        $('#update').click(function(event) {
            updateClientLogs();
        });
    });
</script>