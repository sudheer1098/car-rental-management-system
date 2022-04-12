<?php
// Initialize the session.
session_start();

// Unset all of the session variables.
unset($_SESSION['sess_category']);
unset($_SESSION['sess_email']);
unset($_SESSION['sess_name']);

// delete the session cookies
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Finally destroying the session.
session_destroy();
header('Location: login.php');
exit();
?>
