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

// Vérification des champs du formulaire
if (isset($_POST['email']) && isset($_POST['mot_de_passe'])) {
    // Récupération des données du formulaire
    $email = $_POST['email'];
    $motDePasse = $_POST['mot_de_passe'];

    // Requête SQL pour vérifier les identifiants de connexion
    $requete = "SELECT role FROM compte WHERE email = '$email' AND mot_de_passe = '$motDePasse'";
    $resultat = mysqli_query($connexion, $requete);

    if ($resultat && mysqli_num_rows($resultat) > 0) {
        // Récupération du rôle de l'utilisateur
        $row = mysqli_fetch_assoc($resultat);
        $role = $row['role'];

        // Démarrage de la session
        session_start();

        // Stockage du rôle de l'utilisateur dans une variable de session
        $_SESSION['role'] = $role;

        // Redirection en fonction du rôle de l'utilisateur
        if ($role == 'admin') {
            // Redirection vers l'interface de l'administrateur
            header('Location: admin_interface.php');
            exit();
        } elseif ($role == 'secretaire') {
            // Redirection vers l'interface du secrétaire
            header('Location: secretary_interface.php');
            exit();
        }
    } else {
        // Identifiants invalides, affichage d'un message d'erreur
        echo 'Identifiants de connexion invalides.';
    }

    // Libération des ressources et fermeture de la connexion à la base de données
    mysqli_free_result($resultat);
    mysqli_close($connexion);
}
?>