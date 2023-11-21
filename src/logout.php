<?php

/**
 * ETML
 * Autrice:     Abid Fatima
 * Date: 2015   21.11.2023
 * Description: page permettant la déconnexion du compte logué
 */

session_start();
session_destroy();
header("Location: index.php");
die();
?>
