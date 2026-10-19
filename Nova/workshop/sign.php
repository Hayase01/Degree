<?php
    require_once "includes/parts/header.php";
    require_once 'config/init.php';
?>
    <body class="log">
        <section class="log">
            <div class="log">
                <h1 class="log">Inscription</h1>
                <a class="log" href="log.php">Se connecter</a>
                <form class="log" method="POST">
                    <input class="log" type="nom" name="email" placeholder="Nom" required>
                    <input class="log" type="prenom" name="email" placeholder="Prénom" required>
                    <input class="log" type="email" name="email" placeholder="Email" required>
                    <input class="log" type="password" name="password" placeholder="Mot de passe" required>
                    <input class="log" type="password" name="password" placeholder="Confirmer le mot de passe" required>
                    <button class="log" type="submit">S'inscrire</button>
                </form>     
            </div>
        </section>
    </body>
<?php
    require_once "includes/parts/footer.php"
?>
