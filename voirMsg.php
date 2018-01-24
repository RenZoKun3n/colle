<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');

$joursem = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<title>Consulter ses messages</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/master.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
</head>

<body>
<center><div id="header">Vos messages</div></center>

<?php

if (isset($_SESSION['id'])) {
	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];
	//echo "test : $idSession";

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
	$rowAdmin=mysqli_fetch_row($queryAdmin);

	echo "<div id=\"intro\">Voici les message que vous avez reçus.</div>";

	$suppr=$_GET['suppr'];


	if($suppr==1){
		supprimeMessage($idMessage,$idSession);
		$idMessage="none";
		echo "Message supprimé avec succès <br>";
	}

	?>
	<div id="container">

	<?php

	$idMessage=$_GET['idMessage'];

	if(!$idMessage || $idMessage=="none"){

		// On récupère les messages
		$queryMessage=mysqli_query($link,"SELECT * FROM messages WHERE id_desti=$idSession AND suppr='N' order by id_message desc") or die("SELECT * FROM messages WHERE id_desti=$idSession");

		echo "<table border=1 width=100\%>\n";
		echo "<tr><td><b>Expéditeur</b></td><td><b>Titre</b></td><td><b>Date</b></td><td><b>Lu</b></td><td></td></tr>\n";
		while($rowMessage=mysqli_fetch_row($queryMessage)) {
			echo "<tr><td>\n";

			$queryExp = mysqli_query($link,"SELECT nom,prenom FROM sauveteur WHERE id=$rowMessage[1]") or die("SELECT nom,prenom FROM sauveteur WHERE id=$rowMessage[1]");
			$rowExp=mysqli_fetch_row($queryExp);



			if($rowMessage[6]){
				echo "$rowExp[0] $rowExp[1]</td><td><a href=\"./voirMsg.php?idMessage=$rowMessage[0]\">$rowMessage[4]</a></td><td>$rowMessage[3]</td><td>Oui";
			} else {
				echo "<b>$rowExp[0] $rowExp[1]</b></td><td><a href=\"./voirMsg.php?idMessage=$rowMessage[0]\"><b>$rowMessage[4]</b></a></td><td><b>$rowMessage[3]</b></td><td><b>Non</b>";
			}

			echo "</td><td><a href=\"./voirMsg.php?suppr=1&idMessage=$rowMessage[0]\">Suppr</a>";
			echo "</td></tr>\n";
		}
		echo "</table><br/><br/>\n";

	} else {

		$queryMessage=mysqli_query($link,"SELECT id_exp,titre,date,texte,id_message FROM messages WHERE id_message=$idMessage AND id_desti=$idSession") or die("SELECT id_exp,titre,date,texte FROM messages WHERE id_message=$idMessage AND id_desti=$idSession");

		// On test si on a trouvé un message correspondant aux critères
		if($rowMessage=mysqli_fetch_row($queryMessage)){

			$queryExp = mysqli_query($link,"SELECT nom,prenom,id FROM sauveteur WHERE id=$rowMessage[0]") or die("SELECT nom,prenom FROM sauveteur WHERE id=$rowMessage[0]");
			$rowExp=mysqli_fetch_row($queryExp);

			echo "<br><br><b>Titre :</b> $rowMessage[1]<br>";
			echo "<b>Exp :</b> $rowExp[0] $rowExp[1]<br>";

			echo "<b>Date :</b> $rowMessage[2]<br><br>";
			echo "<b>Texte :</b> $rowMessage[3]";


			// On met à jour le champ lu, puisque le message a été lu
			$queryUpdate=mysqli_query($link,"UPDATE messages SET lu=1 WHERE id_message=$idMessage AND id_desti=$idSession") or die("UPDATE messages SET lu=1 WHERE id_message=$idMessage AND id_desti=$idSession");


			echo "<br><br><center><a href=\"./repondre.php?desti=$rowExp[2]\">Répondre</a>";
			echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href=\"./voirMsg.php?suppr=1&idMessage=$rowMessage[4]\">Supprimer ce message</a></center>";

			echo "<br><center><a href=\"./voirMsg.php?idMessage=none\">Retour à la liste des messages</a></center>";
		}
	}

	echo "</div>";

	menu($link,$rowAdmin[0],$idSession);

	footer();
	echo "</body></html>";

} else {
?>

<div id="intro">Vous ne pouvez pas visualiser cette page actuellement. Veuillez vous <a href="./index.php">identifier</a>.</div>
</body>
</html>

<?php
}
?>
