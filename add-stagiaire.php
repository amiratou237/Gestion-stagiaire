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

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $cni = $_POST["cni"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $dateNaissance = $_POST["date_de_naissance"];
    $telephone = $_POST["tel"];
    $filliere = $_POST["filliere"];


    // Préparer la requête d'insertion
    $requete = "INSERT INTO stagiaires (cni, nom, prenom, date_de_naissance, tel, filliere) VALUES ('$cni', '$nom', '$prenom', '$dateNaissance', '$telephone', '$filliere')";

    // Exécuter la requête d'insertion
    if (mysqli_query($connexion, $requete)) {
        echo "Le stagiaire a été ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du stagiaire : " . mysqli_error($connexion);
    }
}

// Fermer la connexion à la base de données
mysqli_close($connexion);


include 'layout.php';
?>


<div class="container">
    <div class="heading">Ajoutez un stagiaires</div>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form">

      <input  class="input" type="text" name="cni" required placeholder="Numéro CNI">

      <input  class="input" type="text" name="nom" required  placeholder="Nom">

      <input  class="input" type="text" name="prenom" required  placeholder="Prénom">

      <input class="input" type="date" name="date_de_naissance" required placeholder="Date de naissance">

      <input class="input" type="text" name="tel" required placeholder="Numéro de téléphone">

      <input class="input" type="text" name="filliere" required placeholder="Fllière">


      <input  class="btn btn-danger btn-icon-split" type="reset" value="Annuler">

      <input class="login-button" type="submit" value="Ajouter">
      
    </form>

</div>