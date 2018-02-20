<?php

function menu($link,$admin,$idSession) {
?>
	<script type="text/javascript">
	<!--
	function changeEtat(id) {
		var menu= "menu"+id;
		if (document.getElementById(id).style.display=='block'){
			document.getElementById(id).style.display='none';
			document.getElementById(menu).innerHTML="<span class=\"titremenu2\">+</span> <b>"+id+"</b>";
		} else {
			document.getElementById(id).style.display='block';
			document.getElementById(menu).innerHTML="<span class=\"titremenu2\">-</span> <b>"+id+"</b>";
		}
	}



	function montre(id) {
		var d = document.getElementById(id);
		for (var i = 1; i<=10; i++) {
			if (document.getElementById('200'+i)) {document.getElementById('200'+i).style.display='none';}
		}
		if (d) {d.style.display='block';}
	}
	//-->
	</script>

	<div class="menu">
	<b class="titremenu">Formation</b>
		<dd id="smenu0">
			<center><a href="./news.php">Dernière Minute</a><br>
			<a href="./stagesNationaux.php">Stages Nationaux</a></center>
		</dd>
	<br/>
	<b class="titremenu">Postes de secours</b>
		<dd id="smenu1">
			<center><a href="./visuPoste.php?prochains=1">Prochains postes</a><br>
			<a href="./visuPoste.php?prochains=2">Anciens postes</a><br></center>
		</dd>

	<br>
	<b class="titremenu">Messagerie</b><br>
    	<dd id="smenu3"><center>

	<?php
	$messageQuery=mysqli_query($link,"SELECT COUNT(*) FROM `messages` WHERE id_desti=$idSession AND suppr='N' AND lu=0");
	if($myrowMessage=mysqli_fetch_row($messageQuery)){
		$nbMessage=$myrowMessage[0];
	} else {
		$nbMessage=0;
	}

	if($nbMessage==0){
		$newMsg="[New : $nbMessage]";
	} else $newMsg="<b>[New : $nbMessage]</b>";

    echo "<a href=\"./visuSauveteur.php\">Liste des Sauveteurs</a><br>";
	echo "<a href=\"./voirMsg.php\">Message(s) ";
	echo $newMsg;
	echo "</a><br>";
	?>

	<a href="./writeMsg.php">Ecrire un message</a><br>
	<a href="./preferences.php">Mes préférences</a></br>
	<a href="./modifierSonMdp.php">Modifier mon mot de passe</a></br></center>
	</dd>
	

<?php
	// On test si l'utilisateur est admin ou non
	if ($admin==2 || $admin==1) {

?>

<br>
	<b class="titremenu">Administration</b><br>
		<dd id="smenu4">
			<center>
			<a href="./ajouterPoste.php">Ajouter un poste</a><br>
			<a href="./ajoutSauveteur.php">Ajouter un sauveteur</a><br>
			<a href="./listeSauveteur.php">Liste des Sauveteurs</a><br>

<?php
	}

	echo"</center></dd>";
?>
	<br>
	<b class="titremenu">Autre</b><br>
	<dd id="smenu5"><center>
	<i><a href="./faq.php" class="titremenu">Foire Aux Questions</a></i>

	<br>
	<a href="mailto:gael_dot_colle_at_laposte_dot_net?subject='Page de visualisation des Photos'&body='Remplacer les _dot_ par . et _at_ par @ dans mon adresse mail.'">WebMaster</a>
	</center></dd>
	</div>
<?php
}
?>
