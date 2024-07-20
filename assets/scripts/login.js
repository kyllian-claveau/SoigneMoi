document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const resultDiv = document.getElementById('result');

    fetch('https://soignemoiproject.online/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username, password }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la connexion');
            }
            return response.json();
        })
        .then(data => {
            const token = data.token; // Supposons que votre API renvoie un objet avec une clé 'token'

            // Afficher le token dans la page
            resultDiv.innerHTML = `<p>Authentification réussi !</p>`;

            // Stocker le token dans un cookie avec une expiration (exemple : 7 jours)
            const expires = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000); // 7 jours en milliseconds
            document.cookie = `authToken=${token}; expires=${expires.toUTCString()}; path=/`;

            // Optionnel : rediriger après la connexion
            setTimeout(() => {
                window.location.href = '/'; // Redirige vers la page d'accueil après 2 secondes
            }, 2000);
        })
        .catch(error => {
            resultDiv.textContent = error.message;
            console.error('Erreur lors de la connexion :', error);
        });
});