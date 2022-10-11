<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            </div>
        </div>
        <br>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Productos</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <button class="btn btn-success" id='btn-nuevo' type="button" data-toggle="modal" data-target='#modal-form'>Agregar</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="card-box table-responsive">
                                        <table class="table table-striped table-bordered nowrap" id="tablaCategorias" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Descripcion</th>
                                                    <th style="max-width: 150px; min-width: 150px;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Tabla responsiva-->
                                </div>
                                <!-- contenedor Tabla -->
                            </div>
                        </div>
                        <!-- Contenedor de toda la tabla -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Formulario Producto</h4>
            </div>
            <form action="" id="formulario">
                <div class="modal-body">
                    <p>Los campos con * son obligatorios</p>
                    <div class="error_formulario">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="nombre">Nombre<span class="required">*</span>
                        </label>
                        <div class="">
                            <input type="text" id="nombre" onkeyup="mayus(this);" minlength="0" maxlength="45" name="nombre" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descripcion" class="control-label">descripcion
                        </label>
                        <div class="">
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="2" placeholder="descripcion breve de la categoria"></textarea>
                        </div>
                    </div>

                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" id="btn-cerrar" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success pull-right" id="btn-guardar">Guardar</button>
                    <button class="btn btn-primary pull-right" type="reset">Borrar</button>
                </div>
            </form>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->