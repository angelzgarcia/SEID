<?php
// session_start();

// $_SESSION = array();

// if (
//     session_id() != "" ||
//     isset($_COOKIE[session_name()])
//     )
// {
//     setcookie(session_name(), '', time() -3600,'/');
// }

session_start();
session_unset();
session_destroy();
header("Location: ./views/login-qr");
exit();
