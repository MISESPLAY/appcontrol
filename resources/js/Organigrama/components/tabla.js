import { getDepartments } from "../services/api.js";

let contenedor = null;
let urlDatos = null;

export function initElements(){
    // IMPORTANTE: Revisa que en tu Blade el ID sea exactamente "tabla"
    contenedor = document.getElementById("tabla-colores");

    if (contenedor) {
        urlDatos = contenedor.dataset.url;
        console.log("✅ Elemento encontrado. URL:", urlDatos);
    } else {
        console.error("❌ ERROR: No encontré un div con id='tabla' en el HTML");
    }
}

export async function rederizar(){ // (Nota: Lo correcto es renderizar, pero sigamos tu nombre)

    // BLINDAJE: Si no hay URL, avisa por qué
    if (!urlDatos) {
        console.error("❌ ERROR: Intente renderizar pero no tengo URL. Revisa initElements.");
        return;
    }

    contenedor.innerHTML = 'cargando...';

    // Llamamos al servicio
    const datos = await getDepartments(urlDatos);

    // Validación de datos vacíos
    if (!datos) {
        contenedor.innerHTML = 'Error o sin datos';
        return;
    }

    contenedor.innerHTML = '';

    // CORRECCIÓN AQUÍ: Object con Mayúscula
    const listaDatos = Object.entries(datos);

    // DEBUG: Ver qué arreglo creó
    console.log("✅ Datos procesados:", listaDatos);

    listaDatos.forEach (([nombre, color]) => {
        contenedor.innerHTML += `
            <div
            style="
            border: 2px solid
            ${color};
            padding: 10px;
            margin: 5px;">
                <strong style="color: ${color}"> ${nombre} </strong>
            </div>
        `;
    });
}

