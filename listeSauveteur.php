<?php
session_start();
include('menu.php');
include('fonctions.php');
include("ongletNomDeconnexion.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<head>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<title>Liste des sauveteurs</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<link rel="stylesheet" href="css/master.css">
<script>
	function SupprSauv(idS)
	{
	  if(confirm("Vous êtes sur le point de supprimer un sauveteur ! Confirmez-vous l opération ?"))
	  {
		document.supprSauv.idSauv.value=idS;
		document.supprSauv.submit();
	  }
	}
</script>

<?php
if (isset($_SESSION['id'])) {
	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");

	$rowAdmin=mysqli_fetch_row($queryAdmin);

	if($rowAdmin[0]==1 || $rowAdmin[0]==2){
	  echo "<FORM name=\"supprSauv\" ACTION=\"supprSauveteur.php\" METHOD=\"POST\">\n";
	  echo "<INPUT TYPE=\"hidden\" name=\"idSauv\">\n";
	  echo "</FORM>";
  	}

	// On test si l'utilisateur est admin ou non
	if ($rowAdmin[0]==2 || $rowAdmin[0]==1) {
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
-->
</script></head>
<body>
<center>
<div id="header">
<p>Liste des Sauveteurs</p>
</div>
</center>
</body>
<?php
        $acs=isset($_GET['acs']);

	if(!isset($asc) || $asc=="none" || $asc==0){
		$sens="ASC";
	} else{
		$sens="DESC";
	}

	$order=isset($_GET['order']);

	if(!$order || $order=="none" || $order==0){

		// On récupère la liste des sauveteurs triée par nom de sauveteur
		$querySauveteur=mysqli_query($link,"SELECT * FROM sauveteur ORDER BY `nom` $sens") or die("Select sauveteur failed");
	}

	if($order==1){
		$querySauveteur=mysqli_query($link,"SELECT * FROM sauveteur ORDER BY `datederVisite` $sens") or die("Select sauveteur failed");
	}

	if($order==2){
		$querySauveteur=mysqli_query($link,"SELECT * FROM sauveteur ORDER BY `nbVisites` $sens") or die("Select sauveteur failed");
	}

	if(@$asc==0){
		$invasc=1;
	} else {
		$invasc=0;
	}


	echo "<table border=1 id=\"container\">\n";
	echo "<tr><td><b><a href=\"./listeSauveteur.php?asc=$invasc\">NOM</a></b></td><td><b>Prénom</b></td>";
	echo "<td><b>Mail</b></td><td><b>Téléphone</b></td><td><b><a href=\"./listeSauveteur.php?order=1&asc=$invasc\">Dernière con.</a></b></td>";
	echo "<td><b><a href=\"./listeSauveteur.php?order=2&asc=$invasc\">Nbr Con</a></b></td><td><b>Postes Eff</b></td><td>Modif Mdp</td><td>Suppr sauveteur</td></tr>\n";
	while($rowSauveteur=mysqli_fetch_row($querySauveteur)) {
		echo "<tr class=\"listSauvRow\"><td>\n";

		$queryNbParticipation=mysqli_query($link,"SELECT COUNT( * ) FROM `participe`WHERE id_sauveteur=$rowSauveteur[0]");
		$rowNbParticipation=mysqli_fetch_row($queryNbParticipation);

		echo "$rowSauveteur[1]</td><td>$rowSauveteur[2]</td><td>$rowSauveteur[3]</td><td>$rowSauveteur[4]</td><td>$rowSauveteur[7]</td><td>$rowSauveteur[8]</td><td>$rowNbParticipation[0]<td><a href=\"./modifieMdp.php?idSauveteur=$rowSauveteur[0]&nomSauveteur=$rowSauveteur[1]&prenomSauveteur=$rowSauveteur[2]\">Modif.</a></td><td>";

		if($rowSauveteur[0]!=$idSession){
			echo "<span id='supprSauv' onClick='SupprSauv($rowSauveteur[0])'>Suppr.</span>";
		}

		echo "</td>";

		echo "</td></tr>\n";
	}
	echo "<table>\n";

  menu($link,$rowAdmin[0],$idSession);

  footer();
?>

</body>
</html>

<?php
} else {
?>
	<body>
		<div id="intro">Vous ne pouvez pas visualiser cette page actuellement. Veuillez vous <a href="./index.php">identifier</a>.</div>
	</body>
<?php
  }
} else {
?>
	<body>
		<div id="intro">Vous ne pouvez pas visualiser cette page actuellement. Veuillez vous <a href="./index.php">identifier</a>.</div>
	</body>
<?php
}
?>
