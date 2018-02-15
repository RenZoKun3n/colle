<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');
include("ongletNomDeconnexion.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">


<title>Ajout d'un sauveteur</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<link rel="stylesheet" href="css/master.css">
<?php if (isset($_SESSION['id'])) {
	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];

	$link=connectDB();

	if(isset($_POST['nom'])) $nom=$_POST['nom'];
	else $nom = "none";

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");

	$rowAdmin=mysqli_fetch_row($queryAdmin);

	// On test si l'utilisateur est admin ou non
	if ($rowAdmin[0]==2 || $rowAdmin[0]==1) {

		if (!$nom || $nom == "none") {

?>
<script type="text/javascript">
<!--
function envoyer(){
	if ( (document.ajout.nom.value=="-----") || (document.ajout.nom.value=="") ){
		alert("Veuillez remplir tous les champs,  merci");
	} else {
		document.ajout.submit();
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
Ajout d'un sauveteur
</div>
</center>
<div id="container">
	
<?php
	echo "<br><b>Veuillez renseigner les différents champs puis <br>cliquez sur Enregistrer pour ajouter un nouveau sauveteur</b>";
	echo "<form name=\"ajout\" ACTION=\"ajoutSauveteur.php\" METHOD=\"POST\">\n";
  	echo "<select name=\"nom\"><option value\"-----\" selected=\"selected\">-----</option>";

  	$querySauvTmp=mysqli_query($link,"SELECT mail FROM sauveteurtmp") or die("Select querySauveteurTmp failed");
	while($sauveteurTmp=mysqli_fetch_row($querySauvTmp)){
		echo "<option value=\"$sauveteurTmp[0]\">$sauveteurTmp[0]</option>";
	}

  	echo "</select>";
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


<title>Ajout d'un sauveteur</title>
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<?php
        $mail=$_POST['nom'];

        $queryAjout=mysqli_query($link,"SELECT nom, prenom, telephone, password FROM sauveteurtmp WHERE mail=\"$mail\"") or die("Select queryAjout failed");
		$rowAjout=mysqli_fetch_row($queryAjout);

		$dateactu = "20" . date("y-m-d");

		$nom2 = strtoupper($rowAjout[0]);  // Mise en majuscule du nom
		$mail = strtolower($mail); // Mise en minuscule du mail
		$prenom=$rowAjout[1];
		$tel=$rowAjout[2];
		$passwd=$rowAjout[3];

		$result3=mysqli_query($link,"INSERT INTO sauveteur VALUES (NULL,\"$nom2\", \"$prenom\",\"$mail\", \"$tel\", 0, \"$passwd\", DATE_ADD(now(), INTERVAL +2 HOUR) , 1, 1,\"http://crakdown.org/SNSM/Dolphin.jpg\",6, DATE_ADD(now(), INTERVAL +1 HOUR),1);") or die("L'ajout du sauveteur a echouée");

		$result4=mysqli_query($link,"DELETE FROM sauveteurTmp WHERE mail=\"$mail\";") or die("La suppresion dans sauveteurTmp a echouée");



		echo "<div id=\"container\"> Opération terminée<br><br>\n<a href=\"ajoutSauveteur.php?$nom=\"none\"\">Ajout d'un autre sauveteur</a><br>\n";
		echo "<a href=\"visuPoste.php\">Retour page principale</a></div>";

	}
	} else {
?>
	<body>
		<center><div id="intro">Opération non autorisée</div></center>
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
