//Función que se ejecuta al inicio
function init(){
 
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);  
    });
    //Cargamos los items al select proveedor
    $.post("../controlador/producto.php?op=selectProducto", function(r){
                $("#idproducto").html(r);
                $('#idproducto').selectpicker('refresh');
    });
}


//Función limpiar
function limpiar() {
    $("#idproducto").val("");
    $("#precioactual").val("");
    $("#nuevoprecio").val("");
}

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controlador/producto.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }

    });
    limpiar();
}

init();