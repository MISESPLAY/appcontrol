import { initElements, rederizar } from './components/tabla.js';

document.addEventListener('DOMContentLoaded', () => {

    // 1. Buscar los elementos (divs)
    initElements();

    // 2. Pintar la tabla automáticamente al entrar
    rederizar();

});
