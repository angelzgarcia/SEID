<?php
//sesion
session_start();

$_SESSION = array();

if(session_id() != "" ||
isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() -3600,'/');
    
}

session_destroy();

header("Location: ../acceso_DD/login.php");
exit;
?>