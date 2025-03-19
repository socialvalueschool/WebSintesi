document.addEventListener('DOMContentLoaded', function() {
    const toEmail = localStorage.getItem('to_email');

    if (toEmail) {
        console.log("Correo electrónico recuperado:", toEmail);
    }

    // Inicializar Select2
    if ($('.select2').length) {
        $('.select2').select2();
    }

    // Inicializar el campo de teléfono con la librería intlTelInput
    const phoneInputField = document.querySelector("#phone");
    if (phoneInputField) {
        const phoneInput = window.intlTelInput(phoneInputField, {
            separateDialCode: true,
            preferredCountries: ['es', 'us'],
            initialCountry: "es"
        });
    }

    // Manejar el envío del formulario
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', async function(event) {
            event.preventDefault();
            
            // Verificar la validez del formulario
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);
            if (toEmail) {
                formData.append('correo', toEmail);
            }

            try {
                const response = await fetch("/php/register.php", {
                    method: "POST",
                    body: formData
                });
                
                // Verificar si la respuesta es exitosa
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }

                const result = await response.json();
                
                if (result.status === "success") {
                    alert("Registro exitoso");
                    window.location.href = '/html/login.html';
                } else {
                    alert(`Error: ${result.mensaje}`);
                }
            } catch (error) {
                alert("Error en la solicitud");
                console.error("Error:", error);
            }
        });
    }
});
