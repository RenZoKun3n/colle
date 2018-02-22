<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">


<title>Modification du mot de passe d'un sauveteur</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<link rel="stylesheet" href="css/master.css">

<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');
include("ongletNomDeconnexion.php");

if (isset($_SESSION['id'])) {
	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];
	//echo "test : $idSession";

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
	$rowAdmin=mysqli_fetch_row($queryAdmin);

	if($rowAdmin[0]==1 || $rowAdmin[0]==2){
		if(isset($_POST['idSauv']))$idSauv=$_POST['idSauv'];
		else $idSauv="none";
	  	
	  	if($idSauv && $idSauv!="none"){
	  		// Suppression
		    $querySauveteur=mysqli_query($link,"SELECT nom, prenom FROM sauveteur WHERE id=$idSauv") or die("La requete sauveteur a echouée");
		    if($rowSauveteur=mysqli_fetch_row($querySauveteur)){
			echo "<html>";
	     	echo "Attention ! Vous allez supprimer le sauveteur $rowSauveteur[0] $rowSauveteur[1]<br/><b>Etes vous sur de vouloir réaliser cette action ?</b><br/>\n";
			echo "<INPUT TYPE=\"button\" onClick='deleteSauveteur($idSauv)' VALUE=Supprimer le sauveteur><br>";
			echo "<b>Cliquer <a href=./listeSauveteur.php>Ici</a> pour annuler et retourner à la liste des sauveteurs.<b><br/></html>\n";


		    } else {
				echo "Erreur: Sauveteur non trouvé";
		    }
	  	}
	    

           

	} else {

	  echo "<html><body>Vous n'avez pas le droit d'accéder à cette page !!!</body></html>";

	}

} else {

  echo "<html><body><div id=\"intro\">Vous ne pouvez pas visualiser cette page actuellement. Veuillez vous <a href=\"./index.php\">identifier</a>.</div></body></html>";

}


?>

<script>
	function deleteSauveteur()
	{
	  <?php 
		mysqli_query($link,"DELETE FROM participe WHERE id_sauveteur=$idSauv;") or die("La requete de suppression participe a échouée");
	  	mysqli_query($link,"DELETE FROM sauveteur WHERE id=$idSauv;") or die("La requete de suppression a échouée");
	  	header('Location: ./listeSauveteur.php');
	  ?>
	}
</script>