<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté avec un rôle valide
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    // Vérifier le rôle de l'utilisateur
    if ($role == 'admin') {
        // L'utilisateur a le rôle d'administrateur

        // Votre code pour l'interface de l'administrateur

        // Exemple : Afficher un message de bienvenue
        echo "Bienvenue, administrateur !";
    } elseif ($role == 'secretaire') {
        // L'utilisateur a le rôle de secrétaire

        // Votre code pour l'interface du secrétaire

        
    } else {
        // Rôle invalide, rediriger vers la page de connexion
        header('Location: login.php');
        exit();
    }
} else {
    // Utilisateur non connecté, rediriger vers la page de connexion
    header('Location: login.php');
    exit();
}
?>
<?php
include 'layout.php';
?>

