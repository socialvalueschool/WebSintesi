document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("loginForm").addEventListener("submit", async function (event) {
        event.preventDefault();

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();
        const errorMessage = document.getElementById("errorMessage");

        if (!email || !password) {
            errorMessage.textContent = "Por favor, completa todos los campos.";
            return;
        }

        const formData = new FormData();
        formData.append("email", email);
        formData.append("password", password);

        try {
            const response = await fetch("/php/login.php", {
                method: "POST",
                body: formData
            });

            const result = await response.json();

            if (result.status === "success") {
                window.location.href = "/html/bloga.html";
            } else {
                errorMessage.textContent = result.mensaje;
            }
        } catch (error) {
            errorMessage.textContent = "Error en la solicitud. Inténtalo de nuevo.";
            console.error("Error:", error);
        }
    });
});
