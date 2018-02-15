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

	$nom=isset($_POST['nom']) ? $_POST['nom'] : NULL;

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
	if ( (document.ajout.nom.value=="") || (document.ajout.prenom.value=="") ){
		alert("Veuillez remplir tous les champs,  merci");
			} else {
				if(document.ajout.tel.value.length != 10) {
					alert("Numéro de téléphone incorrecte. Il doit etre tappé sans espace ni .");
				} else {
					document.ajout.submit();
		}
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
  	echo "<br> Nom : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type=\"text\" name=\"nom\" size=20 maxlength=20>\n";
  	echo "<br> Prénom : &nbsp&nbsp&nbsp&nbsp<input type=\"text\" name=\"prenom\" size=20 maxlength=20>\n";
	echo "<br> Mail : &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type=\"text\" name=\"mail\" size=30 maxlength=60> (si disponible)\n";
  	echo "<br> Telephone : <input type=\"text\" name=\"tel\" size=10 maxlength=10>\n";
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
                $mail=$_POST['mail'];
	        $prenom=$_POST['prenom'];
                $tel=$_POST['tel'];

		$dateactu = "20" . date("y-m-d");

		$nom2 = strtoupper($nom);  // Mise en majuscule du nom
		$mail = strtolower($mail); // Mise en minuscule du mail

		$result3=mysqli_query($link,"INSERT INTO sauveteur VALUES (NULL,\"$nom2\", \"$prenom\",\"$mail\", \"$tel\", 0, \"\", DATE_ADD(now(), INTERVAL +2 HOUR) , 1, 1,\"http://crakdown.org/SNSM/Dolphin.jpg\",6, DATE_ADD(now(), INTERVAL +1 HOUR),1);") or die("L'ajout du sauveteur a echouée");


		echo "<div id=\"container\"> Opération terminée<br><br>\n<a href=\"ajoutSauveteur.php?$nom=\"none\"\">Ajout d'un autre sauveteur</a><br>\n";
		echo "<a href=\"visuPoste.php\">Retour page principale</a></div>";

	}
	} else {
?>
	<body>
		<center><div id="header">Opération non autorisée</div></center>
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
