<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["escritorio"])) 
{
    header("Location: login.html");
}
else
{
require 'header.php';
if ($_SESSION['escritorio']==1) 
{
  require_once "../modelos/Consultas.php";
  $consulta=new Consultas();


  $rsptac = $consulta->totalcomprahoy();
  if ($rsptac){
    $regc = $rsptac->fetch_object();
    $totalc = $regc->total_compra;  
  } else{
    $totalc = 0;
  }

  $rsptav = $consulta->totalventahoy();
  if ($rsptav){
    $regv = $rsptav->fetch_object();
    $totalv = $regv->total_venta;
  } else{
    $totalv = 0;
  }

  $rsptaca = $consulta->totalcajahoy();
  if ($rsptaca){
    $regca = $rsptaca->fetch_object();
    $totalca = $regca->total_caja;
  } else{
    $totalca = 0;
  }
  

  //Datos para mostrar el gráfico de barras de las compras
  $compras10 = $consulta->comprasultimos_10dias();
  $fechasc='';
  $totalesc='';
  if ($compras10){
    while ($regfechac= $compras10->fetch_object()) {
      $fechasc=$fechasc.'"'.$regfechac->fecha .'",';
      $totalesc=$totalesc.$regfechac->total .','; 
    } 
  }
  //Quitamos la última coma
  $fechasc=substr($fechasc, 0, -1);
  $totalesc=substr($totalesc, 0, -1);
 
  //Datos para mostrar el gráfico de barras de las ventas
  $ventas12 = $consulta->ventasultimos_12meses();
  $fechasv='';
  $totalesv='';
  if ($ventas12){
    while ($regfechav= $ventas12->fetch_object()) {
      $fechasv=$fechasv.'"'.$regfechav->fecha .'",';
      $totalesv=$totalesv.$regfechav->total .','; 
    } 
  }
  //Quitamos la última coma
  $fechasv=substr($fechasv, 0, -1);
  $totalesv=substr($totalesv, 0, -1);

  $caja10 = $consulta->cajaultimos_10dias();
  $fechasca='';
  $totalesca='';
  if ($caja10){
    while ($regfechaca= $caja10->fetch_object()) {
      $fechasca=$fechasca.'"'.$regfechaca->fecha .'",';
      $totalesca=$totalesca.$regfechaca->total .','; 
    } 
  }
  //Quitamos la última coma
  $fechasca=substr($fechasca, 0, -1);
  $totalesca=substr($totalesca, 0, -1);
?>
<!--Contenido-->

<head>
    <link rel="stylesheet"
        type="text/css"
        href="../public/css/escritorio.css">
</head>
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Escritorio</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body">
                        <div class="card0 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h4 stille="font-size:17px;">
                                            <strong>
                                                $ <?php echo $totalca; ?>
                                            </strong>
                                        </h4>
                                        <p>Caja</p>
                                    </div>
                                    <div class="icon">
                                        <i class="icn icn-bag"></i>
                                    </div>
                                    <a href="caja.php" data-toggle="tooltip" data-placement="bottom" title="Ir a Caja"
                                        class="small-box-footer">Caja <i
                                            class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card1 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h4 stille="font-size:17px;">
                                            <strong>
                                                $ <?php echo $totalc; ?>
                                            </strong>
                                        </h4>
                                        <p>Compras</p>
                                    </div>
                                    <div class="icon">
                                        <i class="icn icn-bag"></i>
                                    </div>
                                    <a href="compra.php" data-toggle="tooltip" data-placement="bottom" title="Ir a compras"
                                        class="small-box-footer">Compras <i
                                            class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="card2 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h4 stille="font-size:17px;">
                                            <strong>
                                                $ <?php echo $totalv; ?>
                                            </strong>
                                        </h4>
                                        <p>Ventas</p>
                                    </div>
                                    <div class="icon">
                                        <i class="icn icn-bag"></i>
                                    </div>
                                    <a href="venta.php" data-toggle="tooltip" data-placement="bottom" title="Ir a ventas"
                                        class="small-box-footer">Ventas <i
                                            class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                    </div>
                    <!-- <div class="panel-body caja1"> -->
                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <div class="box-header with-border">
                                    Caja de los ultimos 10 días
                                </div>
                                <div class="box-body">
                                    <canvas id="caja"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="box-header with-border">
                                    Compras de los últimos 10 días
                                </div>
                                <div class="box-body">
                                    <canvas id="compras"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="box-header with-border">
                                    Ventas de los últimos 12 meses
                                </div>
                                <div class="box-body">
                                    <canvas id="ventas"></canvas>
                                </div>
                            </div>
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
  header("Location: producto.php");
}
require 'footer.html';
?>
<!--<script type="text/javascript" src="scripts/categoria.js"></script>-->
<script src="../public/js/chart.min.js"></script>
<script src="../public/js/Chart.bundle.min"></script>
<script type="text/javascript">
var ctx = document.getElementById("caja").getContext('2d');
var caja = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasca; ?>],
        datasets: [{
            label: '# Caja en $ de los últimos 10 días',
            data: [<?php echo $totalesca; ?>],
            backgroundColor: [
                'rgba(6, 57, 64, 0.2)',
                'rgba(142, 189, 182, 0.2)',
                'rgba(62, 131, 140, 0.2)',
                'rgba(25, 94, 99, 0.2)',
                'rgba(6, 57, 64, 0.2)',
                'rgba(142, 189, 182, 0.2)',
                'rgba(62, 131, 140, 0.2)',
                'rgba(25, 94, 99, 0.2)',
                'rgba(6, 57, 64, 0.2)',
                'rgba(142, 189, 182, 0.2)'
            ],
            borderColor: [
                'rgba(6, 57, 64, 0.2))',
                'rgba(142, 189, 182, 1)',
                'rgba(62, 131, 140, 1)',
                'rgba(25, 94, 99, 1)',
                'rgba(6, 57, 64, 0.2))',
                'rgba(142, 189, 182, 1)',
                'rgba(62, 131, 140, 1)',
                'rgba(25, 94, 99, 1)',
                'rgba(6, 57, 64, 0.2))',
                'rgba(142, 189, 182, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

var ctx = document.getElementById("compras").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc; ?>],
        datasets: [{
            label: '# Compras en $ de los últimos 10 días',
            data: [<?php echo $totalesc; ?>],
            backgroundColor: [
                'rgba(6, 57, 64, 0.2)',
                'rgba(142, 189, 182, 0.2)',
                'rgba(62, 131, 140, 0.2)',
                'rgba(25, 94, 99, 0.2)',
                'rgba(6, 57, 64, 0.2)',
                'rgba(142, 189, 182, 0.2)',
                'rgba(62, 131, 140, 0.2)',
                'rgba(25, 94, 99, 0.2)',
                'rgba(6, 57, 64, 0.2)',
                'rgba(142, 189, 182, 0.2)'
            ],
            borderColor: [
                'rgba(6, 57, 64, 0.2))',
                'rgba(142, 189, 182, 1)',
                'rgba(62, 131, 140, 1)',
                'rgba(25, 94, 99, 1)',
                'rgba(6, 57, 64, 0.2))',
                'rgba(142, 189, 182, 1)',
                'rgba(62, 131, 140, 1)',
                'rgba(25, 94, 99, 1)',
                'rgba(6, 57, 64, 0.2))',
                'rgba(142, 189, 182, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});



var ctx = document.getElementById("ventas").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
            label: '# Ventas en $ de los últimos 12 meses',
            data: [<?php echo $totalesv; ?>],
            backgroundColor: [
                'rgba(6, 57, 64, 0.2)',
                'rgba(142, 189, 182, 0.2)',
                'rgba(62, 131, 140, 0.2)',
                'rgba(25, 94, 99, 0.2)',
                'rgba(6, 57, 64, 0.2)',
                'rgba(142, 189, 182, 0.2)',
                'rgba(62, 131, 140, 0.2)',
                'rgba(25, 94, 99, 0.2)',
                'rgba(6, 57, 64, 0.2)',
                'rgba(142, 189, 182, 0.2)',
                'rgba(62, 131, 140, 0.2)',
                'rgba(25, 94, 99, 0.2)'
            ],
            borderColor: [
                'rgba(6, 57, 64, 0.2))',
                'rgba(142, 189, 182, 1)',
                'rgba(62, 131, 140, 1)',
                'rgba(25, 94, 99, 1)',
                'rgba(6, 57, 64, 0.2))',
                'rgba(142, 189, 182, 1)',
                'rgba(62, 131, 140, 1)',
                'rgba(25, 94, 99, 1)',
                'rgba(6, 57, 64, 0.2))',
                'rgba(142, 189, 182, 1)',
                'rgba(62, 131, 140, 1)',
                'rgba(25, 94, 99, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
</script>
<?php 
}
ob_end_flush();
?>