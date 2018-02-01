<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');
include("ongletNomDeconnexion.php");

$joursem = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<script type="text/javascript">
function montre(id) {
var d = document.getElementById(id);
	for (var i = 1; i<=40; i++) {
		if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
	}
if (d) {d.style.display='block';}
}
</script>
<title>Stages Nationaux SNSM 2007/2008</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<link rel="stylesheet" href="css/master.css">
</head>

<body>
<center>
<div id="header">Stages Nationaux SNSM</div>
</center>

<?php

if (isset($_SESSION['id'])) {
	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
	$rowAdmin=mysqli_fetch_row($queryAdmin);

?>
<div id="intro">Vous pouvez télécharger ici,&nbsp les documents décrivant les stages Nationaux SNSM 2007/2008.</div>

<div id="container">
<br><br>
<center><b><a href="./stages/STAGES_NATIONAUX_2008.xls">Cliquez ici pour télécharger le fichier au Format EXCEL</a></b><br><br>
<b><a href="./stages/STAGES_NATIONAUX_2008.pdf">Cliquez ici pour télécharger le fichier au Format PDF</a></b><br>
</center>
<br><br><br><br><br><br><br><br><br><br><br>
</div> <!-- <div id="container"> -->


<?php
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
