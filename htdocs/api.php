<?php 
    require_once("lib/dbManager.php");
    $dbManager->init();

    if($dbManager->isAdmin()){
        #echo file_get_contents('php://input');
        $data = json_decode(file_get_contents('php://input'));
        $ret = new stdClass();
        #echo var_dump($data);
        switch($data->query){


            default:
                $ret->error="Invalid Query";
        }
        echo json_encode($ret);
    }
