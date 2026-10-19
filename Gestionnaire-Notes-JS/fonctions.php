<?php

    function lireNotes() {
        $fichier = 'notes.json';

        if (!file_exists($fichier)) {
            return [];
        }

        $contenu = file_get_contents($fichier);

        if (empty($contenu)) {
            return [];
        }

        $notes = json_decode($contenu, true);

        if ($notes === null) {
            return [];
        }

        return $notes;
    }

    function sauvegarderNotes($notes) {
        $fichier = 'notes.json';

        $json = json_encode($notes, JSON_PRETTY_PRINT);

        if ($json !== false) {
            file_put_contents($fichier, $json);
        }
    }

    function ajouterNote($nom, $matiere, $note) {
        $notes = lireNotes();

        if (empty($nom) || empty($matiere) || !is_numeric($note)) {
            return false;
        }

        $note = floatval($note);

        if ($note < 0 || $note > 20) {
            return false;
        }

        $newId = 1;

        if (!empty($notes)) {
            $ids = array_column($notes, 'id');
            $newId = max($ids) + 1;
        }

        $newNote = [
            'id' => $newId,
            'nom' => $nom,
            'matiere' => $matiere,
            'note' => $note
        ];

        $notes[] = $newNote;

        sauvegarderNotes($notes);

        return true;
    }

    function supprimerNote($id) {
        $notes = lireNotes();
        $newTab = [];
        $del = false;

        foreach ($notes as $note) {
            if ($note['id'] == $id) {
                $del = true;
                continue;
            }
            $newTab[] = $note;
        }

        sauvegarderNotes($newTab);

        return $del;
    }

    function calculerMoyenne($notes) {

    if (empty($notes)) {
        return 0;
    }

    $somme = 0;

    foreach ($notes as $note) {
        $somme += $note['note'];
    }

    $moyenne = $somme / count($notes);

    return round($moyenne, 2);
}
?>