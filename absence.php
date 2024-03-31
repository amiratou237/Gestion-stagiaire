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

// Vérifier si l'ID du stagiaire est fourni dans l'URL
if (isset($_GET['id'])) {
    $idStagiaire = $_GET['id'];

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les valeurs du formulaire
        $jourAbsence = $_POST['jour_absence'];
        $justification = $_POST['justification'];

        // Requête d'insertion d'une absence
        $requete = "INSERT INTO absence (jour_absence, justification, id_stagiaires) VALUES ('$jourAbsence', '$justification', $idStagiaire)";

        // Exécuter la requête d'insertion
        $resultat = mysqli_query($connexion, $requete);

        // Vérification des erreurs de requête
        if (!$resultat) {
            die("Erreur de requête : " . mysqli_error($connexion));
        }

        // Redirection vers la page de détails du stagiaire après l'ajout de l'absence
        header('Location: stagiaire.php?id=' . $idStagiaire);
        exit();
    }

    // Affichage du formulaire pour remplir une absence
    include 'layout.php';
?>

        <div class="container">
		<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12 edit_information">
			<form action=""  method="POST">	
				<h3 class="text-center">Ajoutez une Absence</h3>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label class="jour_absence">Date d'absence :</label>
							<input type="date" name="jour_absence" class="form-control" value="" required >
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label class="justification">Justification : </label>
							<input type="text" name="justification" class="form-control" value="">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 submit">
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Marquer">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

<?php
} else {
    // ID de stagiaire non fourni, rediriger vers la page appropriée
    header('Location: stagiaire.php');
    exit();
}
?>