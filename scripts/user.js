document.addEventListener("DOMContentLoaded", async function () {
    try {
        const response = await fetch("/php/user.php");
        const result = await response.json();

        // Mapa de códigos de país a nombre completo
        const paises = {
            "es": "España",
            "us": "Estados Unidos",
            "fr": "Francia",
            "gb": "Reino Unido"
            // Puedes agregar más países según sea necesario
        };

        if (result.status === "success") {
            document.getElementById("nombre_usuario").textContent = result.nombre_usuario;
            document.getElementById("ciudad").textContent = result.ciudad;

            // Mostrar nombre completo del país
            const paisNombre = paises[result.pais.toLowerCase()] || result.pais; // Si no se encuentra el código, se muestra tal cual
            document.getElementById("pais").textContent = paisNombre;

            document.getElementById("telefono").textContent = result.telefono;
        } else {
            document.getElementById("content").innerHTML = `<p style="color: red;">${result.mensaje}</p>`;
        }
    } catch (error) {
        console.error("Error al obtener datos del usuario:", error);
    }
});
