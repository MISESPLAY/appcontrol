let contender = null
let urlback = null

export function initElements(){
    contender = document.getElementById("app-organigrama")
    if (contender) {
        urlback = contender.dataset.url;
        console.log("urlLista", urlback)
    }
}
export async function loadOrganigrama(){
    if (urlback) return;
    contender.innerHTML = '<p>Datos cargando...</p>';


}
