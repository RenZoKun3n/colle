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
<title>Ecrire un message personnel</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<link rel="stylesheet" href="css/master.css">
 <script language="javascript">
 <!--
 function envoyer(){
			if (document.message.titre.value=="") {
				alert("Veuillez donner un titre à votre message");
			} else {
				document.message.submit();
			}
		}
-->
</script>
</head>

<body>



<?php



if (isset($_SESSION['id'])) {

	echo "<center><div id=\"header\"><p>Ecrire un message personnel</p></div></center>";

	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];
	//echo "test : $idSession";

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
	$rowAdmin=mysqli_fetch_row($queryAdmin);

	echo "<div id=\"container\">";

	if(isset($_POST['desti']))$desti=$_POST['desti'];
	else $desti="none";
	if(isset($_POST['dateactu']))$dateactu=$_POST['dateactu'];
	else $dateactu="none";
	if(isset($_POST['titre']))$titre=$_POST['titre'];
	else $titre="none";
	if(isset($_POST['texte']))$texte=$_POST['texte'];
	else $texte="none";


	if($desti && $desti!="none"){

		$dateactu = "20" . date("y-m-d");
		//On insere ici
		$result=mysqli_query($link,"INSERT INTO messages VALUES (NULL,'$idSession', '$desti', \"$dateactu\", \"$titre\",\"$texte\", '0', \"N\");") or die("Query failed");

		$queryDesti=mysqli_query($link,"SELECT envoieCopy,mail FROM sauveteur WHERE id=$desti");
		$destinataire=mysqli_fetch_row($queryDesti);

		echo "<br><br><b>Votre message a bien été envoyé</b><br><br>";

		// On regarde si le destinataire veut recevoir des mails
		if($destinataire[0]!="0"){
			$queryExp=mysqli_query($link,"SELECT nom,prenom FROM sauveteur WHERE id=$idSession");
			$exp=mysqli_fetch_row($queryExp);

			$texte=$texte."\n\nNe cliquez pas sur le Bouton 'Repondre' de votre logiciel de courrier pour répondre à ce message\nConnectez vous sur http://crakdown.org/SNSM\nMerci";

			$titre=stripcslashes($titre);
			$texte=stripcslashes($texte);

			if(mail($destinataire[1],"Nouveau message personnel sur http://crakdown.org/SNSM de la part de ".$exp[0]." ".$exp[1]." - ".$titre,$texte,"From:snsm@crakdown.org")==false){
				echo "La copie du message envoyé par email a echoué (cependant votre message sera visible en interne).";
			} else {
				echo "Copie du message par email envoyé correctement.";
			}
		} else {
			echo "Le destinataire du message ne souhaite pas recevoir une copie du message par e-mail.";
		}

		echo "<br><br><br><br><center><a href=\"./visuPoste.php\">Retour</a></center>";

	} else {

    ?>
		<FORM name="message" ACTION="writeMsg.php" METHOD="POST">
		<br>
    <div class="container-fluid"><div class="col-ms-4"> Titre du message :</div> <div class="col-ms-8"><input type="text" name="titre" size=35 maxlength=50></div></div>
	<!--	//echo "<INPUT TYPE=\"hidden\" name=\"exp\" value=\"$idSession\">\n";
		//echo "<INPUT TYPE=\"hidden\" name=\"idPoste\" value=\"$myrow[0]\">\n";-->
		<div class="container-fluid"><div class="col-ls-3"> Texte : </div><div class="col-ls-9"><textarea name="texte" cols=30 rows=4></textarea></div></div>
    <?php
		echo "<select name=\"desti\">";
		$querySauveteur2=mysqli_query($link,"SELECT id,nom,prenom FROM sauveteur ORDER BY `nom` ASC") or die("Select sur tous les sauveteurs failed");
		while($sauveteur2=mysqli_fetch_row($querySauveteur2)){
			echo "<option value=\"$sauveteur2[0]\">$sauveteur2[1] $sauveteur2[2]\n";
		}
		echo "</select>";
		echo "<INPUT TYPE=\"button\" VALUE=\"Envoyer Message\" onClick=\"envoyer();\"></FORM>\n";


	}

	echo "</div>";

	menu($link,$rowAdmin[0],$idSession);

	footer();

} else {
?>

<div id="intro">Vous ne pouvez pas visualiser cette page actuellement. Veuillez vous <a href="./index.php">identifier</a>.</div>
</body>
</html>

<?php
}
?>
