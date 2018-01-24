<!DOCTYPE html>
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/master.css">
</head>
<body class="index">

<div class="container-fluid cf1">


Vous êtes déja venu :
<br>
<FORM ENCTYPE="multipart/form-data" ACTION="index2.php" METHOD="POST">
</div>
<div class="container">
<div class="col-sm-2">

E-mail :
</div>
<div class="col-sm-10">

<input type="text" name="mail" size=43 maxlength=50>
</div>
</div>
<div class="container">

<div class="col-sm-2">
  Mot de passe :
</div>
<div class="col-sm-10">
  <input type="password" name="password" value="" size="43"/>
<br><br><INPUT TYPE="submit" VALUE="Valider"></FORM>
</div>
</div>

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
