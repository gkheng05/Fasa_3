<?php require_once("lib/dbManager.php"); ?>

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
                    <a class="nav-link" href="/pengguna.php">Pengurusan Pengguna</a>
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