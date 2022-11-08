<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
 
if (!isset($_SESSION["reparto"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
 
if ($_SESSION['reparto']==1)
{
?>

<head>
    <link rel="stylesheet"
        type="text/css"
        href="../public/css/general.css">
</head>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title"> Finalizar Reparto</h1>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <div class="panel-body table-responsive"
                        id="listadoregistros">
                        <table id="tbllistadofinalizar"
                            class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Opciones</th>
                                <th>Nº</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Repartidor</th>
                                <th>Total Venta</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nº</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Repartidor</th>
                                <th>Total Venta</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body"
                        style="height: 400px;"
                        id="formularioregistros">
                        <form name="formulario"
                            id="formulario"
                            method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Cliente(*):</label>
                                <input type="hidden"
                                    name="idreparto"
                                    id="idreparto">
                                <select id="idcliente"
                                    name="idcliente"
                                    class="form-control selectpicker"
                                    data-live-search="true"
                                    required>

                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Repartidor(*):</label>
                                <select id="idrepartidor"
                                    name="idrepartidor"
                                    class="form-control selectpicker"
                                    data-live-search="true"
                                    required>

                                </select>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Fecha(*):</label>
                                <input type="date"
                                    class="form-control"
                                    name="fecha_hora"
                                    id="fecha_hora"
                                    required="">
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 pt-3">
                                <a data-toggle="modal"
                                    href="#myModal">
                                    <button title="Agregar Productos"
                                        id="btnAgregarArt"
                                        type="button"
                                        class="btn btn-primary"> <span class="fa fa-plus"></span>
                                        Agregar Productos</button>
                                </a>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <table id="detalles"
                                    class="table table-striped table-bordered table-condensed table-hover">
                                    <thead style="background-color:#A9D0F5">
                                        <th>Opciones</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>U. Medida</th>
                                        <th>Precio Venta</th>
                                        <th>Descuento</th>
                                        <th>Subtotal</th>
                                    </thead>
                                    <tfoot>
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <h4 id="total">$ 0.00</h4><input type="hidden"
                                                name="total_venta"
                                                id="total_venta">
                                        </th>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button title="Guardar Reparto"
                                    class="btn btn-primary"
                                    type="submit"
                                    id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                                <button title="Cancelar y Volver Atras"
                                    id="btnCancelar"
                                    class="btn btn-danger"
                                    onclick="cancelarform()"
                                    type="button"><i class="fa fa-arrow-circle-left"></i>
                                    Cancelar</button>
                            </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->

<!-- Modal -->
<div class="modal fade"
    id="myModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button title="Seleccionar Productos"
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-hidden="true">&times;</button>
                <h4 class="modal-title">Seleccione un Producto</h4>
            </div>
            <div class="modal-body">
                <table id="tblproductos"
                    class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>U. Medida</th>
                        <th>Precio Venta</th>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <th>Opciones</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>U. Medida</th>
                        <th>Precio Venta</th>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button title="Cerrar Ventana"
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal -->
<?php
}
else
{
    header("Location: produccion.php");
}
 
require 'footer.html';
?>
<script type="text/javascript"
    src="scripts/reparto.js"></script>
<script type="text/javascript" src="scripts/table_tooltips.js"></script>
<?php 
}
ob_end_flush();
?>