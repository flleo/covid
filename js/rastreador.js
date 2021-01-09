const newPaciente = document.getElementById('newPaciente');
const buscar = document.getElementById('buscar');
const seccion = document.getElementById('infoRastreador');
let url;
let vista;


addEventListener('load', (e) => {


    const data = new FormData();

    data.append('envio', '1');

    const config = {
        method: 'POST',
        body: data
    };


    fetch("./bddsx/config.php", config)
        .then(res => res.json())
        .then(resp => url = resp)
})


newPaciente.addEventListener('click', (e) => {
    formPaciente();
})

buscar.addEventListener('click', (e) => {

    const [url1, acceso] = url;
    vista = `${url1}serv_usu.php?cas=${acceso}&accion=lista&filtro=`;


    fetch(vista)
        .then(response => response.json())
        .then(res => tablaPaciente(res))


})

seccion.addEventListener('click', (e) => {

    if (e.target.id === 'nuevoPaciente') crearPaciente(e);
    else if (e.target.id === 'updatePaciente') actualizarPaciente();
    else if (e.target.parentNode.classList[0] === 'dataPaciente') vistaPaciente(e.target.parentNode.id)



})




const formPaciente = () => {
    seccion.classList.remove('text-center');
    const [url1, acceso] = url;
    seccion.innerHTML = `
    <div id="login-box" class="col-md-6">
        <form id="login-form" method="post">
            <h3 class="text-center text-info">Agregar Paciente</h3>
            <div class="form-group">
                <label for="email" class="text-info">Dni</label><br>
                <input type="text" name="dni" id="dni" class="form-control" >
            </div>
            <div class="form-group">
                <label for="email" class="text-info">Email</label><br>
                <input type="email" name="email" id="email" class="form-control" >
            </div>
            
            <div class="form-group">
                <label for="nombre" class="text-info">Nombre</label><br>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="apellido1" class="text-info">Apellido1</label><br>
                <input type="text" name="apellido_1" id="apellido_1" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="apellido2" class="text-info">Apellido2</label><br>
                <input type="text" name="apellido_2" id="apellido_2" class="form-control" >
            </div>
            <div class="form-group">
                <label for="telefono" class="text-info">Teléfono</label><br>
                <input type="text" name="telefono" id="telefono" class="form-control" required>
            </div>  
            <div class="form-group">
                <select name='estado' id='estado' require>
                    <option value=''>---Seleccionar---</option>
                    <option value='contagiado'>Contagiado</option>
                    <option value='fallecido'>Fallecido</option>
                    <option value='curado'>Curado</option>
                </select>
            </div>                  
            <div class="form-group">
                <button id='nuevoPaciente' type="button" value='alta' name="submit" class="btn btn-info btn-md" >Nuevor</button>
            </div>
        </form>
    </div>
    `;


}

const tablaPaciente = (pacientes) => {
    seccion.classList.add('text-center');
    seccion.innerHTML = `
    <table class="table table-hover" id='listado'></table>`;
    document.getElementById('listado').innerHTML += `
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>1 Apellido</th>
                <th>2 Apellido</th>
                <th>Estado</th>
            </tr>
        </thead>
    `

    pacientes.forEach(e => {
        document.getElementById('listado').innerHTML += `
            <tr id=${e.dni} class='dataPaciente'>
                <td class='paciente'>${e.dni}</td>
                <td class='paciente'>${e.nombre}</td>
                <td class='paciente'>${e.apellido_1}</td>
                <td class='paciente'>${e.apellido_2}</td>
                <td class='paciente'>${e.estado}</td>
                
            </tr>
            `
    });

    seccion.innerHTML += "</table>"
}

const datoPaciente = async(dni) => {
    const response = await fetch(`${url}serv_usu.php?accion=datos&dni=${dni}`);
    const data = await response.json();
    vistaPaciente(data);

}

const vistaPaciente = async(dni) => {
    seccion.classList.remove('text-center');

    const [url1, acceso] = url;

    let urlext = `${url1}serv_usu.php?accion=datos&cas=${acceso}&dni=${dni}`;

    const x = await fetch(urlext);
    const res = await x.json();

    seccion.innerHTML = `
    <div id="login-box" class="col-md-6">
        <form id="login-form" method="post">
            <h3 class="text-center text-info">Agregar Paciente</h3>
            <div class="form-group">
                <label for="email" class="text-info">Dni</label><br>
                <input type="text" name="dni" id="dni" class="form-control" disabled value=${res[0].dni} >
            </div>
            <div class="form-group">
                <label for="email" class="text-info">Email</label><br>
                <input type="email" name="email" id="email" class="form-control" value=${res[0].email} >
            </div>
            
            <div class="form-group">
                <label for="nombre" class="text-info">Nombre</label><br>
                <input type="text" name="nombre" id="nombre" class="form-control" value=${res[0].nombre} required>
            </div>
            <div class="form-group">
                <label for="apellido1" class="text-info">Apellido1</label><br>
                <input type="text" name="apellido_1" id="apellido_1" class="form-control" value=${res[0].apellido_1} required>
            </div>
            <div class="form-group">
                <label for="apellido2" class="text-info">Apellido2</label><br>
                <input type="text" name="apellido_2" id="apellido_2" class="form-control" value=${res[0].apellido_2} >
            </div>
            <div class="form-group">
                <label for="telefono" class="text-info">Teléfono</label><br>
                <input type="text" name="telefono" id="telefono" class="form-control" value=${res[0].telefono} required>
            </div>                   
            <div class="form-group">
                <button id='updatePaciente' type="button" value="${res[0].codigo_acceso}" name="submit" class="btn btn-info btn-md" >Grabar</button>
            </div>
        </form>
    </div>
    `;

}

const crearPaciente = (e) => {
    const [url1, acceso] = url;
    const data = new FormData();

    data.append('nombre', `${document.getElementById('nombre').value}`);
    data.append('apellido_1', `${document.getElementById('apellido_1').value}`);
    data.append('apellido_2', `${document.getElementById('apellido_2').value}`);
    data.append('dni', `${document.getElementById('dni').value}`);
    data.append('email', `${document.getElementById('email').value}`);
    data.append('telefono', `${document.getElementById('telefono').value}`);
    data.append('estado', `${document.getElementById('estado').value}`);
    data.append('accion', `alta`);
    data.append('cas', `${acceso}`);

    const config = {
        method: 'POST',
        body: data
    };


    fetch(`${url1}serv_usu.php`, config)
        .then(resp => {
            if (resp.status == "404") console.log("algo paso")
        })

}

const actualizarPaciente = () => {
    const [url1, acceso] = url;
    const data = new FormData();

    data.append('nombre', `${document.getElementById('nombre').value}`);
    data.append('apellido_1', `${document.getElementById('apellido_1').value}`);
    data.append('apellido_2', `${document.getElementById('apellido_2').value}`);
    data.append('dni', `${document.getElementById('dni').value}`);
    data.append('email', `${document.getElementById('email').value}`);
    data.append('telefono', `${document.getElementById('telefono').value}`);
    data.append('codigo', `${document.getElementById('updatePaciente').value}`);
    data.append('accion', `actualizar_paciente`);
    data.append('cas', `${acceso}`);

    const config = {
        method: 'POST',
        body: data
    };

    fetch(`${url1}serv_usu.php`, config)

}