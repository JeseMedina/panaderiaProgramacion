<?php
ob_start();
session_start();
 
if (!isset($_SESSION["almacen"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
if ($_SESSION['almacen']==1)
{
?>
<!--Contenido-->

<head>
    <link rel="stylesheet"
        type="text/css"
        href="../public/css/general.css">
</head>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Actualiar Precio de Productos</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="panel-body"
                        id="formularioregistros">
                        <form name="formulario"
                            id="formulario"
                            method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Producto(*):</label>
                                <select id="idproducto"
                                    name="idproducto"
                                    class="form-control selectpicker"
                                    data-live-search="true"
                                    required></select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Precio Actual:</label>
                                <input type="number"
                                        class="form-control"
                                        name="precioactual"
                                        id="precioactual"
                                        placeholder="Precio Actual"
                                        required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Nuevo Precio(*):</label>
                                <input type="number"
                                        class="form-control"
                                        name="nuevoprecio"
                                        id="nuevoprecio"
                                        placeholder="Nuevo precio"
                                        required>
                            </div>
                            <div class="form-group botones col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button data-toggle="tooltip"
                                    title="Guardar Producto"
                                    data-placement="bottom"
                                    class="btn btn-primary guardar"
                                    type="submit"
                                    id="btnGuardar">Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
}
else
{
    header("Location: compra.php");
}
require 'footer.html';
?>
<script type="text/javascript"
    src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript"
    src="../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript"
    src="scripts/actualizarprecio.js"></script>
<script type="text/javascript"
    src="scripts/table_tooltips.js"></script>
<?php 
}
ob_end_flush();
?>