<?php
    require_once 'fonctions.php';

    if (isset($_POST['action'])) {

        $action = $_POST['action'];

        if ($action === 'ajouter') {

            $nom = $_POST['nom'] ?? '';
            $matiere = $_POST['matiere'] ?? '';
            $note = $_POST['note'] ?? '';

            ajouterNote($nom, $matiere, $note);

        }

        elseif ($action === 'supprimer') {

            $id = $_POST['id'] ?? null;

            if ($id !== null) {
                supprimerNote($id);
            }
        }
    }

    header('Location: index.php');
    exit;
?>