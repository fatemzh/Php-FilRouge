function confirmDelete(idTeacher) {
    if (confirm("Êtes-vous sûr de vouloir supprimer l'enseignant?")) {
        window.location.href = "./deleteTeacher.php?idTeacher=" + idTeacher;
    }
}
