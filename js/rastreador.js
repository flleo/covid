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

    if (e.target.id === 'nuevoPaciente') {
        crearPaciente(e);
    }
})




const formPaciente = () => {
    const [url1, acceso] = url;
    seccion.innerHTML = `
    <div class="d-flex justify-content-around m-2 border-bottom">
        <div>DNI</div>
        <div>Nombre</div>
        <div>1 Apellido</div>
        <div>2 Apellido</div>
        <div>Email</div>
        <div>Telefono</div>
        <div>Estado</div>
        <div>Boton</div>
                       
    </div>   
    <form action='${url1}serv_usu.php' class='d-flex justify-content-around align-items-center' method='POST'>
    <div>
        <input type='text' name='nombre' placeholder='Enter email' id='nombre' require>
    </div>
    <div>
        <input type='text' name='apellido_1' placeholder='Enter email' id='apellido_1' require>
    </div>

    <div>
        <input type='text' name='apellido_2' placeholder='Enter email' id='apellido_2' require>
    </div>

    <div>
        <input type='text' name='dni' placeholder='Enter email' id='dni'>
    </div>

    <div>
        <input type='email' name='email' placeholder='Enter email' id='email'  require>
    </div>

    <div>
        <input type='tel' name='telefono' placeholder='Enter email' id='telefono'  require>
    </div>


    <div>
        <select name='estado' id='estado' require>
            <option value=''>---Seleccionar---</option>
            <option value='contagiado'>Contagiado</option>
            <option value='fallecido'>Fallecido</option>
            <option value='curado'>Curado</option>
        </select>
    </div>
    <button name='accion' type='button' value='alta' id='nuevoPaciente' class='btn btn-success col-1'>Nuevo</button>
</form>
    `;


}

const tablaPaciente = (pacientes) => {
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
            <tr id=${e.dni} >
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

const vistaPaciente = () => {

}

const crearPaciente = () => {
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

    console.log(document.getElementById('estado').value)

    const config = {
        method: 'POST',
        body: data
    };


    fetch(`${url1}serv_usu.php`, config)

}