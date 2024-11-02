document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const resultDiv = document.getElementById('result');

    fetch('http://127.0.0.1:8000/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username, password }),
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.message || 'Erreur lors de la connexion');
                });
            }
            return response.json();
        })
        .then(data => {
            const token = data.token;

            if (!token) {
                throw new Error('Le token est manquant dans la réponse du serveur');
            }

            const expires = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000);
            document.cookie = `authToken=${token}; expires=${expires.toUTCString()}; path=/; Secure`;

            window.location.href = '/';
        })
        .catch(error => {
            resultDiv.textContent = `Erreur : ${error.message}`;
            console.error('Erreur lors de la connexion :', error);
        });
});
