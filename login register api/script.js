const API_URL = "http://localhost/api.php";

function register() {
    const username = document.getElementById("reg-username").value;
    const password = document.getElementById("reg-password").value;

    fetch(API_URL, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: "register",
            username,
            password
        }),
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("response").innerText = data.message;
    })
    .catch(error => console.error("Error:", error));
}

function login() {
    const username = document.getElementById("login-username").value;
    const password = document.getElementById("login-password").value;

    fetch(API_URL, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: "login",
            username,
            password
        }),
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("response").innerText = data.message;
    })
    .catch(error => console.error("Error:", error));
}
