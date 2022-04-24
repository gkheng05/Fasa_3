<?php
function displayMessage(string $message = null, bool $status = null)
{
    ob_start();
    if ($status !== null && $message !== null) {
?>
        <div class="alert <?= ($status) ? "alert-success" : "alert-danger" ?>" role="alert">
            <?= $message ?>
        </div>
<?php
    }
    return ob_get_clean();
}
?>

<?php
function handleDaftarPenggunaRequest(int $maxPeranan = 1)
{
    $status = null;
    $message = null;
    global $dbManager;

    if (isset($_POST["idPengguna"]) && $_POST["idPengguna"] != -1) {
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
        $status = false;

        if ($_POST["perananPengguna"] <= $maxPeranan)
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
            }

        $message = ($status) ? "Berjaya membuat pengguna baharu" : "Tidak boleh membuat pengguna baharu";
    }

    return array("message" => $message, "status" => $status);
}
?>

<?php
function createDaftarModal(bool $pesertaOnly = false)
{
    ob_start();
?>
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

                        <div id="pilihanPeranan" class="form-group" <?= ($pesertaOnly) ? "hidden" : "" ?>>
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
                <input type="hidden" id="idPengguna" name="idPengguna" value="-1">
            </div>
        </div>
    </div>

<?php
    return ob_get_clean();
}
?>