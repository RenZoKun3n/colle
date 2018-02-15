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
	  $idPoste=$_POST[idPoste];
	  $action=$_POST[action];

	  if($action==1){
		// Modification

		  $queryPoste=mysqli_query($link,"SELECT libelle,datedeb,datefin,heuredeb,heurefin,lieu,participantsMini,commentaire FROM poste WHERE id=$idPoste") or die("La requete poste a echouée");
		  if($rowPoste=mysqli_fetch_row($queryPoste)){

			  // Convertion des dates
			 $datedeb=datefren($rowPoste[1]);
			 $datefin=datefren($rowPoste[2]);


			echo "<html>";
			echo "<b>Modifications des informations concernant un poste</b>";
			echo "<FORM ENCTYPE=\"multipart/form-data\" ACTION=\"ajouterPoste.php\" METHOD=\"POST\">\n";
			echo "<INPUT TYPE=\"hidden\" name=\"modif\" value=\"1\">\n";
			echo "<INPUT TYPE=\"hidden\" name=\"idPoste\" value=$idPoste>\n";
			echo "<br/> Nom du poste : <input type=\"text\" name=\"libelle\" value=\"$rowPoste[0]\" size=60 maxlength=60>\n";
			echo "<br/> Date début : <input type=\"text\" name=\"datedebfr\" value=\"$datedeb\" size=10 maxlength=10>  (exemple : 28/02/2007)\n";
			echo "<br/> Date fin (si différente de date début) : <input type=\"text\" name=\"datefinfr\" value=\"$datefin\" size=10 maxlength=10> (exemple : 28/02/2007)\n";
			echo "<br/> Heure début : <input type=\"text\" name=\"heuredeb\" value=\"$rowPoste[3]\" size=10 maxlength=10> (exemple: 08:30:00)\n";
			echo "<br/> Heure fin : <input type=\"text\" name=\"heurefin\" value=\"$rowPoste[4]\" size=10 maxlength=10> (exemple: 17:00:00)\n";
			echo "<br/> Lieu : <input type=\"text\" name=\"lieu\" value=\"$rowPoste[5]\" size=70 maxlength=70>\n";
			echo "<br/> Sauveteurs requis (au minimum) : <input type=\"text\" name=\"participantsMini\" value=\"$rowPoste[6]\" size=3 maxlength=3> (saisissez un nombre uniquement)\n";
			echo "<br/> Commentaire : <textarea name=\"commentaire\" value=\"$rowPoste[7]\" cols=30 rows=4></textarea> (Autres informations utiles pour le poste)\n";
			echo "<INPUT TYPE=\"submit\" VALUE=Enregistrer les modifications></FORM></html>\n";
	  	} else {
			echo "Erreur: Poste non trouvé";
	 	}

	   } else {
	     // Suppression
	     $queryPoste2=mysqli_query($link,"SELECT libelle,datedeb,lieu FROM poste WHERE id=$idPoste") or die("La requete poste a echouée");
	     if($rowPoste2=mysqli_fetch_row($queryPoste2)){
		echo "<html>";
	     	echo "Attention, vous allez supprimer le poste $rowPoste2[0] qui se déroule à $rowPoste2[2] le $rowPoste2[1]<br/><b>Etes vous sur de vouloir réaliser cette action ?</b><br/>\n";
		echo "<FORM ENCTYPE=\"multipart/form-data\" ACTION=\"ajouterPoste.php\" METHOD=\"POST\">\n";
		echo "<INPUT TYPE=\"hidden\" name=\"modif\" value=\"2\">\n";
		echo "<INPUT TYPE=\"hidden\" name=\"idPoste\" value=$idPoste>\n";
		echo "<INPUT TYPE=\"submit\" VALUE=Supprimer le poste></FORM>\n";
		echo "<b>Cliquer <a href=./visuPoste.php?prochains=1>Ici</a> pour annuler et retourner à la liste des postes.<b><br/></html>\n";


	     } else {
		echo "Erreur: Poste non trouvé";
	     }

           }

	} else {

	  echo "<html><body>Vous n'avez pas le droit d'accéder à cette page !!!</body></html>";

	}

} else {

  echo "<html><body><div id=\"intro\">Vous ne pouvez pas visualiser cette page actuellement. Veuillez vous <a href=\"./index.php\">identifier</a>.</div></body></html>";

}
