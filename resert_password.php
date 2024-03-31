<?php

ini_set('SMTP', 'smtp.gmail.com');
ini_set('smtp_port', 587);

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
// Vérification des champs du formulaire
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Vérifier si l'email existe dans la base de données
    $requete = "SELECT mot_de_passe FROM compte WHERE email = '$email'";
    $resultat = mysqli_query($connexion, $requete);

    if ($resultat && mysqli_num_rows($resultat) > 0) {
        // Générer un nouveau mot de passe aléatoire
        $nouveauMotDePasse = generateRandomPassword();

        // Mettre à jour le mot de passe dans la base de données
        $requete = "UPDATE compte SET mot_de_passe = '$nouveauMotDePasse' WHERE email = '$email'";
        mysqli_query($connexion, $requete);

        // Envoyer le nouveau mot de passe à l'utilisateur (par email ou autre méthode)
        $destinataire = $email; // Adresse e-mail de l'utilisateur
        $sujet = "Réinitialisation du mot de passe";
        $message = "Votre nouveau mot de passe est : $nouveauMotDePasse"; // Corps du message avec le nouveau mot de passe

        // Envoyer l'e-mail
        if (mail($destinataire, $sujet, $message)) {
            echo "Un e-mail contenant le nouveau mot de passe a été envoyé à votre adresse e-mail.";
        } else {
            echo "Une erreur s'est produite lors de l'envoi de l'e-mail. Veuillez réessayer ultérieurement.";
        }
        // Afficher un message de succès à l'utilisateur
        echo "Votre mot de passe a été réinitialisé avec succès. Veuillez vérifier votre email pour obtenir le nouveau mot de passe.";
    } else {
        // L'email n'existe pas dans la base de données
        echo "L'email fourni n'est associé à aucun compte.";
    }
}


function generateRandomPassword($length = 8) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $password = '';

    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, strlen($characters) - 1);
        $password .= $characters[$index];
    }

    return $password;
}
?>