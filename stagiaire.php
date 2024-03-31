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

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté avec un rôle valide
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    // Vérifier le rôle de l'utilisateur
    if ($role == 'admin') {
        

    } elseif ($role == 'secretaire') {
        // L'utilisateur a le rôle de secrétaire

        // Votre code pour l'interface du secrétaire

        // Exemple : Récupérer les informations des stagiaires depuis la base de données
        $requete = "SELECT * FROM stagiaires";
        // Exécutez la requête et traitez les résultats
        $resultat = mysqli_query($connexion, $requete);

        // Vérification des erreurs de requête
        if (!$resultat) {
            die("Erreur de requête : " . mysqli_error($connexion));
        }

        // Exemple : Afficher les informations des stagiaires dans le tableau HTML
        include 'layout.php';
        echo '<div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Listes des Stagiaires</h1>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>CNI</th>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Date de Naissance</th>
                                    <th>N° Télephone</th>
                                    <th>Fillière</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>';

        // Exemple : Parcourir les résultats et afficher chaque ligne dans le tableau
        while ($row = mysqli_fetch_assoc($resultat)) {
            echo '<tr>
                <td>' . $row['cni'] . '</td>
                <td>' . $row['nom'] . '</td>
                <td>' . $row['prenom'] . '</td>
                <td>' . $row['date_de_naissance'] . '</td>
                <td>' . $row['tel'] . '</td>
                <td>' . $row['filliere'] . '</td>
                
                <td> 
                <a href="delete.php?id=' . $row['id_stagiaires'] . '" class="btn btn-danger btn-icon-split">Supprimer</a>
                <a href="modify.php?id=' . $row['id_stagiaires'] . '" class="btn btn-secondary btn-icon-split">Modifier</a>
                <a href="absence.php?id=' . $row['id_stagiaires'] . '" class="btn btn-primary btn-icon-split">Notez absence</a>
            </td>
            </tr>';
        }

        echo '</tbody>
                </table>
            </div>
        </div>
    </div>
</div>';
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