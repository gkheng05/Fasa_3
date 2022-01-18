<!-- Sidebar -->
<?php require_once("lib/dbManager.php"); ?>
<!-- <nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
    <ul class="nav sidebar-nav">
        <div class="sidebar-header mb-2">
            <div class="sidebar-brand">
                <h6 style="color: #ddd;">Sistem Pengerusan Pertandigan Kuiz BM Heng</h6>
            </div>
        </div>
        <li><a href="/dashboard.php">Laman Utama</a></li>
        <? if ($dbManager->isPeserta()) { ?>
        <li><a href="/markah.php">Keputusan Sendiri</a></li>
        <? } ?>
        <? if ($dbManager->isHakim()) { ?>
        <li><a href="/editMarkah.php">Edit Markah</a></li>
        <? } ?>
        <? if ($dbManager->isAdmin()) { ?>
        <li><a href="/daftarPeserta.php">Daftar Peserta</a></li>
        <li><a href="/daftarHakim.php">Daftar Hakim</a></li>
        <li><a href="/pengguna.php">Pengguna</a></li>
        <? } ?>
        <li><a href="/logout.php">Log Keluar</a></li>
    </ul>
</nav> -->
<!-- /#sidebar-wrapper -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Sistem Pengurusan Quiz BM</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/dashboard.php">Laman Utama</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/skor.php">Skor Peserta</a>
            </li>
            <?php if ($dbManager->isPeserta()) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="/markah.php">Keputusan Sendiri</a>
                </li>
            <?php } ?>
            <?php if ($dbManager->isAdmin()) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="/pengguna.php">Pengguna</a>
                </li>
            <?php } ?>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true">
                    <span style="font-size: 16px;">
                        <i class="fas fa-user-circle"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/logout.php">Log Keluar</a>
                </div>
            </li>
        </ul>
    </div>
</nav>