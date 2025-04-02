<?php
require_once 'Session.php';

Session::destroy();
header("Location: authentification.php");
?>