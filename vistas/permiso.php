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
                          <h1 class="box-title">Permiso</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Nombre</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Nombre</th>
                          </tfoot>
                        </table>
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
?>
<script type="text/javascript" src="scripts/permiso.js"></script>
<?php 
}
ob_end_flush();
?>