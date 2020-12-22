import {validateEmail,validatePass,validateNombres} from "./Exp_regulares.js";
import {error} from "./error.js";



const form = document.getElementById('login-form');



form.addEventListener('click',(e)=>{

    switch (e.target.dataset.action) {
        case 'usuario':

            const validarEmail = validateEmail(document.getElementById('email').value);
            const validarPass = validatePass(document.getElementById('password').value);

            if(validarEmail && validarPass){

                e.target.setAttribute('type','submit');

            }else{

                error(document.getElementById('login-box'),"Email y contraseña son invalido");
            }
            
            break;
        
        case 'paciente':
            
            break;
    
        default:
            break;
    }
    
})  









