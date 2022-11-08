<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Compra.php";
 
$compra=new Compra();
 
$idcompra=isset($_POST["idcompra"])? limpiarCadena($_POST["idcompra"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";
 
switch ($_GET["op"]){
    case 'guardaryeditar':
        if (empty($idcompra)){
            $rspta=$compra->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST["idproducto"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"]);
            echo $rspta ? "compra registrado" : "No se pudieron registrar todos los datos del compra";
        }
        else {
        }
    break;
 
    case 'anular':
        $rspta=$compra->anular($idcompra);
        echo $rspta ? "compra anulado" : "compra no se puede anular";
    break;
 
    case 'mostrar':
        $rspta=$compra->mostrar($idcompra);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;
 
    case 'listarDetalle':
        //Recibimos el idcompra
        $id=$_GET['id'];
 
        $rspta = $compra->listarDetalle($id);
        $total=0;
        echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>U. Medida</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Subtotal</th>
                                </thead>';
 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->uMedida.'</td><td>'.$reg->precio_compra.'</td><td>'.$reg->precio_venta.'</td><td>'.$reg->precio_compra*$reg->cantidad.'</td></tr>';
                    $total=$total+($reg->precio_compra*$reg->cantidad);
                }
        echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">$'.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                                </tfoot>';
    break;
 
    case 'listar':
        $rspta=$compra->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->estado=='Aceptado')?'<button data-toggle="tooltip" data-placement="right" title="Mostrar Compra" class="btn btn-warning" onclick="mostrar('.$reg->idcompra.')"><i class="fa fa-eye"></i></button>'.
                    ' <button data-toggle="tooltip" data-placement="right" title="Anular Compra" class="btn btn-danger" id="btnanular" onclick="anular('.$reg->idcompra.')"><i class="fa fa-close"></i></button>':
                    '<button data-toggle="tooltip" data-placement="right" title="Mostrar Compra" class="btn btn-warning" onclick="mostrar('.$reg->idcompra.')"><i class="fa fa-eye"></i></button>',
                "1"=>$reg->fecha,
                "2"=>$reg->proveedor,
                "3"=>$reg->usuario,
                "4"=>$reg->num_comprobante,
                "5"=>$reg->total_compra,
                "6"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
                '<span class="label bg-red">Anulado</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;
 
    case 'selectProveedor':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
 
        $rspta = $persona->listarP();
 
        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
                }
    break;
 
    case 'listarproductos':
        require_once "../modelos/Producto.php";
        $producto=new Producto();
 
        $rspta=$producto->listarActivosCompra();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button data-toggle="tooltip" data-placement="right" title="Agregar Producto" class="btn btn-warning" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',\''.$reg->uMedida.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->rubro,
                "3"=>$reg->stock,
                "4"=>$reg->uMedida
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
}
?>