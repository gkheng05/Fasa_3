<?php 
    require_once("lib/dbManager.php");
    $dbManager->init();
    if(!$dbManager->isAdmin()){
        redirect("login.php");
    }else{
        if ($_SERVER['REQUEST_METHOD'] === "POST" && $_POST["nama"] && $_POST["kataLaluan"]) {
            $status = $dbManager->createHakim($_POST["nama"], $_POST["kataLaluan"]);
        }
    }
?>

<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/style.css" rel="stylesheet" />

    <title>Daftar Hakim</title>
</head>

<body>
    <div id="wrapper">
        <div class="overlay">

        </div>

        <?php require "lib/navBar.php" ?>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
                <span class="hamb-middle"></span>
                <span class="hamb-bottom"></span>
            </button>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1>Daftar Hakim</h1>
                        <?
                        if ($_SERVER['REQUEST_METHOD'] === "POST") {
                            if (!$status) {
                        ?>
                                <div class="alert alert-danger" role="alert">
                                    Salah info hakim
                                </div>
                            <? } else { ?>
                                <div class="alert alert-success" role="alert">
                                    Sudah muat naik info hakim
                                </div>
                        <? }
                        } ?>
                        <form action="/daftarHakim.php" method="POST">
                            <div class="input-group col-5 my-4">
                                <input type="text" class="form-control" placeholder="Nama Hakim" name="nama">
                            </div>
                            <div class="input-group col-5 my-4">
                                <input type="password" class="form-control" placeholder="Kata Laluan" name="kataLaluan">
                            </div>
                            <div class="input-group col-5 my-4">
                                <button class="btn btn-outline-secondary" type="submit">Muat Naik</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="/script.js"></script>
</body>