<?php
    include "config.php";
    session_start(); #Unsetting the session
    session_unset();
    session_destroy();
    header("Location: $site"."/Admin");
?>