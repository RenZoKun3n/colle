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
<title>Vos préférences</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<link rel="stylesheet" href="css/master.css">
</head>

<body>

<?php

if(isset($_POST['mail']))$mail=$_POST['mail'];
else $mail="none";

if(isset($_POST['copy']))$copy=$_POST['copy'];
else $copy="none";

if (isset($_SESSION['id'])) {
	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
	$rowAdmin=mysqli_fetch_row($queryAdmin);

?>

<center>
<div id="header">Vos préférences</div>
</center>

<div id="intro">Vous pouvez consulter et modifier les préférences de votre compte</div>

<div id="container">
<?php

if(!isset($mail) || $mail=="none"){

	$querySauveteur=mysqli_query($link,"SELECT nom,prenom,mail,envoieCopy FROM sauveteur WHERE id=$idSession");
	$sauveteur=mysqli_fetch_row($querySauveteur);

	echo "<br><br><h2>$sauveteur[0] &nbsp $sauveteur[1]</h2><br><br>";
	echo "<FORM ACTION=\"preferences.php\" METHOD=\"POST\">";
	echo "Votre email : <input type=\"text\" name=\"mail\" size=50 maxlength=50 value=$sauveteur[2]>";
	if($sauveteur[3]==1){
		echo "<br>Copie de message privé par mail <input type=\"checkbox\" name=\"copy\" value=\"copy\" checked>";
	} else {
		echo "<br>Copie de message privé par mail <input type=\"checkbox\" name=\"copy\" value=\"copy\">";
	}

   echo "<INPUT TYPE=\"submit\" VALUE=\"Enregistrer les modifications\"></FORM>";

   echo "<br><br><a href=\"./preferences2.php\">Cliquez ici pour modifier votre avatar</a>";

} else {

	if($copy=="copy"){
		$envoieCopy=1;
	} else {
		$envoieCopy=0;
	}

	if(mysqli_query($link,"UPDATE sauveteur SET envoieCopy=$envoieCopy,mail=\"$mail\" WHERE id=$idSession")){
		echo "Vos préférences ont été mis à jour correctement.";
	} else {
		echo "Problème lors de la mise à jour de vos préférences.";
	}

	$mail="none";

}


?>

<br><br><br><br><br><br>
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
