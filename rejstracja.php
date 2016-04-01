<?php
session_start();
if((isset($_POST['login']))&&(isset($_POST['passwordV2']))&&(isset($_POST['password']))&&(isset($_POST['email']))&&(isset($_POST['name'])))
//^sprawdzan czy uzytkownik juz wypelnił inputy
{
//Odbieram dane
$nick=htmlentities($_POST['login']);
$name=htmlentities($_POST['name']);
$email=htmlentities($_POST['email']);
$password=$_POST['password'];//pod zmienną "$pass" jest już hasło do bazy danych!!!!!!!!
$passwordV2=$_POST['passwordV2'];
//Sanityzacja && Validacja
$good=true;
if($nick!=$_POST['login'])
{
  $good=false;
$_SESSION['bad_nick']='<div class="bad">Twój nick może zawierać tylko: Litery, Cyfry i kropki </div>';
}
if($name!=$_POST['login'])
{
    $good=false;
$_SESSION['bad_name']='<div class="bad">Twoje imie może zawierać tylko: Litery, Cyfry i kropki </div>';
}
if(filter_var($email, FILTER_VALIDATE_EMAIL)==false)
{
$_SESSION['bad_email']='<div class="bad">Ten e-mial nie jest poprawny </div>';

  $good=false;
}
if(strlen($password)<8)
{
  $_SESSION['bad_pass']='<div class="bad">Hasło musi miec minimalnie 8 znaków </div>';

    $good=false;
}
if($password!=$passwordV2)

  {
  $_SESSION['bad_pass']='<div class="bad">Hasła nie są zgodne </div>';

    $good=false;
  }
//jesli wszystko jest ok
  if($good==true)
    {
        require_once("connect.php");
      $polonczenie = new mysqli($host,$user,$pass,$base);
      if($polonczenie->connect_error)
      {
        echo "ERROR NUMBER: ".$polonczenie->connect_errno;
      }
      else
      {
      $polonczenie->query("INSERT INTO user VALUES(NULL,'".$nick."','".password_hash($password,PASSWORD_DEFAULT)."','".$email."','".$name."')");
      }


    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <title>Stwoz darmowe konto </title>
</head>
<body>
  <form method="post">
    Nick<br/>
  <input type="text" name="login"><br/>
  <?php
   if(isset($_SESSION['bad_nick']))
      echo $_SESSION['bad_nick'];
      unset($_SESSION['bad_nick']);
   ?>
  Imie<br/>
  <input type="text" name="name"><br/>
  <?php
   if(isset($_SESSION['bad_name']))
      echo $_SESSION['bad_name'];
      unset($_SESSION['bad_name']);
   ?>
  Adres e-mail<br/>
  <input type="text" name="email"><br/>
  <?php
   if(isset($_SESSION['bad_email']))
      echo $_SESSION['bad_email'];
      unset($_SESSION['bad_email']);
   ?>
  Hasło<br/>
  <input type="password" name="password"><br/>
  <?php
   if(isset($_SESSION['bad_pass']))
      echo $_SESSION['bad_pass'];
      unset($_SESSION['bad_pass']);
   ?>
  Powtórz hasło<br/>
  <input type="password" name="passwordV2"><br/>
  <?php
   if(isset($_SESSION['bad_pass']))
      echo $_SESSION['bad_pass'];
      unset($_SESSION['bad_pass']);
   ?>
  <input type="submit" value="zarejstruj sie"><br/>
</form>
</body>
</html>
