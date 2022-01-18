<?php
require_once("lib/dbManager.php");
$dbManager->init();

if ($dbManager->isAdmin()) {
    //echo var_dump($dbManager->isPeserta());
    //one action at once
    if (isset($_POST["deletePengguna"])) {
        try {
            $status = $dbManager->deletePengguna($_POST["deletePengguna"]);
        } catch (Exception $e) {
            $status = false;
        }
        $message = ($status) ? "Berjaya menghapuskan pengguna ini" : "Tidak boleh menghapuskan pengguna";
    } else if (isset($_POST["idPengguna"]) && $_POST["idPengguna"] != -1) {
        try {
            $status = $dbManager->editPengguna($_POST["idPengguna"], $_POST["emelPengguna"], $_POST["kataLaluanPengguna"]);
            switch ($_POST["perananPengguna"]) {
                case 1:
                    $status &= $dbManager->editPeserta($_POST["idPengguna"], $_POST["namaPengguna"], $_POST["alamatPeserta"], $_POST["icPeserta"], $_POST["telefonPeserta"]);
                    break;
                case 2:
                    $status &= $dbManager->editHakim($_POST["idPengguna"], $_POST["namaPengguna"]);
                    break;
                case 6:
                    $status &= $dbManager->editAdmin($_POST["idPengguna"], $_POST["namaPengguna"]);
                    break;
            }
        } catch (Exception $e) {
            $status = false;
        }

        $message = ($status) ? "Berjaya edit pengguna ini" : "Tidak boleh edit pengguna ini";
    } else if (isset($_POST["emelPengguna"], $_POST["kataLaluanPengguna"], $_POST["namaPengguna"], $_POST["perananPengguna"])) {
        try {
            switch ($_POST["perananPengguna"]) {
                case 1:
                    $status = $dbManager->createPeserta($_POST["emelPengguna"], $_POST["kataLaluanPengguna"], $_POST["namaPengguna"], $_POST["alamatPeserta"], $_POST["icPeserta"], $_POST["telefonPeserta"]);
                    break;
                case 2:
                    $status = $dbManager->createHakim($_POST["emelPengguna"], $_POST["kataLaluanPengguna"], $_POST["namaPengguna"]);
                    break;
                case 6:
                    $status = $dbManager->createAdmin($_POST["emelPengguna"], $_POST["kataLaluanPengguna"], $_POST["namaPengguna"]);
                    break;
            }
        } catch (Exception $e) {
            $status = false;
        }

        $message = ($status) ? "Berjaya membuat pengguna baharu" : "Tidak boleh membuat pengguna baharu";
    }

    if (isset($_POST["cariNamaPengguna"]) || isset($_POST["cariPerananPengguna"])) {
        $dataSet = $dbManager->searchBy($_POST["cariNamaPengguna"], $_POST["cariPerananPengguna"]);
    } else {
        $dataSet = $dbManager->getAllUsers();
    }
} else {
    redirect("login.php");
}
?>

<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/7cd63795dc.js" crossorigin="anonymous"></script>

    <title>Laman Utama</title>
</head>

<body style="background-color: #CFD8DC;">

    <?php require("lib/navBar.php"); ?>

    <div class="container my-5">
        <form action="/pengguna.php" method="POST">
            <div class="modal fade" id="daftarPengguna" tabindex="1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pengguna</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="formDaftarPengguna">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="emelPengguna">Emel</label>
                                        <input type="email" class="form-control" id="emelPengguna" name="emelPengguna" placeholder="abc@gmail.com" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="kataLaluanPengguna">Kata Laluan</label>
                                        <input type="password" class="form-control" id="kataLaluanPengguna" name="kataLaluanPengguna" placeholder="Kata Laluan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namaPengguna">Nama</label>
                                    <input type="text" class="form-control" id="namaPengguna" name="namaPengguna" placeholder="Ali" required>
                                </div>
                                <div id="infoPeserta">
                                    <div class="form-group">
                                        <label for="alamatPeserta">Alamat</label>
                                        <input type="text" class="form-control" id="alamatPeserta" name="alamatPeserta" placeholder="5, Jalan Rambutan, Tanjong Bungah, 11200" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefonPeserta">Telefon</label>
                                        <input type="tel" class="form-control" id="telefonPeserta" name="telefonPeserta" placeholder="0123456789" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="icPeserta">NRIC</label>
                                        <input type="text" class="form-control" id="icPeserta" name="icPeserta" placeholder="050101070999" required>
                                    </div>
                                </div>
                                <div id="pilihanPeranan" class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="perananPengguna" id="pilihanPeserta" value=1 checked>
                                        <label class="form-check-label" for="pilihanPeserta">Peserta</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="perananPengguna" id="pilihanHakim" value=2>
                                        <label class="form-check-label" for="pilihanHakim">Hakim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="perananPengguna" id="pilihanAdmin" value=6>
                                        <label class="form-check-label" for="pilihanAdmin">Admin</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btnDaftarPengguna" type="submit" class="btn btn-primary">Daftar</button>
                        </div>
                        <input type="hidden" id="idPengguna" name="idPengguna">
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col">
                <?php if (isset($status)) { ?>
                    <div class="alert <?= ($status) ? "alert-success" : "alert-danger" ?>" role="alert">
                        <?= $message ?>
                    </div>
                <?php } ?>

                <form class="row justify-content-between align-content-center my-3" action="/pengguna.php" method="POST">
                    <div class="col-4 mx-3">
                        <h4>Pengguna</h4>
                    </div>

                    <div class="col-4 input-group">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Cari Pengguna" name="cariNamaPengguna">
                        <div class="input-group-append">
                            <select class="custom-select" name="cariPerananPengguna">
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
                            <th scope="col">Emel Pengguna</th>
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
                                <td><?= $row["nama"] ?></td>
                                <td><?= $row["emel"] ?></td>
                                <td><?= $dbManager->getPeranan($row["peranan"]) ?></td>
                                <td>
                                    <div class="row justify-content-around mx-1">
                                        <form action="/pengguna.php" method="POST">
                                            <?php
                                            $args = array($row['peranan'], $row['id'], $row['emel'], $row['nama']);
                                            if ($row['peranan'] == 1)
                                                array_push($args, $row['alamatPeserta'], $row['telefonPeserta'], $row['noicPeserta']);
                                            ?>
                                            <button class="btn btn-secondary" type="button" onclick="showForm(false, '<?= implode('\',\'', $args) ?>')">
                                                <i class="fa fa fa-pencil fa-lg" aria-hidden="true"></i>
                                            </button>
                                            <button class="btn btn-secondary" type="submit">
                                                <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                                            </button>
                                            <input type="hidden" name="deletePengguna" value="<?= $row["id"] ?>" />
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-secondary" onclick="showForm(true, '1')">Daftar Pengguna Baru</button>
            </div>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
        $('input[name="perananPengguna"]').change(function() {
            if (this.value !== '1') {
                $("#infoPeserta").attr("hidden", true);
                $("#telefonPeserta").val("");
                $("#alamatPeserta").val("");
                $("#icPeserta").val("");
                $("#infoPeserta input").removeAttr("required");
            } else {
                $("#infoPeserta").removeAttr("hidden");
                $("#infoPeserta input").attr("required", true)
            }
        });

        function showForm(showPeranan, peranan, id = "", emel = "", nama = "", alamat = "", telefon = "", nric = "") {
            if (showPeranan === true)
                $("#pilihanPeranan").removeAttr("hidden");
            else
                $("#pilihanPeranan").attr("hidden", true);

            switch (peranan) {
                case "1":
                    $('input[name="perananPengguna"]')[0].click();
                    break;
                case "2":
                    $('input[name="perananPengguna"]')[1].click();
                    break;
                case "6":
                    $('input[name="perananPengguna"]')[2].click();
                    break;
            }
            //$('input[name="perananPengguna"]').val(peranan);
            if (id)
                $("#idPengguna").val(id);
            else
                $("#idPengguna").val(-1);
            $("#emelPengguna").val(emel);
            $("#namaPengguna").val(nama);
            $("#telefonPeserta").val(telefon);
            $("#alamatPeserta").val(alamat);
            $("#icPeserta").val(nric);

            $('#daftarPengguna').modal("show");
        }
    </script>
</body>