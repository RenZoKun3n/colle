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
<title>Votre Avatar</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<link rel="stylesheet" href="css/master.css">
</head>

<body>


<?php

if (isset($_SESSION['id'])) {

	echo "<center><div id=\"header\">Votre Avatar</div></center>";

	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
	$rowAdmin=mysqli_fetch_row($queryAdmin);

	if(isset($_FILES['Fichier']))$Fichier=$_FILES['Fichier'];
	else $Fichier="none";

?>
<div id="intro">Vous pouvez modifier ici votre avatar</div>

<div id="container">
<?php


 if ($Fichier && $Fichier != "none") {
  
  $Fichier_name=$Fichier['name'];

  $adresseMiniature="http://crakdown.org/SNSM/avatars/";

  $prefixe=$idSession."_";
  $adresseMiniature=$adresseMiniature.$prefixe.$Fichier_name;

  creation_vignette($Fichier,150,150,"./","./avatars/","$prefixe");

  // On supprime le fichier
  unlink($Fichier['tmp_name']);

  mysqli_query($link,"UPDATE sauveteur SET lienAvatar=\"$adresseMiniature\" WHERE id=$idSession");

  echo "Voici votre nouvel Avatar :<br><br>";
  echo "<img src=\"$adresseMiniature\" /><br><br>";

  echo "<br><br><center><a href=\"./preferences.php\">Retour</a></center><br><br>";

 } else {

  $querySauveteur=mysqli_query($link,"SELECT lienAvatar FROM sauveteur WHERE id=$idSession");
  $sauveteur=mysqli_fetch_row($querySauveteur);

  echo "<div>\n";
  echo "Votre avatar actuel :<br><br>";
  echo "<img src=\"$sauveteur[0]\" /><br><br>";


  echo "Choisissez votre image (format Gif ou JPG). Le nom du fichier ne doit <b>pas contenir de caractère espace</b>.<br>Cliquez ensuite sur <b>Envoyer</b> pour modifier votre avatar :<br>";
  echo "<FORM ENCTYPE=\"multipart/form-data\" ACTION=\"preferences2.php\" METHOD=\"POST\">";
  echo "<br><INPUT TYPE=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"2000000\">";
  echo "<INPUT NAME=\"Fichier\" TYPE=\"file\">";
  echo "<INPUT TYPE=\"submit\" VALUE=\"Envoyer\"></FORM>";

  echo "<br><br><center><a href=\"./preferences.php\">Retour</a></center><br><br>";


  echo "</div>";
}

?>

<br><br><br>
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
