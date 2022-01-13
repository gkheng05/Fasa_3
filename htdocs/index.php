<?php 
require_once("lib/dbManager.php");
if($dbManager->isPeserta() || $dbManager->isHakim() || $dbManager->isAdmin())
    redirect("dashboard.php");
else
    redirect("login.php");
?>