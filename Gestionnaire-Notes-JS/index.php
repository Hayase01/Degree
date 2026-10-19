<?php
require_once 'fonctions.php';

$notes = lireNotes();
$moyenne = calculerMoyenne($notes);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/reset.css">
        <link rel="stylesheet" href="assets/style.css">
        <script src="assets/script.js" defer></script>
        <title>Gestionnaire de notes</title>
    </head>
    <body>
        <section>
            <div>
                <h1>Gestionnaire de notes pour étudiants</h1>
                <h2>Ajouter une note</h2>
                <form action="traitement.php" method="POST" id="formNote">
                    <input type="hidden" name="action" value="ajouter">

                    <label>Nom de l'étudiant :</label>
                    <input type="text" name="nom">

                    <label>Matière :</label>
                    <input type="text" name="matiere">

                    <label>Note (0-20) :</label>
                    <input type="number" name="note">

                    <button type="submit">Ajouter</button>

                    <div id="messageErreur" style="color:red;"></div>
                </form>
            </div>
        </section>

        <section>
            <div>
                <h2>Liste des notes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Matière</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notes as $note): ?>
                            <tr>
                                <td><?= $note['id'] ?></td>
                                <td><?= $note['nom'] ?></td>
                                <td><?= $note['matiere'] ?></td>
                                <td class="note"><?= $note['note'] ?></td>
                                <td>
                                    <form action="traitement.php" method="POST" class="formDelete">
                                        <input type="hidden" name="action" value="supprimer">
                                        <input type="hidden" name="id" value="<?= $note['id'] ?>">
                                        <button type="submit">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <div>
                <h2>Moyenne générale : <?= $moyenne ?></h2>
            </div>
        </section>
    </body>
</html>
