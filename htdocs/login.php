<?php
require_once ("lib/dbManager.php");

$showWrongPasswd = false; #default hide
$dbManager->init();
if($dbManager->isPeserta() || $dbManager->isHakim() || $dbManager->isAdmin()){
    redirect("dashboard.php");
}
if ($_SERVER['REQUEST_METHOD'] === "POST" && $_POST["username"] && $_POST["password"]) {
    //echo var_dump($res);
    if ($dbManager->getLoginCred($_POST["username"], $_POST["password"]))
        redirect("dashboard.php");
    else
        $showWrongPasswd = true;
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

    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.1.0/dist/css/coreui.min.css" rel="stylesheet" crossorigin="anonymous">

</head>

<body>
    <!-- <header class="c-header c-header-light">
      <span class="c-header-brand h2">Sistem Pengurusan Pertandingan Kuiz Bahasa Melayu Heng</span>
    </header> -->

    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <?php echo (($showWrongPasswd) ? "<div class=\"alert alert-danger\" role=\"alert\"> Salah Kata Laluan </div>" : ""); ?>
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-7 p-4 mb-0">
                            <form class="card-body" action="/login.php" method="POST">
                                <h2>Sistem Pengurusan Pertandingan</h2>
                                <p class="text-medium-emphasis">Kuiz Bahasa Melayu Heng</p>
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-user"></use>
                                        </svg></span>
                                    <input class="form-control" type="text" placeholder="Nama Pengguna" name="username">
                                </div>
                                <div class="input-group mb-4"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-lock-locked"></use>
                                        </svg></span>
                                    <input class="form-control" type="password" placeholder="Kata Laluan" name="password">
                                </div>
                                <div class="row justify-content-center py-2">
                                    <div class="col-md-auto">
                                        <button class="btn btn-primary px-4" type="submit">Log Masuk</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>