var tabla;
 
//Función que se ejecuta al inicio
function init(){
    mostrarform(true);
    cajaAbierta();
    
 
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);  
    });
    //Cargamos los items al select proveedor
    $.post("../controlador/venta.php?op=selectCliente", function(r){
                $("#idcliente").html(r);
                $('#idcliente').selectpicker('refresh');
    });
}
 
//Función limpiar
function limpiar()
{
    $("#idcliente").val("");
    $("#cliente").val("");
    $("#serie_comprobante").val("");
    $("#num_comprobante").val("");
    $("#impuesto").val("0");
 
    $("#total_venta").val("");
    $(".filas").remove();
    $("#total").html("0");
 
    //Obtenemos la fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);
 

    $("#tipo_comprobante").val("Boleta");
    $("#tipo_comprobante").selectpicker('refresh');
}
 
//Función mostrar formulario
function mostrarform(flag)
{
    limpiar();
    if (flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        listarProductos();
 
        $("#btnGuardar").hide();
        $("#btnAgregarArt").show();
        $("#btnver").show();
        detalles=0;
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#btnver").hide();
        listar();
    }
}
 
//Función cancelarform
function cancelarform()
{
    limpiar();
    mostrarform(false);
}
 
//Función Listar
function listar()
{
    tabla=$('#tbllistado').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [               
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],
        "ajax":
                {
                    url: '../controlador/venta.php?op=listar',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                        console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 10,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
}
 
 
//Función ListarProductos
function listarProductos()
{
    tabla=$('#tblproductos').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    url: '../controlador/venta.php?op=listarProductosVenta',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                        console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 10,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
}
//Función para guardar o editar
 
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../controlador/venta.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
 
        success: function(datos)
        {                    
              bootbox.alert(datos);           
              mostrarform(true);
        }
 
    });
    limpiar();
}
 
function mostrar(idventa)
{
    $.post("../controlador/venta.php?op=mostrar",{idventa : idventa}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
 
        $("#idventa").val(data.idventa);
        $("#idcliente").val(data.idcliente);
        $("#idcliente").selectpicker('refresh');
        $("#tipo_comprobante").val(data.tipo_comprobante);
        $("#tipo_comprobante").selectpicker('refresh');
        $("#serie_comprobante").val(data.serie_comprobante);
        $("#num_comprobante").val(data.num_comprobante);
        $("#fecha_hora").val(data.fecha);
        $("#impuesto").val(data.impuesto);
 
        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnAgregarArt").hide();
    });
 
    $.post("../controlador/venta.php?op=listarDetalle&id="+idventa,function(r){
            $("#detalles").html(r);
    }); 
}
 
//Función para anular registros
function anular(idventa)
{
    bootbox.confirm("¿Está Seguro de anular la venta?", function(result){
        if(result)
        {
            $.post("../controlador/venta.php?op=anular", {idventa : idventa}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}
 
//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);
 
function marcarImpuesto()
  {
    var tipo_comprobante=$("#tipo_comprobante option:selected").text();
    if (tipo_comprobante=='Factura')
    {
        $("#impuesto").val(impuesto); 
    }
    else
    {
        $("#impuesto").val("0"); 
    }
  }
 
function agregarDetalle(idproducto,producto,precio_venta,uMedida)
  {
    var cantidad=1;
    var descuento=0;
 
    if (idproducto!="")
    {
        var subtotal=cantidad*precio_venta;
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button data-toggle="tooltip" data-placement="right" title="Eliminar Detalle" type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
        '<td><input type="hidden" name="idproducto[]"value="'+idproducto+'">'+producto+'</td>'+
        '<td><input type="number" name="cantidad[]" step=".01" onchange="modificarSubototales()" onkeyup="modificarSubototales()" id="cantidad[]" value="'+cantidad+'"></td>'+
        '<td>'+uMedida+'</td>'+
        '<td><input type="number" name="precio_venta[]" onchange="modificarSubototales()" onkeyup="modificarSubototales()" id="precio_venta[]" value="'+precio_venta+'"></td>'+
        // '<td>'+precio_venta+'</td>'+
        '<td><input type="number" name="descuento[]" onchange="modificarSubototales()" onkeyup="modificarSubototales()" value="'+descuento+'"></td>'+
        '<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
        '</tr>';
        cont++;
        detalles=detalles+1;
        $('#detalles').append(fila);
        modificarSubototales();
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del producto");
    }
  }
 
  function modificarSubototales()
  {
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var sub = document.getElementsByName("subtotal");
 
    for (var i = 0; i <cant.length; i++) {
        var inpC=cant[i];
        var inpP=prec[i];
        var inpD=desc[i];
        var inpS=sub[i];
        var total = inpC.value * inpP.value
        var descuento = inpD.value * total / 100;
 
        // inpS.value=total - inpD.value;
        inpS.value= parseInt(total - descuento);
        document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotales();
 
  }
  function calcularTotales(){
    var sub = document.getElementsByName("subtotal");
    var total = 0.0;
 
    for (var i = 0; i <sub.length; i++) {
        total += document.getElementsByName("subtotal")[i].value;
    }
    $("#total").html("$ " + total);
    $("#total_venta").val(total);
    evaluar();
  }
 
  function evaluar(){
    if (detalles>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
    }
  }
 
  function eliminarDetalle(indice){
    $("#fila" + indice).remove();
    calcularTotales();
    detalles=detalles-1;
    evaluar()
  }

  function cajaAbierta(){
    $.post("../controlador/caja.php?op=cajaAbierta", function(r){
        if(r == 0){
            alert("Debe Abrir la Caja antes de Comenzar a Vender");
            window.location.href = "caja.php";
        }
    });
}
 
init();