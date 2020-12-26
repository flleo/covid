const buscador = document.getElementById('buscador');

buscador.addEventListener('keyup',(e)=>{
    
    const http = new XMLHttpRequest();

    const busco = buscador.value;

    http.onreadystatechange =(data)=>{
        if(data.target.readyState ===4 && data.target.status===200){
            const listado = document.getElementById("nuevo");

            console.log(listado.nextSibling)
        }
    }

    http.open("POST","./data_source/listaAv.php", true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send(`buscar=${busco}`);
})