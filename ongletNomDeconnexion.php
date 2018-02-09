<?php
	$nomSession=$_SESSION['nom'];
	$prenomSession=$_SESSION['prenom'];
	$avatar=$_SESSION['lienAvatar'];

	echo "<div class='nomDeconnexion'> <img src=\"$avatar\" alt=\"avatar\" height=\"35px\" width=\"35px\" > $nomSession $prenomSession | <a href='deconnexion.php'>Déconnexion</a></div>";


?>


<!--<img src="" alt="" height="">
 alt='avatar' height='25px' width='25px'-->
