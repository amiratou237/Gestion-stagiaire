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

// Requête pour récupérer les informations des stagiaires avec le nombre d'absences
// Requête pour récupérer les informations des stagiaires avec l'identifiant et le nombre d'absences
$requete = "SELECT stagiaires.cni, stagiaires.nom, stagiaires.prenom, stagiaires.tel, absence.id_absence, COUNT(absence.id_absence) AS nombre_absences
            FROM stagiaires
            LEFT JOIN absence ON stagiaires.id_stagiaires = absence.id_stagiaires
            GROUP BY stagiaires.cni, stagiaires.nom, stagiaires.prenom, stagiaires.tel, absence.id_absence";
$resultat = mysqli_query($connexion, $requete);

// Vérification des erreurs de requête
if (!$resultat) {
    die("Erreur de requête : " . mysqli_error($connexion));
}$resultat = mysqli_query($connexion, $requete);

// Vérification des erreurs de requête
if (!$resultat) {
    die("Erreur de requête : " . mysqli_error($connexion));
}
include 'layout.php';
?>


<div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800">Listes des Stagiaires</h1>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>CNI</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Téléphone</th>
                                    <th>Nombre d'absences</th>
                                    <th>Détails des absences</th>
                                </tr>
                            </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($resultat)) {
                echo "<tr>";
                echo "<td>" . $row['cni'] . "</td>";
                echo "<td>" . $row['nom'] . "</td>";
                echo "<td>" . $row['prenom'] . "</td>";
                echo "<td>" . $row['tel'] . "</td>";
                echo "<td>" . $row['nombre_absences'] . "</td>";
                
                if ($row['nombre_absences'] > 0) {
                    echo "<td><a class='btn btn-primary' href='detail_absence.php?id=" . $row['id_absence'] . "'>Détails</a></td>";
                } else {
                    echo "<td>Aucune absence</td>";
                }
                
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
