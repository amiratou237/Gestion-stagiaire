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

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les nouvelles valeurs des champs du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $dateNaissance = $_POST['date_de_naissance'];
        $telephone = $_POST['tel'];
        $filiere = $_POST['filliere'];

        // Requête de modification du stagiaire
        $requete = "UPDATE stagiaires SET nom = '$nom', prenom = '$prenom', date_de_naissance = '$dateNaissance', tel = '$telephone', filliere = '$filiere' WHERE id_stagiaires = $idStagiaire";

        // Exécuter la requête de modification
        $resultat = mysqli_query($connexion, $requete);

        // Vérification des erreurs de requête
        if (!$resultat) {
            die("Erreur de requête : " . mysqli_error($connexion));
        }

        // Redirection vers la page de détails du stagiaire après la modification
        header('Location: stagiaire.php');
        exit();
    }

    // Récupérer les informations actuelles du stagiaire
    $requete = "SELECT * FROM stagiaires WHERE id_stagiaires = $idStagiaire";
    $resultat = mysqli_query($connexion, $requete);

    // Vérification des erreurs de requête
    if (!$resultat) {
        die("Erreur de requête : " . mysqli_error($connexion));
    }

    // Vérifier si le stagiaire existe
    if (mysqli_num_rows($resultat) == 1) {
        $stagiaire = mysqli_fetch_assoc($resultat);
        include 'layout.php';

?>

<div class="container">
    <div class="heading"><h1>Modifier un stagiaire</h1></div>
    <form method="POST" action="" class="form">

                <input class="input" type="text" name="nom" value="<?php echo $stagiaire['nom']; ?>"><br>


                <input class="input" type="text" name="prenom" value="<?php echo $stagiaire['prenom']; ?>"><br>


                <input class="input" type="date" name="date_de_naissance" value="<?php echo $stagiaire['date_de_naissance']; ?>"><br>


                <input class="input" type="text" name="tel" value="<?php echo $stagiaire['tel']; ?>"><br>


                <input class="input" type="text" name="filliere" value="<?php echo $stagiaire['filliere']; ?>"><br>

                <input class="login-button" type="submit" value="Modifier">
            </form>

</div>

            

            
<?php
    } else {
        // Stagiaire non trouvé, rediriger vers la page appropriée
        header('Location: erreur.php');
        exit();
    }
} else {
    // ID de stagiaire non fourni, rediriger vers la page appropriée
    header('Location: stagiaire.php');
    exit();
}
?>