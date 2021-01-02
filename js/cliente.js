
ser_ext='http://192.168.0.57/vcserver/';

function nota(){
    var config= new FormData();
    config.append("accion", "nota");
    config.append("dni", document.getElementById("dni").value.toUpperCase());
    config.append("estado", "contagiado");
    config.append("id_usuario", document.getElementById("id_usuario").value);
    config.append("nota", document.getElementById("nota").value);

    var opcionesPregunta = {
      method: 'POST',
      body: config,
      redirect: 'follow'
    };

    fetch("http://192.168.0.57/vcserver/serv_usu.php", opcionesPregunta)
    .then(response => response.text())
    .then(result1 => {
        if (result1=="ok") {limpiaAlta();}
    })  
}


function alta(){

    var config= new FormData();
    config.append("accion", "alta");
    config.append("dni", document.getElementById("dni").value.toUpperCase());
    config.append("nombre", document.getElementById("nombre").value);
    config.append("apellido_1", document.getElementById("apellido_1").value);
    config.append("apellido_2", document.getElementById("apellido_2").value);
    config.append("email", document.getElementById("email").value.toLowerCase());
    config.append("telefono", document.getElementById("telefono").value);
    config.append("estado", "contagiado");
    config.append("id_usuario", document.getElementById("id_usuario").value);

    var opcionesPregunta = {
      method: 'POST',
      body: config,
      redirect: 'follow'
    };

    fetch("http://192.168.0.57/vcserver/serv_usu.php", opcionesPregunta)
    .then(response => response.text())
    .then(result => {
        console.log(result);
    })

    // a continuación añadimos la nota.
    nota();
    
}

function lista(id){  // terminada
    document.getElementById("seccion").innerHTML= "";
    var url;
    var titulo;
    if(id=="") {
        url=ser_ext+"serv_usu.php?accion=lista&filtro=";
        titulo="Listado completo de pacientes";
    }
    else {
        url=ser_ext+"serv_usu.php?accion=lista&filtro=id&valor="+id;
        titulo="Listado de mis pacientes";
    }
        
    document.getElementById('titulo').innerHTML=titulo;

    fetch(url)   
    .then(response => response.json())
    .then(res => {
        if(res.length>0) {
            document.getElementById("seccion").innerHTML=listadosMedico(res);
        }
        else {alert('No coincide con ningún registro');}
    })
}

function busqueda () {   // terminada
    var formulario= new Array();
    formulario=[document.getElementById('dni').value,document.getElementById('codigo_acceso').value,document.getElementById('apellido_1').value,document.getElementById('apellido_2').value,document.getElementById('nombre').value,document.getElementById('contagiado').checked,document.getElementById('curado').checked,document.getElementById('fallecido').checked];
    var url=ser_ext+"serv_usu.php?accion=lista&filtro=";

    if (formulario[0]!="") {                // busqueda por dni
        url+="dni&valor="+formulario[0].toUpperCase();
        fetch(url)
        .then(response => response.json())
        .then(res => { 
            if(res.length>0) {
                document.getElementById("seccion").innerHTML=listadosMedico(res);
                document.getElementById('titulo').innerHTML="Paciente";
            }
            else {alert('No coincide con ningún registro');}
        })
    }
    else{
        if (formulario[1]!="") {            // busqueda por código de acceso
            url+="codigo_acceso&valor="+formulario[1].toLowerCase();
            fetch(url)
            .then(response => response.json())
            .then(res => { 
                if(res.length>0) {
                    document.getElementById("seccion").innerHTML=listadosMedico(res);
                    document.getElementById('titulo').innerHTML="Paciente";
                }
                else {alert('No coincide con ningún registro');}
            })
        }
        else{
            if (formulario[2]!=""){         // busquda por apellidos
                url+="apellidos&valor="+formulario[2]+","+formulario[3]+","+formulario[4];
                fetch(url)
                .then(response => response.json())
                .then(res => {
                    if(res.length>0) {
                        document.getElementById("seccion").innerHTML=listadosMedico(res);
                        document.getElementById('titulo').innerHTML="Pacientes";
                    }
                    else {alert('No coincide con ningún registro');}
                })
            }
            else{
                if (formulario[5]||formulario[6]||formulario[7]){
                    url+="estado&valor="+formulario[5]+","+formulario[6]+","+formulario[7];
                    console.log(url);
                    fetch(url)
                    .then(response => response.json())
                    .then(res => {
                        if(res.length>0) {
                            document.getElementById("seccion").innerHTML=listadosMedico(res);
                            document.getElementById('titulo').innerHTML="Pacientes según criterio";
                        }
                        else {alert('No coincide con ningún registro');}
                    })
                }
                else {

                }

            }
        }
    }
    limpiaFormMedico();

}

function datosRas(){
    document.getElementById("seccion").innerHTML= "";
    var url="http://192.168.0.57/vcserver/serv_usu.php?accion=datos&dni="+document.getElementById("dni_rast").value.toUpperCase();

    fetch(url)
    .then(response => response.json())
    .then(res => {
        var respuesta="<div>Nombre: "+res[0].nombre +" "+res[0].apellido_1 +" "+res[0].apellido_2+"</div>";
        respuesta+="<div>DNI: "+res[0].dni+"</div><div>Telefono: "+res[0].telefono+"</div><div>Email: "+res[0].email+"</div>";
        respuesta+="<div>Código de acceso: "+res[0].codigo_acceso+"</div><div>Estado actual: <b>"+res[0].estado+"</b></div><br>";
        respuesta+="<div>Fecha primer diagnóstico: "+res[0].fecha+"</div><div>Rastreador: "+res[0].id_usuario+"</div><div>Nº de seguimientos: "+res[0].notas+"</b></div><br>";

        document.getElementById("seccion").innerHTML=respuesta;

    })
}

function modif(){
    var url="http://192.168.0.57/vcserver/serv_usu.php?accion=datos&dni="+document.getElementById("dni_rast").value.toUpperCase();

    fetch(url)
    .then(response => response.json())
    .then(res => {
        document.getElementById("nombre").value=res[0].nombre;
        document.getElementById("apellido_1").value=res[0].apellido_1;
        document.getElementById("apellido_2").value=res[0].apellido_2;
        document.getElementById("email").value=res[0].email;
        document.getElementById("telefono").value=res[0].telefono;
        document.getElementById("actualizar").innerHTML="<button class='boton' onclick='actualiza()' title='Actualiza los datos'>Actualizar</button>";
    })    
}

function histor(dni){  // en proceso
    document.getElementById("seccion").innerHTML= "";

    // datos del paciente
    var url=ser_ext+"serv_usu.php?accion=datos&dni="+dni;
    fetch(url)
    .then(response => response.json())
    .then(res => {
        var respuesta="";
        respuesta+="<div class='row'> <div class='col-4'><b>Nombre: </b>"+res[0].nombre+" "+res[0].apellido_1+" "+ res[0].apellido_2+"</div>";
        respuesta+="<div class='col-2'><b>DNI: </b>"+res[0].dni+"</div><div class='col-2'><b>Teléfono: </b>"+res[0].telefono+"</div><div class='col-4'><b>Email: </b>"+res[0].email+"</div></div>";
        respuesta+="<div class='row'> <div class='col-4'><b>Código de acceso personal: </b>"+res[0].codigo_acceso+"</div> <div class='col-2'><b>Estado actual: </b>"+res[0].estado+"</div></div>";
        respuesta+="<div class='form-group'> <label for='nota'><b>Nota: </b></label> <textarea class='form-control' rows='5' id='nota'></textarea></div> ";
        respuesta+="<div class='container text-right'><button type='button' onclick='' class='btn btn-secondary btn-sm' title='Añadir nota al historial del paciente'>Añadir</button></div>";

        respuesta+="<br><b><u>HISTORIA CLÍNICA</b></u><br><hr>";
        document.getElementById("seccion").innerHTML= respuesta;
    })

    // Hitorial
    url=ser_ext+"serv_usu.php?accion=notas&dni="+dni;
    fetch(url)   
    .then(response => response.json())
    .then(res => {
        console.log(res);
        var respuesta="";


        for(i=0;i<res.length;i++){
            respuesta+="<div>Rastreador: "+res[i].id_usuario+"<div></div>Fecha: "+res[i].fecha+"</div><br>";
            respuesta+="<div>"+res[i].nota+"</div><br>";
        }
        document.getElementById("seccion").innerHTML+=respuesta;
    })
}





function limpiaAlta() {
    document.getElementById("dni").value="";
    document.getElementById("nombre").value="";
    document.getElementById("apellido_1").value="";
    document.getElementById("apellido_2").value="";
    document.getElementById("email").value="";
    document.getElementById("telefono").value="";
    document.getElementById("nota").value="";
    document.getElementById("id_usuario").value="";
    alert("Paciente añadido/modificado");
}

function limpiaFormMedico() {
    document.getElementById('dni').value="";
    document.getElementById('codigo_acceso').value="";
    document.getElementById('apellido_1').value="";
    document.getElementById('apellido_2').value="";
    document.getElementById('nombre').value="";
    document.getElementById('contagiado').checked=false;
    document.getElementById('curado').checked=false;
    document.getElementById('fallecido').checked=false;


}

function listadosMedico(res){
    var respuesta="<div class='row text-center'><div class='col-4'><h5>Apellidos</h5></div><div class='col-2'><h5>Nombre</h5></div><div class='col-2'><h5>DNI</h5></div><div class='col-2'><h5>Código de acceso</h5></div> <div class='col-2'><h5>Estado actual</h5></div></div>";
    for(i=0;i<res.length;i++){
        respuesta+="<div id='individuo' class='row text-center' onclick='editar(\""+res[i].dni+"\")'> <div class='col-2' >"+res[i].apellido_1+"</div> <div class='col-2'>"+res[i].apellido_2+"</div>";
        respuesta+="<div class='col-2'>"+res[i].nombre+"</div> <div class='col-2'>"+res[i].dni+"</div>";
        respuesta+="<div class='col-2'>"+res[i].codigo_acceso+"</div> <div class='col-2'>"+res[i].estado+"</div></div>";
    }
    return respuesta;
}

function editar(dni){

    histor(dni);


}