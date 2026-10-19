document.addEventListener("DOMContentLoaded", function () { 

    const form = document.getElementById("formNote");
    const messageErreur = document.getElementById("messageErreur");

    form.addEventListener("submit", function (e) {

        messageErreur.textContent = "";

        const nom = form.nom.value.trim();
        const matiere = form.matiere.value.trim();
        const note = form.note.value.trim();

        if (nom === "" || matiere === "" || note === "") {
            messageErreur.textContent = "Tous les champs sont obligatoires.";
            e.preventDefault();
            return;
        }

        if (isNaN(note) || note < 0 || note > 20) {
            messageErreur.textContent = "La note doit être entre 0 et 20.";
            e.preventDefault();
            return;
        }

    });

});

const formsDelete = document.querySelectorAll(".formDelete");

formsDelete.forEach(function(formDelete) {
    formDelete.addEventListener("submit", function(e) {
        if (!confirm("Tu es sûr de vouloir supprimer cette note ?")) {
            e.preventDefault();
        }
    });
});

const notes = document.querySelectorAll(".note");

notes.forEach(function(cell) {
    const valeur = parseFloat(cell.textContent);

    if (valeur < 10) {
        cell.parentElement.style.backgroundColor = "#ffcccc";
    }
});