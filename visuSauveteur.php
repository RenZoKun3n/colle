<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');
include("ongletNomDeconnexion.php");
?>

<script type="text/javascript">
<!--
function montre(id) {
var d = document.getElementById(id);
	for (var i = 1; i<=40; i++) {
		if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
	}
if (d) {d.style.display='block';}
}
//-->
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
 <title>Sauveteurs inscrits sur le site</title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <link rel="stylesheet" href="feuille1.css" type="text/css" />
 <link rel="stylesheet" href="css/master.css">
</head>

<body>


<?php

// On vérifit si l'utilisateur est authentifié
if (isset($_SESSION['id'])) {

	echo "<center><div id=\"header\">Liste des Sauveteurs</div></center>";

	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");

	$rowAdmin=mysqli_fetch_row($queryAdmin);

	echo "<div id=\"intro\"></div>";

?>
<div class="containerPhoto">
<?php

if (!isset($numPage) || $numPage == "none"){
	// Pas de numéro de debut de photo
	$numPage=1;
	$ecartImage=6;
}

$result3=mysqli_query($link,"SELECT id,nom,prenom,nbVisites,lienAvatar FROM sauveteur ORDER BY `nom` ASC") or die("Query sauveteur failed");

$compteur=0;
echo "<center><table border=0 width=100%>";
while ($myrow3=mysqli_fetch_row($result3)) {
	$compteur++;
	if($compteur>= (($numPage-1)*$ecartImage)+1 && $compteur<=$numPage*$ecartImage) {
		if($compteur%3==1)
			echo "<tr>";
		echo "<td><center> <a href=\"./repondre.php?desti=$myrow3[0]\"><img src=\"$myrow3[4]\" width='50px' height='50px'></a><br><b>$myrow3[1]</b> $myrow3[2]<br>$myrow3[3] Visites";

		echo "</center></td>\n";

		if($compteur%3==0)
			echo "</tr>";
	}
}
echo "</table>";


for($nblien=0;$nblien<($compteur/$ecartImage);$nblien++) {
   $numP=$nblien+1;
   //$dPage=$nblien*$ecartImage+1;
   //$fPage=$nblien*$ecartImage+$ecartImage;
	if($numP==1 && $numPage>1){
		$precedent=$numPage-1;
		echo "<a href=\"./visuSauveteur.php?numPage=$precedent&ecartImage=$ecartImage\">Précedente</a>&nbsp";
	}


	if($numPage==$numP){
		echo "&nbsp<b>$numP</b>";
	} else {
		echo "&nbsp<a href=\"./visuSauveteur.php?numPage=$numP&ecartImage=$ecartImage\">$numP</a>";
	}
}

if($numP>$numPage){
	$suivant=$numPage+1;
	echo "&nbsp &nbsp<a href=\"./visuSauveteur.php?numPage=$suivant&ecartImage=$ecartImage\">Suivante</a>";
}



echo "</center>";

echo "<div class=\"participe\">";
echo "Nombre de sauveteurs par page : <a href=\"./visuSauveteur.php?numPage=1&ecartImage=6\">6</a> ";
echo "<a href=\"./visuSauveteur.php?numPage=1&ecartImage=9\">9</a> ";
echo "<a href=\"./visuSauveteur.php?numPage=1&ecartImage=12\">12</a> ";
echo "</div><br><div class=\"commentairePhoto\">Cliquez sur l'avatar pour envoyer un message au sauveteur.<br /><a href=\"./preferences2.php\">Cliquez ici pour modifier votre avatar</a></div></div>";


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
