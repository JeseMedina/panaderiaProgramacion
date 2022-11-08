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
                        <h1 class="box-title">Rubros</h1> 
                        <div class="boton-agregar">
                            <button title="Nuevo Rubro"
                                    class="btn btn-success"
                                    id="btnagregar"
                                    onclick="mostrarform(true)">
                                    Agregar
                            </button>
                        </div>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="panel-body table-responsive"
                        id="listadoregistros">
                        <table id="tbllistado"
                            class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
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
                                <label>Nombre:</label>
                                <input type="hidden"
                                    name="idrubro"
                                    id="idrubro">
                                <input type="text"
                                    class="form-control"
                                    name="nombre"
                                    id="nombre"
                                    maxlength="50"
                                    placeholder="Nombre"
                                    required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Descripción:</label>
                                <input type="text"
                                    class="form-control"
                                    name="descripcion"
                                    id="descripcion"
                                    maxlength="256"
                                    placeholder="Descripción">
                            </div>
                            <div class="form-group botones col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button data-toggle="tooltip" 
                                    title="Guardar Rubro"
                                    data-placement="bottom"
                                    class="btn btn-primary guardar"
                                    type="submit"
                                    id="btnGuardar"> Guardar
                                </button>

                                <button data-toggle="tooltip" 
                                    title="Cancelar y volver atrás"
                                    data-placement="bottom"
                                    class="btn btn-danger cancelar"
                                    onclick="cancelarform()"
                                    type="button">
                                    Cancelar
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
    src="scripts/rubro.js"></script>
<script type="text/javascript" src="scripts/table_tooltips.js"></script>
<?php 
}
ob_end_flush();
?>