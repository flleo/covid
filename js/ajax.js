const buscador = document.getElementById('buscador');

buscador.addEventListener('keyup',(e)=>{
    
    const http = new XMLHttpRequest();

    const busco = buscador.value;

    http.onreadystatechange =(data)=>{
        if(data.target.readyState ===4 && data.target.status===200){
            document.getElementById('listado').innerHTML=data.target.response;
            
        }
    }

    http.open("POST","./data_source/listadoAv.php", true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send(`buscar=${busco}`);
})