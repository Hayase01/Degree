<?php require_once '../includes/init.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch();

    if ($user) {

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user'] = $user;

            header('Location: dashboard.php');
            exit();

        } else {
            $error = "Mot de passe incorrect";
        }

    } else {
        $error = "Email introuvable";
    }
    
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log in</title>
        <link rel="stylesheet" href="../assets/css/reset.css">
        <link rel="stylesheet" href="../assets/css/log.css">
    </head>
    <body>
        <section>
            <div>
                <h1>Connexion</h1>
            </div>
            <div>
                <form method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <button type="submit">Se connecter</button>
                    <a href="../front_office/index.php">Retour à l'accueil</a>
                </form>     
            </div>
        </section>
    </body>
</html>