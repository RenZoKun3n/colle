<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">


<title>Modification du mot de passe d'un sauveteur</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<link rel="stylesheet" href="css/master.css">

<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');
include("ongletNomDeconnexion.php");

if (isset($_SESSION['id'])) {
	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];

	$link=connectDB();


	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");

	$rowAdmin=mysqli_fetch_row($queryAdmin);

	?>

	<?php



	if(isset($_POST['ancienMdp'])) $ancienMdp=md5($_POST['ancienMdp']);
	else $ancienMdp="";

	if(isset($_POST['nouveauMdp'])) $nouveauMdp=md5($_POST['nouveauMdp']);
	else $nouveauMdp="";

	if(isset($_POST['confirmMdp'])) $confirmMdp=md5($_POST['confirmMdp']);
	else $confirmMdp="";

		if ($ancienMdp=="" || $nouveauMdp=="" || $confirmMdp=="") {
?>

<script type="text/javascript">
<!--
function envoyer(){
	if ( (document.modification.nouveauMdp.value=="") || (document.modification.confirmMdp.value=="") || (document.modification.ancienMdp.value=="")){
		alert("Veuillez remplir tous les champs,  merci");
	} else {
		if((document.modification.nouveauMdp.value.length<4)){
			alert("Le mot de passe est trop court (4 caractère minimum)");
		} else {
			if(document.modification.nouveauMdp.value != document.modification.confirmMdp.value) {
				alert("Les mots de passe ne sont pas les mêmes.");
			} else {
				document.modification.submit();
			}
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
<p>Modification du mot de passe</p>
</div>
</center>
<div id="container">

	<br><b>Veuillez remplir le formulaire de changement de mot de passe : </b>
	<form name="modification" ACTION="modifierSonMdp.php" METHOD="POST">
	<div class="container-fluid fo"> <div class="col-lg-5"> Ancien mot de passe : </div> <div class="col-lg-6"> <input type="password" name="ancienMdp" size=20 maxlength=20></div></div>
	<div class="container-fluid fo"> <div class="col-lg-5"> Nouveau mot de passe : </div> <div class="col-lg-6"> <input type="password" name="nouveauMdp" size=20 maxlength=20></div></div>
  <div class="container-fluid fo"> <div class="col-lg-5"> Confirmer mot de passe : </div> <div class="col-lg-6"> <input type="password" name="confirmMdp" size=20 maxlength=20></div></div>
	<INPUT TYPE="button" VALUE="Enregistrer" onClick="envoyer();"></form>

</div>

</body>
<?php
	} else {
		// modif du mdp

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">


<title>Modification de mot de passe d'un sauveteur</title>
<link rel="stylesheet" href="feuille1.css" type="text/css" />
		<center>
		<div id="header">
		     <p>Modification du mot de passe</p>
		</div>
		</center>
<?php
		$queryAncienMdp=mysqli_query($link,"SELECT id FROM sauveteur WHERE id=$idSession AND password=\"$ancienMdp\"") or die("Select queryAncienMdp failed");
		$rowVerifMdp=mysqli_fetch_row($queryAncienMdp);
		if($rowVerifMdp[0]=="" || !isset($rowVerifMdp[0]) || $rowVerifMdp[0]==null){
			echo"<div id=\"container\"><b>L'ancien mot de passe indiqué n'était pas le bon</b><br/><a href=\"modifierSonMdp.php\">Retour sur la page de modification de mot de passe</a></div>";
		} else {
			$result3=mysqli_query($link,"UPDATE sauveteur SET password = \"$nouveauMdp\" where id = $idSession") or die("La modification du mot de passe a echouée");
			if(!$result3){
				echo"<div id=\"container\"><b>Erreur lors de la modification du mot de passe</b><br/><a href=\"modifierSonMdp.php\">Retour sur la page de modification de mot de passe</a></div>";
			} else{
				echo"<div id=\"container\"><b>Modification du mot de passe effectuée</b><br/><a href=\"visuPoste.php?prochains=1\">Retour sur la page des postes</a></div>";
			}
		}
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
