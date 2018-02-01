<?php
session_start();
// On inclue les fichiers php du menu et des fonctions communes à toutes les pages
include('menu.php');
include('fonctions.php');

?>

<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille1.css" type="text/css" />
<link rel="stylesheet" href="css/master.css">

<?php
include("ongletNomDeconnexion.php");
 $libelle=isset($_POST['libelle']) ? $_POST['libelle'] : NULL;
 $modif=isset($_POST['modif']) ? $_POST['modif'] : NULL;
 $datefinfr=isset($_POST['datefinfr']) ? $_POST['datefinfr'] : NULL;
 $datedebfr=isset($_POST['datedebfr']) ? $_POST['datedebfr'] : NULL;
 $heuredeb=isset($_POST['heuredeb']) ? $_POST['heuredeb'] : NULL;
 $heurefin=isset($_POST['heurefin']) ? $_POST['heurefin'] : NULL;

 $lieu=isset($_POST['lieu']) ? $_POST['lieu'] : NULL;
 $participantsMiniisset=isset($_POST['participantsMini']) ? $_POST['participantsMini'] : NULL;
 $commentaire=isset($_POST['commentaire']) ? $_POST['commentaire'] : NULL;
 $idPoste=isset($_POST['idPoste']) ? $_POST['idPoste'] : NULL;


 if(($libelle && $libelle != "none") || $modif==2) {

   if(!$datefinfr || $datefinfr == "none") {
      $datefinfr = $datedebfr;
   }
   // On met les dates au format anglais
   $datefin=datefren($datefinfr);
   $datedeb=datefren($datedebfr);

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
		$result=mysqli_query($link,"INSERT INTO poste VALUES (NULL,\"$libelle\", '$datedeb', '$datefin', '$heuredeb', '$heurefin', \"$lieu\" ,'$participantsMini', \"$commentaire\");") or die("Query failed");

	        echo "<b>Insertion réalisée avec succès</b><br/><br/>Vous pouvez retourner à la page des <a href=\"./visuPoste.php?prochains=1\">Prochains postes</a> ,<br/>";
		echo "ou <a href=\"./ajouterPoste.php?libelle=none\">ajouter un autre poste</a>.<br/>";
	}
  }

 } else {


?>
  <FORM ENCTYPE="multipart/form-data" ACTION="ajouterPoste.php" METHOD="POST">

  <br/> Nom du poste : <input type="text" name="libelle" size=60 maxlength=60>
  <br/> Date début : <input type="text" name="datedebfr" size=10 maxlength=10>  (exemple : 28/02/2007)
  <br/> Date fin (si différente de date début) : <input type="text" name="datefinfr" size=10 maxlength=10> (exemple : 28/02/2007)
  <br/> Heure début : <input type="text" name="heuredeb" size=10 maxlength=10> (exemple: 08:30:00)
  <br/> Heure fin : <input type="text" name="heurefin" size=10 maxlength=10> (exemple: 17:00:00)
  <br/> Lieu : <input type="text" name="lieu" size=70 maxlength=70>
  <br/> Sauveteurs requis (au minimum) : <input type="text" name="participantsMini" size=3 maxlength=3> (saisissez un nombre uniquement)
  <br/> Commentaire : <textarea name="commentaire" cols=30 rows=4></textarea> (Autres informations utiles pour le poste)

  <INPUT TYPE="submit" VALUE=Enregistrer le poste></FORM>
<?php

}
?>

</html>
