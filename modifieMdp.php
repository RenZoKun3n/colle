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

	$link=connectDB();

	if(empty($_GET['idSauveteur']))
	{
		$idSauveteur=$_POST['idSauveteur'];
		$nouveauMdp=$_POST['nouveauMdp'];
	} else {
		$idSauveteur=$_GET['idSauveteur'];
	}

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");

	$rowAdmin=mysqli_fetch_row($queryAdmin);

	// On test si l'utilisateur est admin ou non
	if (($rowAdmin[0]==2 || $rowAdmin[0]==1) && $idSauveteur && $idSauveteur!= "none") {

		if (!$nouveauMdp || $nouveauMdp == "none") {
			$nomSauveteur=$_GET['nomSauveteur'];
			$prenomSauveteur=$_GET['prenomSauveteur'];
?>

<script type="text/javascript">
<!--
function envoyer(){
	if ( (document.modification.nouveauMdp.value=="") || (document.modification.nouveauMdp2.value=="") ){
		alert("Veuillez remplir tous les champs,  merci");
	} else {
		if(document.modification.nouveauMdp.value != document.modification.nouveauMdp2.value) {
			alert("Les mots de passe ne sont pas les mêmes.");
		} else {
			document.modification.submit();
		}
	}
}


function montre(id) {
var d = document.getElementById(id);
	for (var i = 1; i<=40; i++) {
		if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
	}
if (d) {d.style.display='block';}
}

window.onload=montre;
-->
</script></head>
<body>
<center>
<div id="header">
Modification du mot de passe
</div>
</center>
<div id="container">
<?php
	echo "<br><b>Veuillez renseigner le nouveau mot de passe de $nomSauveteur $prenomSauveteur</b>";
	echo "<form name=\"modification\" ACTION=\"modifieMdp.php\" METHOD=\"POST\">\n";
  	echo "<br> Mot de passe : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type=\"text\" name=\"nouveauMdp\" size=20 maxlength=20>\n";
  	echo "<br> Mot de passe (une seconde fois) : &nbsp&nbsp<input type=\"text\" name=\"nouveauMdp2\" size=20 maxlength=20>\n";
	echo "<INPUT TYPE=\"hidden\" name=\"idSauveteur\" value=\"$idSauveteur\">\n";
	echo "<INPUT TYPE=\"button\" VALUE=\"Enregistrer\" onClick=\"envoyer();\"></form>\n";
?>
</div>

</body>
<?php
	} else {
		// ajout du sauveteur

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">


<title>Modification de mot de passe d'un sauveteur</title>
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<?php

		$nouveauMdp=md5($_POST['nouveauMdp']);
		$idSauveteur=$_POST['idSauveteur'];

		$link=connectDB();
?>

		<center>
		<div id="header">
		     Modification du mot de passe
		</div>
		</center>
		<div id="container">
		     <b>Modification du mot de passe effectuée.</b><br/>
<?php
		$result3=mysqli_query($link,"UPDATE sauveteur SET password = \"$nouveauMdp\" where id = $idSauveteur") or die("La modification du mot de passe du sauveteur a echouée");


		echo "<a href=\"listeSauveteur.php\">Retour sur la page de la liste des sauveteurs</a></div>";

	}
	} else {
?>
	<body>
		<center><div id="header">Opération non autorisée</div></center>
	</body>
<?php
}

menu($link,$rowAdmin[0],$idSession);

footer();


?>
</body>
</html>

<?php
} else {
?>

 <div id="intro">Vous ne pouvez pas visualiser cette page actuellement. Veuillez vous <a href="./index.php">identifier</a>.</div>
</body>
</html>
<?php
}
?>
