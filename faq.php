<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');
include('ongletNomDeconnexion.php');
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
<title>Foire aux questions</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/master.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
</head>

<body>

<?php

if (isset($_SESSION['id'])) {
	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
	$rowAdmin=mysqli_fetch_row($queryAdmin);

?>
<center>
<div id="header">Foire aux questions</div>
</center>
<div id="intro"></div>

<div class="containerPhoto">
<div id="informationsSite">

<p><b><span class="premierChar">Q</span>ue faire si je perds mon mot de passe?</b><br>
Je ne pourrai pas retrouver votre ancien mot de passe, puisque celui-ci est chiffré, par contre, vous pouvez me contacter afin que j'associe un nouveau mot de passe à votre e-mail.
</p>

<p><b><span class="premierChar">M</span>es données personnelles sont-elles visibles depuis d'autres sites Internet?</b><br>
Non. L'accès au site étant restreint par la demande d'une adresse e-mail faisant partie de la liste de diffusion et d'un mot de passe, les données personnelles sont protégées.
</p>

<p><b><span class="premierChar">L</span>es photographies sont-elles visibles depuis d'autres sites Internet ?</b><br>
Oui et Non. Des fichiers HTML vides sont présents dans les dossiers contenant nos photos. Ainsi les photos ne sont pas disponibles pour des personnes externes au site (qui ne
connaissent pas l'adresse exacte des photos).
</p>

<p><b><span class="premierChar">P</span>ourquoi je ne peux pas annuler ma participation à un poste de secours?</b><br>
Tout simplement afin d'éviter un manque de sauveteurs la veille, voir quelques heures avant le début d'un poste de secours. Vous pouvez toujours contacter Christian ou m'envoyer
un mail si vous avez un empêchement impromptu.
</p><br>

<br>
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
