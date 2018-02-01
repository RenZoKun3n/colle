  <?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');

$joursem = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
?>

<HEAD>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0050)http://crakdown.org/SNSM/visuPoste.php?prochains=1 -->
<TITLE>Visualisation des prochains postes de secours SNSM</TITLE>
<HTML lang=fr xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<META content="MSHTML 6.00.5730.13" name=GENERATOR>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
</HEAD>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/master.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<SCRIPT type=text/javascript>

function actionModifPoste(idP){
  document.modifPoste.action.value=1;
  document.modifPoste.idPoste.value=idP;
  document.modifPoste.submit();
}

function actionSupprPoste(idP)
{
  if(confirm("Vous êtes sur le point de supprimer un poste ! Confirmez-vous l opération ?"))
  {
	document.modifPoste.action.value=2;
	document.modifPoste.idPoste.value=idP;
	document.modifPoste.submit();
  }
}

function afficheParticipe(hDeb,hFin,nbP,idSauveteur){

	var hauteur;
	var largeur;
	var scroll;

	if(!document.all)
	{
		hauteur = window.innerHeight;
		largeur = window.innerWidth;
		scroll = window.pageYOffset;
	}
	else
	{
		hauteur = document.body.offsetHeight;
		largeur = document.body.offsetWidth;
		scroll = document.body.scrollTop;
	}
	fx=largeur-20;  //l fenêtre
	fy=hauteur;     //h fenêtre
	sy=scroll;      //scroll v


	with(document.getElementById('divParticipe').style){
		left=(fx-504)/2+"px";top=sy-13+(fy-308)/2+"px";
	}

	document.formParticipe.hdeb.value=hDeb;
	document.formParticipe.hfin.value=hFin;
	document.formParticipe.idPoste.value=nbP;
	document.formParticipe.idSauveteur.value=idSauveteur;
	document.formParticipe.participe.value=1;

	document.getElementById('divParticipe').style.display='block';
}

function annulerParticipe(){
	document.getElementById('divParticipe').style.display='none';
}

function envoyerParticipe(){
	var reg=new RegExp("^([0-1]?[0-9]|2[0-4])[:][0-5]?[0-9][:][0-5]?[0-9]$","g");
	var reg2=new RegExp("^([0-1]?[0-9]|2[0-4])[:][0-5]?[0-9][:][0-5]?[0-9]$","g");

	if(!reg.test(document.formParticipe.hdeb.value))
	{
		alert("L'heure d'arrivée doit être au format heures:minutes:secondes");
		return false;
	}

	if(!reg2.test(document.formParticipe.hfin.value))
	{
		alert("L'heure de départ doit être au format heures:minutes:secondes");
		return false;
	}

	document.formParticipe.submit();

}

function afficheParticipeAdmin(hDeb,hFin,nbP){

		var hauteur;
	var largeur;
	var scroll;

	if(!document.all)
	{
		hauteur = window.innerHeight;
		largeur = window.innerWidth;
		scroll = window.pageYOffset;
	}
	else
	{
		hauteur = document.body.offsetHeight;
		largeur = document.body.offsetWidth;
		scroll = document.body.scrollTop;
	}
	fx=largeur-20;  //l fenêtre
	fy=hauteur;     //h fenêtre
	sy=scroll;      //scroll v

	with(document.getElementById('divParticipe2').style){
		left=(fx-504)/2+"px";top=sy-13+(fy-308)/2+"px";
	}

	document.formParticipeAdmin.hdeb.value=hDeb;
	document.formParticipeAdmin.hfin.value=hFin;
	document.formParticipeAdmin.idPoste.value=nbP;
	document.formParticipeAdmin.participe.value=2;

	document.getElementById('divParticipe2').style.display='block';
}

function annulerParticipeAdmin(){
	document.getElementById('divParticipe2').style.display='none';
}

function envoyerParticipeAdmin(){
	var reg=new RegExp("^([0-1]?[0-9]|2[0-4])[:][0-5]?[0-9][:][0-5]?[0-9]$","g");
	var reg2=new RegExp("^([0-1]?[0-9]|2[0-4])[:][0-5]?[0-9][:][0-5]?[0-9]$","g");

	if(!reg.test(document.formParticipeAdmin.hdeb.value))
	{
		alert("L'heure d'arrivée doit être au format heures:minutes:secondes");
		return false;
	}

	if(!reg2.test(document.formParticipeAdmin.hfin.value))
	{
		alert("L'heure de départ doit être au format heures:minutes:secondes");
		return false;
	}

	document.formParticipeAdmin.submit();

}


function montre(id) {
var d = document.getElementById(id);
	for (var i = 1; i<=40; i++) {
		if (document.getElementById('smenu'+i)) {document.getElementById('smenu'+i).style.display='none';}
	}
if (d) {d.style.display='block';}
}
</script>
<body>

<?php

if (isset($_SESSION['id'])) {
	//l'utilisateur est authentifié
	$idSession=$_SESSION['id'];
	$nomSession=$_SESSION['nom'];
	$prenomSession=$_SESSION['prenom'];
	//echo "test : $idSession";

	echo "<div>$nomSession $prenomSession</div>";

	$link=connectDB();

	// On test si l'utilisateur est un administrateur
	$queryAdmin=mysqli_query($link,"SELECT admin FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
	$rowAdmin=mysqli_fetch_row($queryAdmin);

  $participe = isset($_GET['participe']) ? $_GET['participe'] : NULL;
	//$participe=$_GET['participe'];
  $suppr = isset($_GET['suppr']) ? $_GET['suppr'] : NULL;
	//$suppr=$_GET['suppr'];
  $idSauveteur = isset($_GET['idSauveteur']) ? $_GET['idSauveteur'] : NULL;
	//$idSauveteur=$_GET['id_Sauveteur'];
  $idPoste = isset($_GET['idPoste']) ? $_GET['idPoste'] : NULL;
	//$idPoste=$_GET['id_Poste'];
  $heureDebut = isset($_GET['hdeb']) ? $_GET['hdeb'] : NULL;
	//$heureDebut=$_GET['hdeb'];
  $heureFin = isset($_GET['hfin']) ? $_GET['hfin'] : NULL;
	//$heureFin=$_GET['hfin'];

	if($participe==2){
		participation($link,$participe,$idPoste,$idSauveteur,$rowAdmin[0],$heureDebut,$heureFin);
	} else if($participe==1) {
		participation($link,$participe,$idPoste,$idSession,0,$heureDebut,$heureFin);
	}

	if($suppr==1 && ($rowAdmin[0]==1 || $rowAdmin[0]==2)){
	  $idSauveteur=$_GET['idSauveteur'];
	  $idPoste=$_GET['idPoste'];
 	  supprimeParticipation($link,$idPoste,$idSauveteur);
	}


	 if($rowAdmin[0]==1 || $rowAdmin[0]==2){
	  echo "<FORM name=\"modifPoste\" ACTION=\"modifierPoste.php\" METHOD=\"POST\">\n";
	  echo "<INPUT TYPE=\"hidden\" name=\"action\">\n";
	  echo "<INPUT TYPE=\"hidden\" name=\"idPoste\">\n";
	  echo "</FORM>";
  	}

?>


<center>
<div id="header">
Prochains postes de secours SNSM
</div>
</center>



<div id="intro">Vous retrouverez ici,&nbsp les caractéristiques des postes de secours effectués par le centre
de formation de Montbéliard. </div>

<div id="container">
 <div class="listePostes">

	<div id="divParticipe">
		Veuillez préciser vos horaires de présence à ce poste<br/>
		<small><b> NB: Essayer si possible de couvrir toute la durée du poste</b></small>
		<FORM name="formParticipe" ACTION="visuPoste.php" METHOD="GET">
		<input type="hidden" name="idPoste">
		<input type="hidden" name="idSauveteur">
		<input type="hidden" name="participe">
		<table>
		<tr><td>Heure d'arrivée : </td><td><input type="text" name="hdeb" size=10 maxlength=8></td></tr>
		<tr><td>Heure de départ : </td><td><input type="text" name="hfin" size=10 maxlength=8></td></tr>
		<tr>
		<td><INPUT TYPE="button" VALUE="Ajouter ma participation" class="submitParticipe" onClick="envoyerParticipe();"></td>
		<td><INPUT TYPE="button" VALUE="Annuler" class="submitParticipe" onClick="annulerParticipe();"></td>
		</tr>
		</table>
		</FORM>
	</div>
<?php
  if($rowAdmin[0]==1 || $rowAdmin[0]==2)
  {
?>
	<div id="divParticipe2">
		Veuillez sélectionner le sauveteurs ainsi que ses horaires de présence au poste<br/>
		<FORM name="formParticipeAdmin" ACTION="visuPoste.php" METHOD="GET">
		<input type="hidden" name="idPoste">
<?php
		echo "<select name=\"idSauveteur\">";
		$querySauveteur2=mysqli_query($link,"SELECT id,nom,prenom FROM sauveteur WHERE actif=1 ORDER BY `nom` ASC") or die("Select sur tous les sauveteurs failed");
		while($sauveteur2=mysqli_fetch_row($querySauveteur2)){
			echo "<option value=\"$sauveteur2[0]\">$sauveteur2[1] $sauveteur2[2]\n";
		}
		echo "</select>";
?>
		<input type="hidden" name="participe">
		<table>
		<tr><td>Heure d'arrivée : </td><td><input type="text" name="hdeb" size=10 maxlength=8></td></tr>
		<tr><td>Heure de départ : </td><td><input type="text" name="hfin" size=10 maxlength=8></td></tr>
		<tr>
		<td><INPUT TYPE="button" VALUE="Ajouter la participation" class="submitParticipe" onClick="envoyerParticipeAdmin();"></td>
		<td><INPUT TYPE="button" VALUE="Annuler" class="submitParticipe" onClick="annulerParticipeAdmin();"></td>
		</tr>
		</table>
		</FORM>
	</div>

<?php
  }

  $dateactu = "20" . date("y-m-d");

  $prochains = isset($_POST['prochains']) ? $_POST['prochains'] : NULL;
  //$prochains=$_POST['prochains'];

  if(!$prochains || $prochains=="none") {
	  $result=mysqli_query($link,"SELECT * FROM poste WHERE datedeb >= '$dateactu' ORDER BY datedeb ASC") or die("Select sur poste failed");
  }else {
	if($prochains==1){
	  	$result=mysqli_query($link,"SELECT * FROM poste WHERE datedeb >= '$dateactu' ORDER BY datedeb ASC") or die("Select sur poste failed");
	} else {
	 	$result=mysqli_query($link,"SELECT * FROM poste WHERE  datedeb < '$dateactu' ORDER BY datedeb ASC") or die("Select sur poste failed");
	}
  }



  while ($myrow=mysqli_fetch_row($result)) {

	echo "   <div class=\"libellePoste\">";
	echo "$myrow[1] &nbsp&nbsp";
	if($rowAdmin[0]==1 || $rowAdmin[0]==2){

		echo "<img src=\"mod.gif\" onclick='actionModifPoste($myrow[0]);'>";
		echo "<img src=\"supp.gif\" onclick='actionSupprPoste($myrow[0]);'>";

	}

	echo "</div>\n";



	$datedeb=datefren($myrow[2]);
	$datefin=datefren($myrow[3]);


	echo "   <div class=\"poste\">\n";

	echo "<span class=\"datePoste\">";
			if($datedeb != $datefin){
				list($heure,$minute,$seconde) = explode(':', $myrow[4]);
				list($heure2,$minute2,$seconde2) = explode(':', $myrow[5]);
				$j1=jourSemaine($datedeb);
				echo "Du $joursem[$j1] $datedeb $heure:$minute au ";
				$j2=jourSemaine($datefin);
				echo "$joursem[$j2] $datefin $heure2:$minute2 ";
			} else {
				list($heure,$minute,$seconde) = explode(':', $myrow[4]);
				list($heure2,$minute2,$seconde2) = explode(':', $myrow[5]);
				$jour=jourSemaine($datedeb);
				echo "$joursem[$jour] $datedeb de $heure:$minute à $heure2:$minute2&nbsp";
			}
	echo "</span> <!-- <div class=\"datePoste\"> -->\n";



	echo "    <span class=\"lieuPoste\">";
		echo "Lieu : $myrow[6]";
	echo "</span> <!-- <div class=\"lieuPoste\"> -->\n";

	echo "    <div class=\"spacer\"></div>\n";


	if ($myrow[8]!="") {
		echo "<div class=\"commentairePoste\">";
		echo "Autre information(s) : $myrow[8]";
		echo "</div> <!-- <div class=\"commentairePoste\"> -->\n";
	}

	echo "<hr align=center/>";

	echo "    <div class=\"requiPoste\">";
		echo "Nombre minimum de sauveteurs requis : <b>$myrow[7]</b>";
	echo "</div> <!-- <div class=\"requiPoste\"> -->\n";


	echo "   <div class=\"participe\">";
	$participeDeja=false;
	echo "Participant(s) :<br>";
	$compteur=0;
	echo "<table border=0 class=\"participe\">";
	$queryParticipe=mysqli_query($link,"SELECT * FROM participe WHERE id_poste=$myrow[0]") or die("Select sur participe failed");
	while($participe=mysqli_fetch_row($queryParticipe)) {

		list($heureParticipeDeb,$minuteParticipeDeb,$secondeParticipeDeb) = explode(':', $participe[3]);
		list($heureParticipeFin,$minuteParticipeFin,$secondeParticipeFin) = explode(':', $participe[4]);

		if($compteur%2==0)
			echo "<tr>";

		$querySauveteur=mysqli_query($link,"SELECT nom,prenom,id FROM sauveteur WHERE id=$participe[2]") or die("Select sur sauveteur failed");
		$sauveteur=mysqli_fetch_row($querySauveteur);

		echo "<td>";

		// Possibilité de suppression d'un participant pour l'administrateur
		if ($rowAdmin[0]==1 || $rowAdmin[0]==2) {
			echo "<a href=\"./visuPoste.php?suppr=1&idPoste=$myrow[0]&idSauveteur=$sauveteur[2]\">Suppr </a>\n";
		}

		if($participe[2]==$idSession){
			$participeDeja=true;

			if($heureParticipeDeb==0 && $heureParticipeFin==0 && $minuteParticipeDeb==0 && $minuteParticipeFin==0)
			{
			   echo "<td><b><img src=\"./puce.gif\">&nbsp $sauveteur[0] $sauveteur[1]&nbsp&nbsp</b></td>";
			}
			else
			{
			    if ($heureParticipeDeb!=$heure || $heureParticipeFin!= $heure2 || $minuteParticipeDeb!=$minute
				|| $minuteParticipeFin!=$minute2)
				echo "<td><b><img src=\"./puce.gif\">&nbsp $sauveteur[0] $sauveteur[1]&nbsp&nbsp (de $heureParticipeDeb:$minuteParticipeDeb à $heureParticipeFin:$minuteParticipeFin)</b></td>";
			    else
				echo "<td><b><img src=\"./puce.gif\">&nbsp $sauveteur[0] $sauveteur[1]&nbsp&nbsp</b></td>";
			}
		} else {
			//$participeDeja=false;
			if($heureParticipeDeb==0 && $heureParticipeFin==0 && $minuteParticipeDeb==0 && $minuteParticipeFin==0)
			{
			   echo "<td><img src=\"./puce.gif\">&nbsp $sauveteur[0] $sauveteur[1]&nbsp&nbsp</td>";
			}
			else
			{
			   if ($heureParticipeDeb!=$heure || $heureParticipeFin!= $heure2 || $minuteParticipeDeb!=$minute
				|| $minuteParticipeFin!=$minute2)
				echo "<td><img src=\"./puce.gif\">&nbsp $sauveteur[0] $sauveteur[1]&nbsp&nbsp (de $heureParticipeDeb:$minuteParticipeDeb à $heureParticipeFin:$minuteParticipeFin)</td>";
			  else
				echo "<td><img src=\"./puce.gif\">&nbsp $sauveteur[0] $sauveteur[1]&nbsp&nbsp</td>";
			}

		}

		if($compteur%2==1)
			echo "</tr>";
			$compteur++;
	}


		// Si le sauveteur ne participe pas déja, que ce n'est pas christian et que le poste est dans le futur
		$heureMinuteSeconde=$heure.':'.$minute.':00';
		$heureMinuteSeconde2=$heure2.':'.$minute2.':00';

		if(!$participeDeja && $rowAdmin[0]!=1
		   && (strtotime($myrow[3]) - mktime(0 , 0 , 0 , date("m") , date("d")-1 , date("Y"))) > 0){

		        echo "<a href=javascript:afficheParticipe('$heureMinuteSeconde','$heureMinuteSeconde2',$myrow[0],$idSession);>Participer à ce poste</a>";
			/*echo "<a href=\"./visuPoste.php?participe=1&idPoste=$myrow[0]\">Participer à ce poste</a>";*/
		}

		if ($rowAdmin[0]==1 || $rowAdmin[0]==2) {
		   // Moi ou Cm
		   echo "<br/><a href=javascript:afficheParticipeAdmin('$heureMinuteSeconde','$heureMinuteSeconde2',$myrow[0]);>Ajouter une participation</a>";
		}

		echo "    </table></div> <!-- <div class=\"participe\"> -->\n";

		echo "    <div class=\"spacer\"></div>";

	echo "   </div>  <!-- <div class=\"poste\"> -->\n";


  }
?>
  </div> <!-- <div class="listePostes"> -->
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
