<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');
include("ongletNomDeconnexion.php");

?>

<html>
<head>
  <title>Ajout d'un poste</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="feuille1.css" type="text/css" />
  <link rel="stylesheet" href="css/master.css">
</head>

<?php
if(isset($_SESSION['id'])){


  //l'utilisateur est authentifié
  $idSession=$_SESSION['id'];

  $link=connectDB();

  // On test si l'utilisateur est un administrateur
  $queryAdmin=mysqli_query($link,"SELECT admin,dateAvantderVisite FROM sauveteur WHERE id=$idSession") or die("Select queryAdmin failed");
  $rowAdmin=mysqli_fetch_row($queryAdmin);

  mysqli_query($link,"UPDATE sauveteur SET dateAvantderVisite=DATE_ADD(now(), INTERVAL +2 HOUR) WHERE id=$idSession") or die("Update Sauveteur News failed");


 $libelle=isset($_POST['libelle']) ? $_POST['libelle'] : NULL;
 $modif=isset($_POST['modif']) ? $_POST['modif'] : NULL;
 $datefinfr=isset($_POST['datefinfr']) ? $_POST['datefinfr'] : NULL;
 $datedebfr=isset($_POST['datedebfr']) ? $_POST['datedebfr'] : NULL;
 $heuredeb=isset($_POST['heuredeb']) ? $_POST['heuredeb'] : NULL;
 $heurefin=isset($_POST['heurefin']) ? $_POST['heurefin'] : NULL;

 $lieu=isset($_POST['lieu']) ? $_POST['lieu'] : NULL;
 $participantsMini=isset($_POST['participantsMini']) ? $_POST['participantsMini'] : NULL;
 $commentaire=isset($_POST['commentaire']) ? $_POST['commentaire'] : NULL;
 $idPoste=isset($_POST['idPoste']) ? $_POST['idPoste'] : NULL;

 if(($libelle && $libelle != "none") || $modif==2) {

   if(!$datefinfr || $datefinfr == "none") {
      $datefinfr = $datedebfr;
   }
   // On met les dates au format anglais
   //$datefin=datefren($datefinfr);
  // $datedeb=datefren($datedebfr);

  // On se connecte a la babase
  $link=connectDB();

  if($modif==1){
	echo "Modification du poste : $idPoste ($libelle)<br/>\n";

	mysqli_query($link,"UPDATE poste SET libelle=\"$libelle\", datedeb='$datedeb', datefin='$datefin', heuredeb='$heuredeb', heurefin='$heurefin', lieu=\"$lieu\" ,participantsMini='$participantsMini', commentaire=\"$commentaire\" WHERE id=$idPoste") or die("Echec de la modification");

	echo "<a href=./visuPoste.php?prochains=1>Retour à la liste des postes</a><br/>\n";

  } else {
	if($modif==2){

	mysqli_query($link,"DELETE FROM poste WHERE id=$idPoste") or die("La requete de suppression a échouée");
	mysqli_query($link,"DELETE FROM participe WHERE id_poste=$idPoste") or die("La requete de suppression (table participe) a échouée");

	echo "Suppression effectué.<br/>Cliquer <a href=./visuPoste.php?prochains=1>Ici</a> pour retourner à la liste des postes.<br/>\n";

  	} else {

		// On ajoute le poste
		$result=mysqli_query($link,"INSERT INTO poste VALUES (NULL,\"$libelle\", '$datedebfr', '$datefinfr', '$heuredeb', '$heurefin', \"$lieu\" ,'$participantsMini', \"$commentaire\");") or die("Query failed");

	        echo "<b>Insertion réalisée avec succès</b><br/><br/>Vous pouvez retourner à la page des <a href=\"./visuPoste.php?prochains=1\">Prochains postes</a> ,<br/>";
		echo "ou <a href=\"./ajouterPoste.php?libelle=none\">ajouter un autre poste</a>.<br/>";
	}
  }

 } else {


?>
  <center>
  <div id="header"><p>Ajout d'un poste</p></div>
  </center>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
  <FORM ENCTYPE="multipart/form-data" ACTION="ajouterPoste.php" METHOD="POST">

  <div class="container-fluid fo"> <div class="col-lg-2"> Nom du poste :</div> <div class="col-lg-4"> <input type="text" name="libelle" size=60 maxlength=60></div></div>
  <div class="container-fluid fo"> <div class="col-lg-2"> Date début :</div> <div class="col-lg-4"> <input type="date" name="datedebfr" size=10 maxlength=10 >  (exemple : 28/02/2007)</div></div>
  <div class="container-fluid fo"> <div class="col-lg-2"> Date fin (si différente de date début) :</div> <div class="col-lg-4"> <input type="date" name="datefinfr" size=10 maxlength=10 > (exemple : 28/02/2007)</div></div>
  <div class="container-fluid fo"> <div class="col-lg-2"> Heure début :</div> <div class="col-lg-4"> <input type="text" name="heuredeb" size=10 maxlength=10> (exemple: 08:30:00)</div></div>
  <div class="container-fluid fo"> <div class="col-lg-2"> Heure fin :</div> <div class="col-lg-4"> <input type="text" name="heurefin" size=10 maxlength=10> (exemple: 17:00:00)</div></div>
  <div class="container-fluid fo"> <div class="col-lg-2"> Lieu :</div> <div class="col-lg-4"> <input type="text" name="lieu" size=70 maxlength=70></div></div>
  <div class="container-fluid fo"> <div class="col-lg-2"> Sauveteurs requis (au minimum) :</div> <div class="col-lg-4"> <input type="text" name="participantsMini" size=3 maxlength=3> (saisissez un nombre uniquement)</div></div>
  <div class="container-fluid fo"> <div class="col-lg-2"> Commentaire :</div> <div class="col-lg-4"> <textarea name="commentaire" cols=30 rows=4></textarea> </br> (Autres informations utiles pour le poste)</div></div>

  <div><INPUT TYPE="submit" VALUE=Enregistrer le poste></FORM></div>
<?php

}
menu($link,$rowAdmin[0],$idSession);
?>

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
