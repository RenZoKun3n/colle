<?php
function datefren($day){
	if ($day =="") return "Nombre d'arguments incorrects";
	$tmp=0;

        if (preg_match("/([0-9]{4})(\/|\-)([0-9]{2})(\/|\-)([0-9]{2})/", $day, $matches)) $tmp = 1;
	else if (preg_match("/([0-9]{2})(\/|\-)([0-9]{2})(\/|\-)([0-9]{4})/", $day, $matches)) $tmp =2;

        if ($tmp==0){
        return "Date non reconnue";
        } else {
        switch ($tmp)
                {
                case 1:
                        $ch= $day[4];
                        $date = substr($day,8,2).$ch.substr($day,5,2).$ch.substr($day,0,4);
                        return $date;
                        break;

                case 2:
                        $ch= $day[2];
                        $date = substr($day,6,4).$ch.substr($day,3,2).$ch.substr($day,0,2);
                        return $date;
                        break;
                }
        }

}
function creation_vignette($image , $largeur_max , $hauteur_max , $source , $destination , $prefixe){
 if (!file_exists($image['tmp_name'])) {
  echo "L'image $image n'existe pas";
  exit;
  }

  // On verifie que l'extention du fichier est bien une image jpg, jpeg ou gif
  $ext=strtolower(strrchr($image['name'], '.'));
  if ($ext!=".jpg" AND $ext!=".jpeg" AND $ext!=".gif"){
  echo "<br>Votre image doit être un jpg, jpeg ou gif <br>";
  exit;
  }

  $size = getimagesize($image['tmp_name']);

  $largeur_src=$size[0];
  $hauteur_src=$size[1];

  //2ieme verification -> on verifie que le type du fichier est un jpg, jpeg ou gif
  // $size[2] -> type de l'image : 1 = GIF , 2 = JPG, JPEG
  if ($size[2]!=1 AND $size[2]!=2){
  echo "<br>Format non supporté<br>";
  exit;
  }

  if($size[2]==1){ // format gif
  $image_src=imagecreatefromgif($image['tmp_name']);
  }

  if($size[2]==2){ // format jpg ou jpeg
  $image_src=imagecreatefromjpeg($image['tmp_name']);
  }


  // on verifie que l'image source ne soit pas plus petite que l'image de destination
  if ($largeur_src>$largeur_max OR $hauteur_src>$hauteur_max){
  // si la largeur est plus grande que la hauteur
  if ($hauteur_src<=$largeur_src){
  $ratio=$largeur_max/$largeur_src;
  }else{
  $ratio=$hauteur_max/$hauteur_src;
  }
  }else{
  $ratio=1; // l'image créee sera identique à l'originale
  }

  $image_dest=imagecreatetruecolor(round($largeur_src*$ratio),round($hauteur_src*$ratio));
  imagecopyresized($image_dest, $image_src, 0, 0, 0, 0,round($largeur_src*$ratio), round($hauteur_src*$ratio), $largeur_src, $hauteur_src);

  if(!imagejpeg($image_dest, $destination.$prefixe.$image['name'])){
  echo "la création de la vignette a echouée pour l'image $image";
  exit;
  }
}

function jourSemaine($d){

	list($jour, $mois, $annee) = explode('-', $d);
	$timestamp = mktime (0, 0, 0, $mois, $jour, $annee);
	return date("w",$timestamp);
}

function supprimeMessage($link,$idMessage,$session){
	$result=mysqli_query($link,"UPDATE messages SET suppr='O' WHERE id_message=$idMessage AND id_desti=$session");
}


function supprimeParticipation($link,$idPoste,$idSauveteur){
	$result=mysqli_query($link,"DELETE FROM participe WHERE id_poste=$idPoste AND id_sauveteur=$idSauveteur");
}



function participation($link, $participe,$idPoste,$idSauveteur,$admin,$heureDeb,$heureFin){
	@session_start();
   	//$idSession=$_SESSION['id'];

	// Le sauveteur participe à un poste
	if($participe==1){
		$resultParticipe = mysqli_query($link,"SELECT * FROM participe WHERE id_poste=$idPoste AND id_sauveteur=$idSauveteur") or die("Select Participe failed");
		if (!mysqli_fetch_row($resultParticipe)) {

			// On inscrit la participation du sauveteur dans la babase
		        $requeteParticipation1="INSERT INTO participe VALUES (NULL,'$idPoste','$idSauveteur','$heureDeb','$heureFin');";
  			$result=mysqli_query($link,$requeteParticipation1) or die("Impossible de prendre en compte la participation : $requeteParticipation1");
		}
	}

	// Christian ou l'administrateur inscrit une participation à un poste
	if($participe==2 && ($admin==1 || $admin==2)){
		//Christian inscrit un participant
		$resultParticipe = mysqli_query($link,"SELECT * FROM participe WHERE id_poste=$idPoste AND id_sauveteur=$idSauveteur") or die("Select Participe2 failed");
		if (!mysqli_fetch_row($resultParticipe)) {

			// On inscrit la participation du sauveteur dans la babase
		        $requeteParticipation2="INSERT INTO participe VALUES (NULL,'$idPoste','$idSauveteur','$heureDeb','$heureFin');";
  			$result=mysqli_query($link,$requeteParticipation2) or die("Impossible de prendre en compte la participation : $requeteParticipation2");
		}
	}
}

function connectDB() {
	$link = mysqli_connect("127.0.0.1","root","","bdd") or die("Impossible de se connecter");
	return $link;
}


function footer() {
  //echo "<div id=\"footer\">";
  //		echo "<div id=\"foot_l\">\n";
  //		echo "<a href=\"mailto:gael_dot_colle_at_laposte_dot_net?subject='Page de visualisation des Photos'&body='Remplacer les _dot_ par . et _at_ par @ dans mon adresse mail.'\">WebMaster</a>";
  //	echo "</div>";

  //	echo "<div id=\"foot_r\">";
  //		echo "<a href=\"infos.php\">Informations concernant le site</a>";
			//echo "<a href=\"http://validator.w3.org/check/referer\">XHTML</a>";
  //	echo "</div>";
  //	echo "</div>";
}


?>
