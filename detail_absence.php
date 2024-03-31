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

// Récupération de l'id de l'absence depuis le paramètre de l'URL
$idAbsence = $_GET['id'];

// Requête pour récupérer les informations de l'absence et du stagiaire correspondant
$requete = "SELECT absence.jour_absence, absence.justification, stagiaires.nom, stagiaires.prenom
            FROM absence
            LEFT JOIN stagiaires ON absence.id_stagiaires = stagiaires.id_stagiaires
            WHERE absence.id_absence = $idAbsence";
$resultat = mysqli_query($connexion, $requete);

// Vérification des erreurs de requête
if (!$resultat) {
    die("Erreur de requête : " . mysqli_error($connexion));
}
include 'layout.php';
// Vérification si l'absence existe
if (mysqli_num_rows($resultat) > 0) {
    $row = mysqli_fetch_assoc($resultat);
    
    // Affichage des informations de l'absence
    echo "<h1>Détails de l'absence</h1>";
    echo "<p><strong>Date de l'absence :</strong> " . $row['jour_absence'] . "</p>";
    echo "<p><strong>Justification :</strong> " . $row['justification'] . "</p>";
    
    // Affichage des informations du stagiaire
    echo "<h2>Stagiaire</h2>";
    echo "<p><strong>Nom :</strong> " . $row['nom'] . "</p>";
    echo "<p><strong>Prénom :</strong> " . $row['prenom'] . "</p>";
} else {
    echo "Absence non trouvée.";
}

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>