<?php 
require_once("lib/dbManager.php");
session_destroy();
redirect("login.php");
?>