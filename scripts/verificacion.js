let to_email = "";
let verification_code = "";
let attempts = 0;

function sendEmail() {
    to_email = document.getElementById("emailInput").value;
    verification_code = Math.floor(100000 + Math.random() * 900000).toString();

    // _API_KEY de EmailJS

    emailjs.init(""); 

    emailjs.send("service_p1303z8", "template_35zk3u1", {
        to_email: to_email,
        verification_code: verification_code
    }).then(response => {
        console.log("Email enviado correctamente", response);
        localStorage.setItem("verification_code", verification_code);
        localStorage.setItem("to_email", to_email);
        window.location.href = "verificacion.html";
    }).catch(error => {
        console.error("Error al enviar el email", error);
    });
}

function startCountdown() {
    let timeLeft = 180;
    const timerElement = document.getElementById("timer");
    const countdown = setInterval(() => {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        timerElement.textContent = `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            localStorage.clear();
            window.location.href = "/Sintesi/index.html";
        }
        timeLeft--;
    }, 1000);
}

function verifyCode() {
    const userCode = document.getElementById("verificationCode").value;
    const storedCode = localStorage.getItem("verification_code");

    if (userCode === storedCode) {
        localStorage.setItem("verified_email", localStorage.getItem("to_email"));
        window.location.href = "/html/formulario.html"; // Redirigir a la página de éxito
    } else {
        attempts++;
        if (attempts >= 3) {
            localStorage.clear();
            window.location.href = "/html/veriemail.html";
        } else {
            window.location.href = "/html/error.html";
        }
    }
}

// Iniciar la cuenta atrás solo si estamos en verificacion.html
if (window.location.pathname.includes("/html/verificacion.html")) {
    startCountdown();
}
