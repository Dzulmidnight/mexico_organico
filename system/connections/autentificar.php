<?php
include ("conexion.php");
mysql_select_db($database, $conectar);

if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
  {
    if (PHP_VERSION < 6) {
      $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }

    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;    
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
        break;
      case "date":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }
}

if(isset($_POST['username'])){
  // LOGIN ADMINISTRADOR

    $loginUsername=$_POST['username'];
    $password=$_POST['password'];
    $MM_fldUserAuthorization = "clase";
    $MM_redirectLoginSuccess = "../administrador/index.php";
    $MM_redirectLoginFailed = "../../login.php?error=si";
    $MM_redirecttoReferrer = false;

    $loginUsername = $_POST['username'];
    $password = $_POST['password'];


      $LoginRS__query=sprintf("SELECT * FROM usuario WHERE username=%s AND password=%s",
      GetSQLValueString($loginUsername, "text"), 
      GetSQLValueString($password, "text")); 
       
      $LoginRS = mysql_query($LoginRS__query, $conectar) or die(mysql_error());
      $loginFoundUser = mysql_num_rows($LoginRS);

      if ($loginFoundUser) {
        
        $loginStrGroup  = mysql_fetch_assoc($LoginRS);
        
      if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
     
      session_start();
        $_SESSION["idusuario"] = $loginStrGroup['idusuario'];
        $_SESSION["clase"] = $loginStrGroup['clase'];
        $_SESSION['username'] = $loginUsername;     
        $_SESSION["autentificado"] = true;
        $_SESSION["nombre"] = $loginStrGroup['nombre'];
        $_SESSION["clase_usuario"] = $_POST['clase_usuario'];
        //$_SESSION["email"] = $loginStrGroup['email'];

        if (isset($_SESSION['PrevUrl']) && false) {
          $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];  
        }
        header("Location: " . $MM_redirectLoginSuccess );
      }
      else {
        $_SESSION["autentificado"] = false;
        header("Location: ". $MM_redirectLoginFailed );
      }


  //TERMINA LOGIN ADMINISTRADOR

  // INICIA LOGIN ORGANIZACION
  if($_POST['clase_usuario'] == "organizacion"){
    $loginUsername=$_POST['username'];
    $password=$_POST['password'];
    $MM_fldUserAuthorization = "clase";
    $MM_redirectLoginSuccess = "../system/organizacion/index.php";
    $MM_redirectLoginFailed = "../login.php?error=si";
    $MM_redirecttoReferrer = false;

    $loginUsername = $_POST['username'];
    $password = $_POST['password'];


      $LoginRS__query=sprintf("SELECT * FROM organizacion WHERE username=%s AND password=%s",
      GetSQLValueString($loginUsername, "text"), 
      GetSQLValueString($password, "text")); 
       
      $LoginRS = mysql_query($LoginRS__query, $conectar) or die(mysql_error());
      $loginFoundUser = mysql_num_rows($LoginRS);

      if ($loginFoundUser) {
        
        $loginStrGroup  = mysql_fetch_assoc($LoginRS);
        
      if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
     
      session_start();
        $_SESSION["idorganizacion"] = $loginStrGroup['idorganizacion'];
        $_SESSION["clase"] = $loginStrGroup['clase'];
        $_SESSION['username'] = $loginUsername;     
        $_SESSION["autentificado"] = true;
        $_SESSION["organizacion"] = $loginStrGroup['organizacion'];
        $_SESSION["clase_usuario"] = $_POST['clase_usuario'];
        //$_SESSION["email"] = $loginStrGroup['email'];

        if (isset($_SESSION['PrevUrl']) && false) {
          $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];  
        }
        header("Location: " . $MM_redirectLoginSuccess );
      }
      else {
        $_SESSION["autentificado"] = false;
        header("Location: ". $MM_redirectLoginFailed );
      }

  }
  // TERMINA LOGIN ORGANIZACION

}



?>

