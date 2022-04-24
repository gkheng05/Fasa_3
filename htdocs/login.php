<?php
require_once("lib/dbManager.php");
require_once("lib/components.php");

$status = null; #default hide
$message = null;
$dbManager->init();

if ($dbManager->isPeserta() || $dbManager->isHakim() || $dbManager->isAdmin()) {
    redirect("dashboard.php");
}

if (isset($_POST["action"])) {
    //echo var_dump($res);
    switch ($_POST["action"]) {
        case "login": {
                if ($_POST["username"] && $_POST["password"]) {
                    if ($dbManager->getLoginCred($_POST["username"], $_POST["password"]))
                        redirect("dashboard.php");
                    else {
                        $status = false;
                        $message = "Salah Kata Laluan";
                    }
                }
                break;
            }
        case "daftar": {
                $res = handleDaftarPenggunaRequest();
                //var_dump($res);
                $status = $res["status"];
                $message = $res["message"];

                break;
            }
    }
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Log Masuk</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/7cd63795dc.js" crossorigin="anonymous"></script>
    
</head>

<body>
    <!-- <header class="c-header c-header-light">
      <span class="c-header-brand h2">Sistem Pengurusan Pertandingan Kuiz Bahasa Melayu Heng</span>
    </header> -->


    <div class="container-fluid d-flex align-items-center" style="min-height: 100vh;">

        <div class="col-3 mx-auto">
            <?= displayMessage($message, $status) ?>
            <div class="card p-4">
                <form class="card-body" action="/login.php" method="POST">
                    <h2>Sistem Pengurusan Pertandingan</h2>
                    <p class="text-medium-emphasis">Kuiz Bahasa Melayu Heng</p>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-solid fa-user"></i>
                        </span>
                        <input class="form-control" type="text" placeholder="Nama Pengguna" name="username">
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text">
                            <i class="fa fa-solid fa-key"></i>
                        </span>
                        <input class="form-control" type="password" placeholder="Kata Laluan" name="password">
                    </div>
                    <div class="row justify-content-center py-2">
                        <div class="col-md-auto">
                            <button class="btn btn-primary px-4" type="submit">Log Masuk</button>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="login" />
                </form>

                <div class="row justify-content-center pt-4">
                    <div class="col-md-auto">
                        <a class="text-medium-emphasis" href="#" onclick="$('#daftarPengguna').modal('show'); event.preventDefault();">Daftar Sebagai Peserta</a>
                    </div>
                </div>
            </div>
        </div>


        <form action="/login.php" method="POST">
            <?= createDaftarModal(true); ?>
            <input type="hidden" name="action" value="daftar" />
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>

    </script>

</body>

</html>