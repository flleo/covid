
ser_ext='http://192.168.0.57/vcserver/';

//      FUNCIONES PARA RASTREADOR



// function alta(){

//     var config= new FormData();
//     config.append("accion", "alta");
//     config.append("dni", document.getElementById("dni").value.toUpperCase());
//     config.append("nombre", document.getElementById("nombre").value);
//     config.append("apellido_1", document.getElementById("apellido_1").value);
//     config.append("apellido_2", document.getElementById("apellido_2").value);
//     config.append("email", document.getElementById("email").value.toLowerCase());
//     config.append("telefono", document.getElementById("telefono").value);
//     config.append("estado", "contagiado");
//     config.append("id_usuario", document.getElementById("id_usuario").value);

//     var opcionesPregunta = {
//       method: 'POST',
//       body: config,
//       redirect: 'follow'
//     };

//     fetch(ser_ext+"serv_usu.php", opcionesPregunta)
//     .then(response => response.text())
//     .then(result => {
//         console.log(result);
//     })

//     // a continuación añadimos la nota.
//     nota();
    
// }

// function datosRas(){
    
//     document.getElementById("seccion").innerHTML= "";
//     var url="http://192.168.0.57/vcserver/serv_usu.php?accion=datos&dni="+document.getElementById("dni_rast").value.toUpperCase();

//     fetch(url)
//     .then(response => response.json())
//     .then(res => {
//         var respuesta="<div>Nombre: "+res[0].nombre +" "+res[0].apellido_1 +" "+res[0].apellido_2+"</div>";
//         respuesta+="<div>DNI: "+res[0].dni+"</div><div>Telefono: "+res[0].telefono+"</div><div>Email: "+res[0].email+"</div>";
//         respuesta+="<div>Código de acceso: "+res[0].codigo_acceso+"</div><div>Estado actual: <b>"+res[0].estado+"</b></div><br>";
//         respuesta+="<div>Fecha primer diagnóstico: "+res[0].fecha+"</div><div>Rastreador: "+res[0].id_usuario+"</div><div>Nº de seguimientos: "+res[0].notas+"</b></div><br>";

//         document.getElementById("seccion").innerHTML=respuesta;

//     })
// }




//      FUNCIONES PARA MEDICO

function lista(id){  // terminada
    document.getElementById("adicional").innerHTML="";
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

async function datosPaciente(dni){      // terminado

    // datos del paciente
    var url=ser_ext+"serv_usu.php?accion=datos&dni="+dni;
    var respuesta="";

    const x = await fetch(url);
    const res = await x.json()

    var respuesta="<div class='row'> <div class='col-4'><b>Nombre: </b>"+res[0].nombre+" "+res[0].apellido_1+" "+ res[0].apellido_2+"</div>";
    respuesta+="<div class='col-2'><b>DNI: </b>"+dni+"</div><div class='col-2'><b>Teléfono: </b>"+res[0].telefono+"</div><div class='col-4'><b>Email: </b>"+res[0].email+"</div></div>";
    respuesta+="<div class='row'> <div class='col-4'><b>Código de acceso personal: </b>"+res[0].codigo_acceso+"</div> <div class='col-8'><b>Estado actual: </b>"+res[0].estado+"</div></div>";
    document.getElementById("seccion").innerHTML= respuesta; 
}

function historial(dni){  // terminado

    var cabecera="<b><u>HISTORIA CLÍNICA</b></u><br>";
    var xhttp = new XMLHttpRequest();
    var respuesta=cabecera+"Solicitando datos...";
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var respuesta = this.responseText;
        document.getElementById("adicional").innerHTML=cabecera + respuesta;
    }
    };
    xhttp.open("GET", 'data_source/notas_usuario.php?dni='+dni, true);
    xhttp.send();
    document.getElementById("adicional").innerHTML=respuesta;
}




//          FUNCIONES AUXILIARES


function limpiaAlta() {     //terminado
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

function limpiaFormMedico() {      //terminado
    document.getElementById('dni').value="";
    document.getElementById('codigo_acceso').value="";
    document.getElementById('apellido_1').value="";
    document.getElementById('apellido_2').value="";
    document.getElementById('nombre').value="";
    document.getElementById('contagiado').checked=false;
    document.getElementById('curado').checked=false;
    document.getElementById('fallecido').checked=false;
}

function listadosMedico(res){   // terminado
    var respuesta="<div class='row text-center'><div class='col-4'><h5>Apellidos</h5></div><div class='col-2'><h5>Nombre</h5></div><div class='col-2'><h5>DNI</h5></div><div class='col-2'><h5>Código de acceso</h5></div> <div class='col-2'><h5>Estado actual</h5></div></div>";
    for(i=0;i<res.length;i++){
        respuesta+="<div id='individuo' class='row text-center' onclick='editar(\""+res[i].dni+"\")'> <div class='col-2' >"+res[i].apellido_1+"</div> <div class='col-2'>"+res[i].apellido_2+"</div>";
        respuesta+="<div class='col-2'>"+res[i].nombre+"</div> <div class='col-2'>"+res[i].dni+"</div>";
        respuesta+="<div class='col-2'>"+res[i].codigo_acceso+"</div> <div class='col-2'>"+res[i].estado+"</div></div>";
    }
    return respuesta;
}

function editar(dni){       // terminado

    datosPaciente(dni)
    .then(res => formulario(dni));
 
    historial(dni);
}


function formulario (dni){      //terminado
    var respuesta='<hr> <form action="data_source/nueva_nota.php">';
    respuesta+="<div class='form-group'> <label for='nota'><b>Nota: </b></label> <textarea class='form-control' rows='5' name='nueva_nota' id='nota'></textarea>";
    respuesta+="<div class='row'><div class='col-8 text-left'>";
    respuesta+="<div class='form-check-inline'> <label class='form-check-label' for='est_cont'> <input type='radio' class='form-check-input' name='nuevo_estado' id='est_cont' value='contagiado' checked>Contagiado</label></div>";
    respuesta+="<div class='form-check-inline'> <label class='form-check-label' for='est_cur'> <input type='radio' class='form-check-input' name='nuevo_estado' id='est_cur' value='curado'>Curado</label></div>";
    respuesta+="<div class='form-check-inline'> <label class='form-check-label' for='est_fall'> <input type='radio' class='form-check-input' name='nuevo_estado' id='est_fall' value='fallecido'>Fallecido</label></div>";
    respuesta+="</div> <input type='hidden' name='dni' value='"+dni+"'>";
    respuesta+="<div class='col-4 text-right'><input type='submit' class='btn btn-secondary btn-sm' title='Añadir nota al historial del paciente' value='Añadir'></div> </div>";
    respuesta+="</div></form><hr>";
    document.getElementById("seccion").innerHTML+= respuesta;       
}