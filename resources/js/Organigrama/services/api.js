export async function getDepartments(url) {
    try {
        const respuesta = await fetch(url);
        const  datos = await respuesta.json();
        return datos;
    }
    catch (error) {
        console.log("Error getting Departments");
        return null;
    }

}
