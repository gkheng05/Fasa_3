<!-- Sidebar -->
<?php require_once ("lib/dbManager.php"); ?>
<nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
    <ul class="nav sidebar-nav">
        <div class="sidebar-header mb-2">
            <div class="sidebar-brand">
                <h6 style="color: #ddd;">Sistem Pengerusan Pertandigan Kuiz BM Heng</h6>
            </div>
        </div>
        <li><a href="/dashboard.php">Laman Utama</a></li>
        <? if($dbManager->isPeserta()) { ?>
        <li><a href="/markah.php">Keputusan Sendiri</a></li>
        <? } ?>
        <? if($dbManager->isHakim()) { ?>
        <li><a href="/editMarkah.php">Edit Markah</a></li>
        <? } ?>
        <? if($dbManager->isAdmin()) { ?>
        <li><a href="/daftarPeserta.php">Daftar Peserta</a></li>
        <li><a href="/daftarHakim.php">Daftar Hakim</a></li>
        <li><a href="/pengguna.php">Pengguna</a></li>
        <? } ?>
        <li><a href="/logout.php">Log Keluar</a></li>
    </ul>
</nav>
<!-- /#sidebar-wrapper -->