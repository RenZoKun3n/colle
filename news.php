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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="feuille1.css" type="text/css" />
	<link rel="stylesheet" href="css/master.css"/>
<script type="text/javascript">
function montre(id) {
var d = document.getElementById(id);
	for (var i = 1; i<=40; i++) {
		if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
	}
if (d) {d.style.display='block';}
}

function envoyer()
{
	document.validNouveauSauveteurs.submit();
}

function deselectionneSuppr(num)
{
	var d= "supprid"+num;
	document.getElementById(d).checked = false;
}

function deselectionneOk(num)
{
	var d= "id"+num;
	document.getElementById(d).checked = false;
}

</script>

<title>Informations de dernière minute</title>
 <META HTTP-EQUIV="refresh" CONTENT="50; URL=visuPoste.php?prochains=1">
</head>

<body>

<?php

if (isset($_SESSION['id'])) {
	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin,dateAvantderVisite FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
	$rowAdmin=mysqli_fetch_row($queryAdmin);

	mysqli_query($link,"UPDATE sauveteur SET dateAvantderVisite=DATE_ADD(now(), INTERVAL +2 HOUR) WHERE id=$idSession") or die("Update Sauveteur News failed");

?>

<center>
<div id="header"><p>Dernière Minute</p></div>
</center>

<div id="intro">Vous retrouverez ici,&nbsp les informations de dernière minute concernant le centre de formation de Montbéliard.</div>

<div id="container">

<?php
if($rowAdmin[0]==1)
{
	$nouveauSauveteur=isset($_POST['nouveauSauveteur']);
	if($nouveauSauveteur==1)
	{
		$nbSuppr=0;
		$nbSauv=0;

		if(is_array($_POST['id']))
		{
			foreach($_POST['id'] as $k=>$val)
			{

				$resultSauveteurTmp = mysqli_query($link,"SELECT nom,prenom,telephone,mail,password FROM sauveteurtmp WHERE id=\"$val\"");

				if($myrowSauveteurTmp=mysqli_fetch_row($resultSauveteurTmp))
				{
					$requeteInsertSauveteur = "INSERT INTO sauveteur (id,nom,prenom,mail,telephone,admin,password,datederVisite,nbVisites,envoieCopy,lienAvatar,nbPhoto,dateAvantderVisite) VALUES (NULL,\"$myrowSauveteurTmp[0]\", \"$myrowSauveteurTmp[1]\", \"$myrowSauveteurTmp[3]\", \"$myrowSauveteurTmp[2]\",0, \"$myrowSauveteurTmp[4]\", now(), 1,1, \"http://crakdown.org/SNSM/Dolphin.jpg\", 6, now());";

					$result = mysqli_query($link,$requeteInsertSauveteur) or die("Query insert sauveteur failed");
					if ($result)
					{
						mysqli_query($link,"DELETE FROM sauveteurtmp WHERE id=\"$val\"");
						$nbSauv++;
					}
				}
			}
		}

		if(is_array($_POST['supprid']))
		{
			foreach($_POST['supprid'] as $k=>$valSuppr)
			{
				mysqli_query($link,"DELETE FROM sauveteurtmp WHERE id=\"$valSuppr\"");
				$nbSuppr++;
			}
		}

		if(is_array($_POST['supprid']) || is_array($_POST['id']))
		{
			echo "$nbSauv sauveteur(s) ont été inscrits correctement dans la base.<br>\n";
			echo "$nbSuppr item(s) supprimé(s).<br/>\n";
		}
	}
	else
	{

		$queryNouveauSauveteurs=mysqli_query($link,"SELECT id,nom,prenom,mail from sauveteurtmp");
		$nbSauv=0;

		$nbNouveauSauveteurs=mysqli_num_rows($queryNouveauSauveteurs);

		if($nbNouveauSauveteurs>0)
		{
			echo "<h2><b>Sauveteurs en attente d'inscription<b></h2>\n";
			echo "<form name=\"validNouveauSauveteurs\" ACTION=\"news.php\" METHOD=\"POST\">\n";
			echo "<INPUT TYPE=\"hidden\" name=\"nouveauSauveteur\" value=1>\n";

			echo "<center><table border=1 width=100%>";
			echo "<tr><td>Valider l'inscription</td><td>Supprimer l'inscription</td><td>Nom</td><td>Prénom</td><td>Mail</td></tr>";
			while ($myrowNouveauSauveteurs=mysqli_fetch_row($queryNouveauSauveteurs))
			{
				echo "<tr><td><input id=\"id$nbSauv\" type=\"checkbox\" name=\"id[]\" value=\"$myrowNouveauSauveteurs[0]\" onClick=\"javascript:deselectionneSuppr('$nbSauv');\"></td><td><input id=\"supprid$nbSauv\" type=\"checkbox\" name=\"supprid[]\" value=\"$myrowNouveauSauveteurs[0]\" onClick=\"javascript:deselectionneOk('$nbSauv');\"></td><td>$myrowNouveauSauveteurs[1]</td><td>$myrowNouveauSauveteurs[2]</td><td>$myrowNouveauSauveteurs[3]</td><tr>";
				$nbSauv++;
			}
			echo "</table>";

			echo "<INPUT TYPE=\"button\" VALUE=\"Enregistrer\" onClick=\"envoyer();\"></FORM><br/>\n";
		}
		else
		{
			echo "<h2>Aucune inscription en attente</h2>";
		}
	}
}


if(@$nbCommentaireNonLu>0){
?>

<h2><b>Nouveaux commentaires depuis votre dernière visite : </b></h2><br>
 <UL>
<?php

 while ($myrowNouveauCommentaires=mysqli_fetch_row($queryCommentaire)) {
   if($myrowNouveauCommentaires[1]==''){
     echo "<LI/><a href=\"./detailPhoto.php?id_photo=$myrowNouveauCommentaires[0]&gallerie=$myrowNouveauCommentaires[2]\">Photo sans titre</a>";
   } else {
     echo "<LI/><a href=\"./detailPhoto.php?id_photo=$myrowNouveauCommentaires[0]&gallerie=$myrowNouveauCommentaires[2]\">$myrowNouveauCommentaires[1]</a>";
   }
 }





?>
 </UL>

<?php
}
?>


Vous allez être redirigé sur la page des postes de secours d'ici 50 secondes.<br><br><br><br><br><br><br><br>
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
