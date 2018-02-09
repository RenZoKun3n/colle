<?php
	$nomSession=$_SESSION['nom'];
	$prenomSession=$_SESSION['prenom'];

	echo "<div class='nomDeconnexion'>$nomSession $prenomSession | <a href='deconnexion.php'>Déconnexion</a></div>";


?>
