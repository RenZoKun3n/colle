<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');
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
<title>Informations concernant le site</title>
<link rel="stylesheet" href="feuille1.css" type="text/css" />
 <script type="text/javascript" src="fixed.js"></script>
</head>

<body>
<center>
<div id="header">Informations concernant le site</div>
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
<div id="intro"></div>

<div class="containerPhoto">
<div id="informationsSite">
<p><span class="premierChar">C</span>e site utilise le langage <a href="http://fr.wikipedia.org/wiki/XHTML">XHTML</a> et les feuilles de style en cascade (ou <a href="http://fr.wikipedia.org/wiki/Css">css</a>) pour construire la mise en page. 
C'est pourquoi, les utilisateurs d'Internet Explorer pourraient avoir quelques problèmes d'affichage car ce navigateur ne respecte pas les standards et gère plus ou moins bien les feuilles de style.</p>

<p><b><span class="premierChar">V</span>oici une page du site affichée sur <a href="ie.jpg">Internet Explorer</a> et la même page affichée sous <a href="firefox.jpg">FireFox</a>.</b>
<br><i>Internet Explorer ne gère pas les coins arrondis et les titres du menu ne sont pas tous centrés.</i></p>

<p><span class="premierChar">D</span>e plus, MS Internet Explorer souffre de nombreuses failles de sécurité non corrigées, qui peuvent conduire au piratage de votre ordinateur, à la dégradation de vos logiciels jusqu'à les rendre inutilisables  
(Windows compris), à l'installation de logiciels espions (ou de pub) et au vol de vos données personnelles (email, mot de passe, code de carte bleu .. Bref, toutes informations 
que vous avez fournies sur le Web.</p>

<p><span class="premierChar">J</span>e ne cherche pas à vous faire changer de navigateur internet. Si Internet Explorer (ou un autre) vous convient, c'est très bien.
Si vous voulez jeter un petit coup d'oeil à FireFox (navigateur <b>en Français</b> libre et gratuit respectant les standards et permettant notamment la navigation en
utilisant les onglets, le blocage des popups, etc..) cliquez sur le bouton "Get Firefox".</p>
<a href="http://www.mozilla-europe.org/fr/products/firefox/"><img border="0" alt="Get Firefox!" title="Get Firefox!" src="http://sfx-images.mozilla.org/affiliates/Buttons/180x60/trust.gif"/></a>


<p><h3>Informations plus techniques.</h3>
<span class="premierChar">C</span>e site est généré via des pages <a href="http://fr.wikipedia.org/wiki/Php">PHP</a>. Les informations concernant les postes de secours, mais aussi les photographies et la messagerie sont stockées
dans une base de données <a href="http://fr.wikipedia.org/wiki/Mysql">Mysql.</a></a>

<br><br>
</div> <!-- <div id="informationsSite">   -->
</div> <!-- <div class="containerPhoto"> -->


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
