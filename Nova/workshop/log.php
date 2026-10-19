<?php 
require_once "includes/parts/header.php";
require_once 'config/init.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch();
    print_r($user);
    if ($user) {

        if ($user &&($mot_de_passe == $user['mot_de_passe'])) {

            $_SESSION['user'] = $user;

            header('Location: admin/dashboard.php');
            exit();

        } else {
            $error = "Mot de passe incorrect";

        }

    } else {
        $error = "Email introuvable";
    }
    
}
?>   
    <body class="log">
        <section class="log">
            <div class="log">
                <h1 class="log">Connexion</h1>
                <?php echo $error;?>
                <a class="log" href="sign.php">Inscrivez-vous</a>
                <form action="log.php" class="log" method="POST">
                    <input class="log" type="email" name="email" placeholder="Email" required>
                    <input class="log" type="password" name="mot_de_passe" placeholder="Mot de passe" required>
                    <button class="log" type="submit">Se connecter</button>
                </form>     
            </div>
        </section>
    </body>
<?php
    require_once "includes/parts/footer.php"
?>