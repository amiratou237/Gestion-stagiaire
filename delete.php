<?php
// Connexion à la base de données (vous devez remplacer les valeurs par vos propres informations de connexion)
$serveur = "localhost";
$utilisateur = "root";
$motDePasseBDD = "";
$nomBDD = "gestion_stagiaire";

$connexion = mysqli_connect($serveur, $utilisateur, $motDePasseBDD, $nomBDD);

// Vérification de la connexion à la base de données
if (!$connexion) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Vérifier si un ID de stagiaire est fourni dans l'URL
if (isset($_GET['id'])) {
    $idStagiaire = $_GET['id'];

    // Requête de suppression du stagiaire
    $requete = "DELETE FROM stagiaires WHERE id_stagiaires = $idStagiaire";

    // Exécuter la requête de suppression
    $resultat = mysqli_query($connexion, $requete);

    // Vérification des erreurs de requête
    if (!$resultat) {
        die("Erreur de requête : " . mysqli_error($connexion));
    }

    // Redirection vers la liste des stagiaires après la suppression
    header('Location: stagiaire.php');
    exit();
} else {
    // ID de stagiaire non fourni, rediriger vers la page appropriée
    header('Location: erreur.php');
    exit();
}
?>