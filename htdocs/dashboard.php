<?php
require_once("lib/dbManager.php");
$dbManager->init();
if (!$dbManager->checkLoggedIn())
    redirect("login.php");

$dataSet = $dbManager->getMarkahPurata();
?>
<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">



    <title>Keputusan Sendiri</title>
</head>

<body style="background-color: #CFD8DC;">
    <?php require "lib/navBar.php" ?>
    <div class="container my-5">
        <div class="row">
            <div class="col-12 mb-3">
                <h2>Selamat Datang, <?= $_SESSION["nama"] ?></h2>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart3"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js" integrity="sha256-Y26AMvaIfrZ1EQU49pf6H4QzVTrOI8m9wQYKkftBt4s=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/7cd63795dc.js" crossorigin="anonymous"></script>
    <script>
        const data = {
            type: 'bar',
            data: {
                labels: ['Bahagian A', 'Bahagian B', 'Bahagian C', 'Jumlah Markah'],
                datasets: [{
                    label: 'Markah Purata %',
                    data: [<?= implode(",", $dataSet) ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        const myChart = new Chart($('#myChart'), data);

        <?php $bhgA = $dbManager->getMarkahStatistik("A"); ?>
        const myChart2 = new Chart($('#myChart2'), {
            type: 'line',
            data: {
                labels: [<?= implode(",", $bhgA["label"]) ?>],
                datasets: [{
                    label: 'Bahagian A',
                    data: [<?= implode(",", $bhgA["value"]) ?>],
                    fill: false,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        <?php $bhgB = $dbManager->getMarkahStatistik("B"); ?>
        const myChart3 = new Chart($('#myChart3'), {
            type: 'line',
            data: {
                labels: [<?= implode(",", $bhgB["label"]) ?>],
                datasets: [{
                    label: 'Bahagian B',
                    data: [<?= implode(",", $bhgB["value"]) ?>],
                    fill: false,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        <?php $bhgC = $dbManager->getMarkahStatistik("C"); ?>
        const myChart4 = new Chart($('#myChart4'), {
            type: 'line',
            data: {
                labels: [<?= implode(",", $bhgC["label"]) ?>],
                datasets: [{
                    label: 'Bahagian C',
                    data: [<?= implode(",", $bhgC["value"]) ?>],
                    fill: false,
                    borderColor: 'rgba(255, 206, 86, 1)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>