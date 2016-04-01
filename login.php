<?php
session_start();
if( ( isset($_POST['login'])==false ) && ( isset($_POST['pass'])==false ) )
{
  header("Location: index.php");
  exit;
}

$login=$_POST['login'];
$password=$_POST['pass'];
require_once("connect.php");
//Łączenie się z bazą

$polonczenie= new mysqli($host,$user,$pass,$base);
if($polonczenie->connect_error)//sprawdzam czy nie ma errorów
{
  echo "ERROR NUMBER:".$polonczenie->connect_errno;
}
else
{
  $return=$polonczenie->query("SELECT * FROM user WHERE user='$login'");
  //Sprawdzam czy jest taki uzytkownik w bazie potam czy dane sie zgadzają
  if($return->num_rows==1)
  {

      $anwers=$return->fetch_assoc();

      if(password_verify($password,$anwers['pass']))
        {
          //user przechodzi dalej jesli hasła sie zgadzają
          $_SESSION['login']=true;
          header("Location: home.php");

        }
    else
    {
      //jesli nie są poprawnw generuje wiadomość 
       header("Location: index.php");
    $_SESSION['bad']='<div class="bad" >Hasło lub login są nie poprawne </div>';
    }
    }
    else
    {
       header("Location: index.php");
    $_SESSION['bad']='<div class="bad" >Hasło lub login są nie poprawne </div>';
    }
  }







 ?>
