<?php 
require_once "../modelos/Persona.php";
 
$persona=new Persona();
 
$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$tipo_persona=isset($_POST["tipo_persona"])? limpiarCadena($_POST["tipo_persona"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$provincia=isset($_POST["provincia"])? limpiarCadena($_POST["provincia"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
 
switch ($_GET["op"]){
    case 'guardaryeditar':
        if (empty($idpersona)){
            $rspta=$persona->insertar($tipo_persona,$nombre,$num_documento,$provincia,$direccion,$telefono,$email);
            echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
        }
        else {
            $rspta=$persona->editar($idpersona,$tipo_persona,$nombre,$num_documento,$provincia,$direccion,$telefono,$email);
            echo $rspta ? "Persona actualizada" : "Persona no se pudo actualizar";
        }
    break;
 
    /* case 'eliminar':
        $rspta=$persona->eliminar($idpersona);
        echo $rspta ? "Persona eliminada" : "Persona no se puede eliminar";
    break;
  */
    case 'desactivar':
        $rspta=$persona->desactivar($idpersona);
        echo $rspta ? "producto Desactivado" : "producto no se puede desactivar";
    break;  

    case 'activar':
        $rspta=$persona->activar($idpersona);
        echo $rspta ? "producto activado" : "producto no se puede activar";
    break;

    case 'mostrar':
        $rspta=$persona->mostrar($idpersona);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;
 
    case 'listarp':
        $rspta=$persona->listarp();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->condicion)?'<button data-toggle="tooltip" data-placement="right" title="Editar Proveedor" class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button data-toggle="tooltip" data-placement="right" title="Desactivar Proveedor" class="btn btn-danger" onclick="desactivar('.$reg->idpersona.')"><i class="fa fa-close"></i></button>':
                    '<button data-toggle="tooltip" data-placement="right" title="No se puede editar" class="btn btn-primary" title="Editar persona disabled"><i class="fa fa-pencil"></i></button>'.
                    ' <button data-toggle="tooltip" data-placement="right" title="Activar Proveedor" class="btn btn-primary" onclick="activar('.$reg->idpersona.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->num_documento,
                "3"=>$reg->provincia,
                "4"=>$reg->direccion,
                "5"=>$reg->telefono,
                "6"=>$reg->email,
                "7"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
                '<span class="label bg-red">Desactivado</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;
 
    case 'listarc':
        $rspta=$persona->listarc();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->condicion)?'<button data-toggle="tooltip" data-placement="right" title="Editar Cliente" class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button data-toggle="tooltip" data-placement="right" title="Desactivar Cliente" class="btn btn-danger" onclick="desactivar('.$reg->idpersona.')"><i class="fa fa-close"></i></button>':
                    '<button data-toggle="tooltip" data-placement="right" title="No se puede editar" class="btn btn-primary" title="Editar persona disabled"><i class="fa fa-pencil"></i></button>'.
                    ' <button data-toggle="tooltip" data-placement="right" title="Activar Cliente" class="btn btn-primary" onclick="activar('.$reg->idpersona.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->num_documento,
                "3"=>$reg->direccion,
                "4"=>$reg->telefono,
                "5"=>$reg->email,
                "6"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
                '<span class="label bg-red">Desactivado</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;

    case 'listarr':
        $rspta=$persona->listarr();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->condicion)?'<button data-toggle="tooltip" data-placement="right" title="Editar Repartidor" class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button data-toggle="tooltip" data-placement="right" title="Desactivar Repartidor"class="btn btn-danger" onclick="desactivar('.$reg->idpersona.')"><i class="fa fa-close"></i></button>':
                    '<button data-toggle="tooltip" data-placement="right" title="No se puede editar" class="btn btn-primary" title="Editar persona disabled"><i class="fa fa-pencil"></i></button>'.
                    ' <button data-toggle="tooltip" data-placement="right" title="Activar Repartidor" class="btn btn-primary" onclick="activar('.$reg->idpersona.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->num_documento,
                "3"=>$reg->direccion,
                "4"=>$reg->telefono,
                "5"=>$reg->email,
                "6"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
                '<span class="label bg-red">Desactivado</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;

    case 'listarpa':
        $rspta=$persona->listarpa();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->condicion)?'<button data-toggle="tooltip" data-placement="right" title="Editar Panadero" class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button data-toggle="tooltip" data-placement="right" title="Desavtivar Panadero" class="btn btn-danger" onclick="desactivar('.$reg->idpersona.')"><i class="fa fa-close"></i></button>':
                    '<button data-toggle="tooltip" data-placement="right" title="No se puede editar" class="btn btn-primary" title="Editar persona disabled"><i class="fa fa-pencil"></i></button>'.
                    ' <button data-toggle="tooltip" data-placement="right" title="Activar Panadero" class="btn btn-primary" onclick="activar('.$reg->idpersona.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->num_documento,
                "3"=>$reg->direccion,
                "4"=>$reg->telefono,
                "5"=>$reg->email,
                "6"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
                '<span class="label bg-red">Desactivado</span>'
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