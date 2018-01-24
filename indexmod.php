<?php
session_start();

if(!isset($_POST['mail']))$_POST['mail']="none";
if(!isset($_POST['password']))$_POST['password']="";

$mail=$_POST['mail'];
$password=$_POST['password'];

if (!$mail || $mail=="none") {
?>
<html>
<head>
<title> Connexion sur le site </title>
</head>
<body>

Vous êtes déja venu :
<br>
<FORM ENCTYPE="multipart/form-data" ACTION="index2.php" METHOD="POST">
<br>E-mail : <input type="text" name="mail" size=43 maxlength=50>
<br>Mot de passe : <input type="password" name="password" value="" size="24"/>
<INPUT TYPE="submit" VALUE="Valider"></FORM>

<h2></u>Si vous rencontrez des problèmes pour vous inscrire aux postes, <br/>
utilisez de préférence le navigateur <a href="http://www.mozilla-europe.org/fr/firefox/"<b>Mozilla Firefox</b></a></u></h2>
<a href="http://www.mozilla-europe.org/fr/firefox/"><img src="surfez-mieux.png"></a>

<br><br><br><br><br>
Nouveau venu, cliquez <a href="./connexion.php">ici</a>.

</body>
</html>
<?php
}
?>
