<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["personas"])) 
{
  header("Location: login.html");
}
else
{
require 'header.php';
if ($_SESSION['personas']==1) 
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
                        <h1 class="box-title">Usuario</h1>
                        <div class="boton-agregar">
                            <button title="Nuevo Usuario" class="btn btn-success"
                                id="btnagregar"
                                onclick="mostrarform(true)">
                                Agregar
                            </button>
                        </div>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive"
                        id="listadoregistros">
                        <table id="tbllistado"
                            class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Cargo</th>
                                <th>Login</th>
                                <th>Foto</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Cargo</th>
                                <th>Login</th>
                                <th>Foto</th>
                                <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>
                    <div class="panel-body"
                        id="formularioregistros">
                        <form name="formulario"
                            id="formulario"
                            method="POST">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Nombre (*):</label>
                                <input type="hidden"
                                    name="idusuario"
                                    id="idusuario">
                                <input type="text"
                                    class="form-control"
                                    name="nombre"
                                    id="nombre"
                                    maxlength="100"
                                    placeholder="Nombre"
                                    required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Número (*):</label>
                                <input type="text"
                                    class="form-control"
                                    name="num_documento"
                                    id="num_documento"
                                    maxlength="20"
                                    placeholder="Número del DNI"
                                    required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Dirección (*):</label>
                                <input type="text"
                                    class="form-control"
                                    name="direccion"
                                    id="direccion"
                                    maxlength="70"
                                    placeholder="Dirección">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Teléfono (*):</label>
                                <input type="text"
                                    class="form-control"
                                    name="telefono"
                                    id="telefono"
                                    maxlength="20"
                                    placeholder="Teléfono">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Email:</label>
                                <input type="text"
                                    class="form-control"
                                    name="email"
                                    id="email"
                                    maxlength="50"
                                    placeholder="Email">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Cargo (*):</label>
                                <input type="text"
                                    class="form-control"
                                    name="cargo"
                                    id="cargo"
                                    maxlength="20"
                                    placeholder="Cargo">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Login (*):</label>
                                <input type="text"
                                    class="form-control"
                                    name="login"
                                    id="login"
                                    maxlength="20"
                                    placeholder="Login"
                                    required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Clave (*):</label>
                                <input type="password"
                                    class="form-control"
                                    name="clave"
                                    id="clave"
                                    maxlength="64"
                                    placeholder="Clave"
                                    required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label class="label_permiso">Permisos (*): </label>
                                <ul style="list-style: none;"
                                    id="permisos">
                                </ul>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Imagen:</label>
                                <input type="file"
                                    class="form-control"
                                    name="imagen"
                                    id="imagen">
                                <input type="hidden"
                                    name="imagenactual"
                                    id="imagenactual">
                                <img src=""
                                    width="150px"
                                    height="120px"
                                    id="imagenmuestra">
                            </div>
                            <div class="form-group botones col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button data-toggle="tooltip" 
                                    title="Guardar Usuario"
                                    data-placement="bottom" 
                                    class="btn btn-primary guardar"
                                    type="submit"
                                    id="btnGuardar"> 
                                    Guardar
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
                    <!--Fin centro -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
<!--Fin-Contenido-->
<?php
}
else
{
    header("Location: ventasfechacliente.php");
}
require 'footer.html';
}
?>
<script type="text/javascript"
    src="scripts/usuario.js"></script>
<script type="text/javascript" src="scripts/table_tooltips.js"></script>