<?php
require_once("lib/dbManager.php");
$dbManager->init();

if ($dbManager->isAdmin()) {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ($_POST["deletePengguna"] && $_POST["deletePerananPengguna"]) {
            $dbManager->deletePengguna($_POST["deletePengguna"], $_POST["deletePerananPengguna"]);
            $dataSet = $dbManager->getAllUsers();
        } else
            $dataSet = $dbManager->searchBy($_POST["namaPengguna"], $_POST["perananPengguna"]);
    }else
        $dataSet = $dbManager->getAllUsers();
}
?>

<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/style.css" rel="stylesheet" />

    <title>Laman Utama</title>
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
                        <form class="row justify-content-between align-content-center my-3" action="/pengguna.php" method="POST">
                            <div class="col-4 mx-3">
                                <h4>Pengguna</h4>
                            </div>
                            <div class="col-4 input-group">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                                <input type="text" class="form-control" placeholder="Cari Pengguna" name="namaPengguna">
                                <div class="input-group-append">
                                    <select class="custom-select" name="perananPengguna">
                                        <option value="0" selected>Pilihan</option>
                                        <option value="1">Peserta</option>
                                        <option value="2">Hakim</option>
                                        <option value="6">Admin</option>
                                    </select>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                </div>
                            </div>
                        </form>

                        <table class="table table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Pengguna</th>
                                    <th scope="col">Peranan Pengguna</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($dataSet)
                                    foreach ($dataSet as $index => $row) {
                                ?>
                                    <tr>
                                        <th scope="row"><?= $index + 1 ?></th>
                                        <td><?= $row[0] ?></td>
                                        <td><? switch ($row[1]) {
                                                case 1:
                                                    echo "PESERTA";
                                                    break;
                                                case 2:
                                                    echo "HAKIM";
                                                    break;
                                                case 6:
                                                    echo "ADMIN";
                                                    break;
                                            } ?></td>
                                        <td>
                                            <div class="row justify-content-around">
                                                <form action="/pengguna.php" method="POST">
                                                    <button class="btn btn-secondary" type="submit">
                                                        <span class="fa fa-trash-o fa-lg" aria-hidden="true"></span>
                                                    </button>
                                                    <input type="hidden" name="deletePengguna" value="<?= $row[0] ?>" />
                                                    <input type="hidden" name="deletePerananPengguna" value=<?= $row[1] ?> />
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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