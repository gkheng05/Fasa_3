<?php
require_once("lib/dbManager.php");
$dbManager->init();
if (!$dbManager->isPeserta() || !($res = $dbManager->getMarkahPeserta()))
    redirect("login.php");
?>
<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/7cd63795dc.js" crossorigin="anonymous"></script>

    <title>Keputusan Sendiri</title>
</head>

<body style="background-color: #CFD8DC;">
    <?php require "lib/navBar.php" ?>
    <div class="container my-5">
        <div class="row">
            <div class="col">
                <h1>Markah</h1>
                <h4>Nama Peserta : <?= $dbManager->getNamaPengguna() ?></h4>
                <div class="row justify-content-between mt-5">
                    <div class="col-2">
                        <h3>Bahagian A</h3>
                    </div>
                    <div class="col-1">
                        <h3><?= $res[0] ?></h3>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-between mt-4">
                    <div class="col-2">
                        <h3>Bahagian B</h3>
                    </div>
                    <div class="col-1">
                        <h3><?= $res[1] ?></h3>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-between mt-4 ">
                    <div class="col-2">
                        <h3>Bahagian C</h3>
                    </div>
                    <div class="col-1">
                        <h3><?= $res[2] ?></h3>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-between mt-5 ">
                    <div class="col-3">
                        <h3>Jumlah Markah</h3>
                    </div>
                    <div class="col-1">
                        <h3><?= $res[3] ?></h3>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>