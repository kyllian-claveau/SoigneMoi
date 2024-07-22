<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<h1>🌟 SoigneMoi</h1>

<h2>📝 Description</h2>
<p>
    SoigneMoi est un projet réalisé durant mon année de Bachelor au sein de l'école Studi. C'est une application web qui permet de créer des séjours à l'hôpital pour les utilisateurs.
</p>

<h2>🚀 Prérequis</h2>
<p>Assurez-vous d'avoir les éléments suivants installés :</p>
<ul>
    <li>🐳 Docker</li>
    <li>🧰 Composer</li>
    <li>🐘 PHP</li>
    <li>📦 Node.js et npm</li>
    <li>🌐 Symfony CLI</li>
</ul>

<h2>⚙️ Instructions de configuration</h2>
<p>Suivez ces étapes pour configurer et exécuter le projet.</p>

<h3>🖥️ Installation des dépendances</h3>

<h4>Pour Linux</h4>
<ol>
    <li>Installer Symfony CLI :
        <pre><code>curl -sS https://get.symfony.com/cli/installer | bash
export PATH="$HOME/.symfony/bin:$PATH"
        </code></pre>
    </li>
    <li>Installer Node.js et npm : Suivez les instructions sur le site officiel de Node.js pour installer la version appropriée pour votre système.</li>
</ol>

<h4>Pour Windows</h4>
<ol>
    <li>Installer Symfony CLI : Téléchargez et exécutez l'installateur depuis <a href="https://symfony.com/download">Symfony CLI</a>.</li>
    <li>Installer Node.js et npm : Téléchargez et installez depuis le <a href="https://nodejs.org">site officiel de Node.js</a>.</li>
</ol>

<h3>🖥️ Symfony</h3>
<ol>
    <li>Démarrer le conteneur de la base de données Docker :
        <pre><code>docker-compose up -d database</code></pre>
    </li>
    <li>Installer les dépendances Composer :
        <pre><code>composer install</code></pre>
    </li>
    <li>Installer les dépendances npm :
        <pre><code>npm install</code></pre>
    </li>
    <li>Créer et exécuter les migrations de la base de données :
        <pre><code>php bin/console make:migration
php bin/console doctrine:migrations:migrate
        </code></pre>
    </li>
    <li>Démarrer le serveur Symfony : Ouvrez une nouvelle fenêtre/onglet de terminal et exécutez :
        <pre><code>symfony serve</code></pre>
    </li>
</ol>

<h2>🛠️ Dépannage</h2>
<p>Assurez-vous que les ports utilisés par Docker et le serveur Symfony ne sont pas bloqués par des pare-feux ou d'autres services.</p>

<hr>

<p>Avec ces instructions, vous devriez être en mesure de configurer et d'exécuter correctement l'application SoigneMoi. Bonne chance !</p>

</body>
</html>
