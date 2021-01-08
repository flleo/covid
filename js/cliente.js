
ser_ext='http://192.168.0.57/vcserver/';

// ser_ext = 'http://192.168.1.10/covid/';
//      FUNCIONES PARA RASTREADOR

cod_acc_serv='a2b7878e96994cfdf318';


//      FUNCIONES PARA MEDICO Y ADMINISTRADOR

function lista(id) {  // terminada

    document.getElementById("adicional").innerHTML = "";
    document.getElementById("seccion").innerHTML = "";
  
    var url;
    var titulo;
    if (id == "") {         // listado completo de pacientes
        url = ser_ext + "serv_usu.php?accion=lista&cas="+cod_acc_serv+"&filtro=";
        titulo = "Listado de pacientes";
    }
    else {                  // listado de mis pacientes
        url = ser_ext + "serv_usu.php?accion=lista&cas="+cod_acc_serv+"&filtro=id&valor=" + id;
        titulo = "Listado de mis pacientes";
    }

    document.getElementById('titulo').innerHTML = titulo;

    fetch(url)
        .then(response => response.json())
        .then(res => {
            if (res.length > 0) {
        
                    document.getElementById("seccion").innerHTML = listadosMedico(res);
             
            }
            else { alert('No coincide con ningún registro'); }
        })
}

function busqueda() {   // terminada
    var formulario = new Array();
    formulario = [document.getElementById('dni').value, document.getElementById('codigo_acceso').value, document.getElementById('apellido_1').value, document.getElementById('apellido_2').value, document.getElementById('nombre').value, document.getElementById('contagiado').checked, document.getElementById('curado').checked, document.getElementById('fallecido').checked];
    var url = ser_ext + "serv_usu.php?accion=lista&cas="+cod_acc_serv+"&filtro=";

    if (formulario[0] != "") {                // busqueda por dni
        url += "dni&valor=" + formulario[0].toUpperCase();
        fetch(url)
            .then(response => response.json())
            .then(res => {
                if (res.length > 0) {
                        document.getElementById("seccion").innerHTML = listadosMedico(res);
                                                       
                    document.getElementById('titulo').innerHTML = "Paciente";
                }
                else { alert('No coincide con ningún registro'); }
            })
    }
    else {
        if (formulario[1] != "") {            // busqueda por código de acceso
            url += "codigo_acceso&valor=" + formulario[1].toLowerCase();
            fetch(url)
                .then(response => response.json())
                .then(res => {
                    if (res.length > 0) {
                            document.getElementById("seccion").innerHTML = listadosMedico(res);
                       
                        document.getElementById('titulo').innerHTML = "Paciente";
                    }
                    else { alert('No coincide con ningún registro'); }
                })
        }
        else {
            if (formulario[2] != "") {         // busquda por apellidos
                url += "apellidos&valor=" + formulario[2] + "," + formulario[3] + "," + formulario[4];
                fetch(url)
                    .then(response => response.json())
                    .then(res => {
                        if (res.length > 0) {
                            document.getElementById("seccion").innerHTML = listadosMedico(res);
                             
                            document.getElementById('titulo').innerHTML = "Pacientes";
                        }
                        else { alert('No coincide con ningún registro'); }
                    })
            }
            else {
                if (formulario[5] || formulario[6] || formulario[7]) {      // busqueda por estado
                    url += "estado&valor=" + formulario[5] + "," + formulario[6] + "," + formulario[7];
                    console.log(url);
                    fetch(url)
                        .then(response => response.json())
                        .then(res => {
                            if (res.length > 0) {
                                document.getElementById("seccion").innerHTML = listadosMedico(res);
                              
                                document.getElementById('titulo').innerHTML = "Pacientes según criterio";
                            }
                            else { alert('No coincide con ningún registro'); }
                        })
                }
                else {

                }

            }
        }
    }
    limpiaFormMedico();

}

async function datosPaciente(dni) {      // terminado

    // datos del paciente
    var url = ser_ext + "serv_usu.php?accion=datos&cas="+cod_acc_serv+"&dni=" + dni;
    var respuesta = "";

    const x = await fetch(url);
    const res = await x.json()

    var respuesta = "<div class='row'> <div class='col-4'><b>Nombre: </b>" + res[0].nombre + " " + res[0].apellido_1 + " " + res[0].apellido_2 + "</div>";
    respuesta += "<div class='col-2'><b>DNI: </b>" + dni + "</div><div class='col-2'><b>Teléfono: </b>" + res[0].telefono + "</div><div class='col-4'><b>Email: </b>" + res[0].email + "</div></div>";
    respuesta += "<div class='row'> <div class='col-4'><b>Código de acceso personal: </b>" + res[0].codigo_acceso + "</div> <div class='col-8'><b>Estado actual: </b>" + res[0].estado + "</div></div>";
  

    document.getElementById("seccion").innerHTML = respuesta;
    document.getElementById('titulo').innerHTML = "Notas del paciente";
}

function historial(dni) {  // Presenta el listado de notas del paciente

    var cabecera = "<b><u>HISTORIA CLÍNICA</b></u><br>";
    var xhttp = new XMLHttpRequest();
    var respuesta = cabecera + "Solicitando datos...";
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var respuesta = this.responseText;
            document.getElementById("adicional").innerHTML = cabecera + respuesta;
        }
    };
    xhttp.open("GET", 'data_source/notas_usuario.php?dni=' + dni, true);
    xhttp.send();
    document.getElementById("adicional").innerHTML = respuesta;
}


//          FUNCIONES AUXILIARES

function limpiaAlta() {     //terminado
    document.getElementById("dni").value = "";
    document.getElementById("nombre").value = "";
    document.getElementById("apellido_1").value = "";
    document.getElementById("apellido_2").value = "";
    document.getElementById("email").value = "";
    document.getElementById("telefono").value = "";
    document.getElementById("nota").value = "";
    document.getElementById("id_usuario").value = "";
    alert("Paciente añadido/modificado");
}

function limpiaFormMedico() {      //terminado
    document.getElementById('dni').value = "";
    document.getElementById('codigo_acceso').value = "";
    document.getElementById('apellido_1').value = "";
    document.getElementById('apellido_2').value = "";
    document.getElementById('nombre').value = "";
    document.getElementById('contagiado').checked = false;
    document.getElementById('curado').checked = false;
    document.getElementById('fallecido').checked = false;
}

function listadosMedico(res) {   // terminado
    var respuesta = "<div class='row text-center'>";
    respuesta += "  <div class='col-4'>";
    respuesta += "      <h5>Apellidos</h5>";
    respuesta += "  </div>";
    respuesta += "  <div class='col-2'>";
    respuesta += "      <h5>Nombre</h5>";
    respuesta += "  </div>";
    respuesta += "  <div class='col-2'>";
    respuesta += "      <h5>DNI</h5>";
    respuesta += "  </div>";
    respuesta += "  <div class='col-2'>";
    respuesta += "      <h5>Código de acceso</h5>";
    respuesta += "  </div>";
    respuesta += "  <div class='col-2'>";
    respuesta += "      <h5>Estado actual</h5>";
    respuesta += "  </div>";
    respuesta += "</div>";
    for (i = 0; i < res.length; i++) {
        respuesta += "<div id='editable' class='row text-center' onclick='editar(\"" + res[i].dni + "\")'>";
        respuesta += "  <div class='col-2'>" + res[i].apellido_1 + "</div>";
        respuesta += "  <div class='col-2'>" + res[i].apellido_2 + "</div>";
        respuesta += "  <div class='col-2'>" + res[i].nombre + "</div>";
        respuesta += "  <div class='col-2'>" + res[i].dni + "</div>";
        respuesta += "  <div class='col-2'>" + res[i].codigo_acceso + "</div>";
        respuesta += "  <div class='col-2'>" + res[i].estado + "</div>";
        respuesta += "</div>";
    }
    return respuesta;
}

function editar(dni,nota,estado,id_nota) {       // Pasa a la ventana de edición, donde se carga el formulario de nuevas notas y el listado de notas (historial).
    
    document.getElementById("menu_medico").style.display="none";
    document.getElementById("listas").style.display="none";

    datosPaciente(dni)
        .then(res => {formulario(dni);
            if (nota!=null) {
                document.getElementById("nota").value=nota;
                document.getElementById("bot_modif").value="Actualizar";
                document.getElementById("bot_modif").title="Actualizar la nota";
                document.getElementById("id_nota").value=id_nota;

                switch (estado) {
                    case 'contagiado':
                        document.getElementById("est_cont").checked=true;
                        break;
                    case 'curado':
                        document.getElementById("est_cur").checked=true;
                        break;
                    case 'fallecido':
                        document.getElementById("est_fall").checked=true;
                        break;
                }
            }
        });

    historial(dni);
}


function formulario(dni) {      // Presenta el formulario para añadir nuevas notas.
    var respuesta = '<hr> <form id="nueva_nota" action="data_source/nueva_nota.php">';
    respuesta += "<div class='form-group'>";
    respuesta += "  <label for='nota'><b>Nota: </b></label>";
    respuesta += "  <div class='row pb-2' >";
    respuesta += "      <textarea class='form-control' rows='5' name='nueva_nota' id='nota' required></textarea>";
    respuesta += "  </div>";
    respuesta += "  <div class='row'>";
    respuesta += "      <div class='col-10 text-left'>";
    respuesta += "          <div class='form-check-inline'>";
    respuesta += "              <label class='form-check-label' for='est_cont'> <input type='radio' class='form-check-input' name='nuevo_estado' id='est_cont' value='contagiado' checked>Contagiado</label>";
    respuesta += "          </div>";
    respuesta += "          <div class='form-check-inline'>";
    respuesta += "              <label class='form-check-label' for='est_cur'> <input type='radio' class='form-check-input' name='nuevo_estado' id='est_cur' value='curado'>Curado</label>";
    respuesta += "          </div>";
    respuesta += "          <div class='form-check-inline'>";
    respuesta += "              <label class='form-check-label' for='est_fall'> <input type='radio' class='form-check-input' name='nuevo_estado' id='est_fall' value='fallecido'>Fallecido</label>";
    respuesta += "          </div>";
    respuesta += "      </div>";
    respuesta += "      <input type='hidden' name='dni' value='" + dni + "'>";
    respuesta += "      <input type='hidden' name='id_nota' id='id_nota'>";   
    respuesta += "      <div class='col-2 text-right'>";
    respuesta += "          <input type='submit' class='btn btn-secondary btn-sm' title='Añadir nota al historial del paciente' name='bot_modif' value='Añadir' id='bot_modif'>";
    respuesta += "      </div>";
    respuesta += "  </div>";
    respuesta += "</div></form>";
    respuesta += "<div class='col-12 text-right '>";
    respuesta += "  <button class='btn btn-secondary btn-sm' title='Salir sin guardar los datos' onclick='confirmar()'>Salir</button>";
    respuesta += "</div><hr>";    
    document.getElementById("seccion").innerHTML += respuesta;
}

function confirmar() {      // Devuelve una alerta para el caso de pulsar el boton salir, si hay algún dato en la nota.
    console.log("aki");
    if (document.getElementById("nota").value==""){
         window.location.replace("medico.php");       
    }
    else {
        var opcion=confirm('Se dispone a salir sin guardar.\n\n¿Quiere salir y descartar los cambios?');
        if (opcion == true) {
            window.location.replace("medico.php");
        }
    }
};