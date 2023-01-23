<?php
session_start();
$user_id = $_SESSION["user_id"];
$nama_lengkap = $_SESSION["nama_lengkap"];
$role = $_SESSION["role"];
date_default_timezone_set("Asia/Jakarta");
$tgl = date("Y-m-d");
$time = date("H:i:s");

include("../connection.php");
if (isset($_POST["logout"])) {
    session_destroy();
    header("location:../index.php");
};
// JUMLAH KARYAWAN
$sql = "SELECT * FROM users WHERE role = 'employee'";
$result = $db->query($sql);
$jumlah_karyawan = mysqli_num_rows($result);
// JUMLAH CLOCKIN
$sql = "SELECT jam_masuk FROM absensi WHERE tgl = '$tgl'";
$result = $db->query($sql);
$jumlah_data_clockin = mysqli_num_rows($result);
// JUMLAH CLOCKOUT
$sql = "SELECT jam_keluar FROM absensi WHERE tgl = '$tgl'";
$result = $db->query($sql);
$jumlah_data_clockout = mysqli_num_rows($result);
// Belum ClockIN
$emp_not_clockin = $jumlah_karyawan - $jumlah_data_clockin;
// Belum Clockout

$sql = "SELECT * FROM users JOIN absensi ON users.user_id = absensi.user_id WHERE absensi.jam_masuk IS NOT NULL AND absensi.tgl = '$tgl' AND absensi.jam_keluar IS NULL ";
$result_belum_clockout = $db->query($sql);
$emp_not_clockout = mysqli_num_rows($result_belum_clockout);
//  Sudah Pulang
$sql = "SELECT * FROM users JOIN absensi ON users.user_id = absensi.user_id WHERE absensi.jam_masuk IS NOT NULL AND absensi.jam_keluar IS NOT NULL AND absensi.tgl = '$tgl'";
$result_is_home = $db->query($sql);
$emp_home = mysqli_num_rows($result_is_home);


?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2ce69c7166.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dashboard-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Operator</title>
</head>

<body style="background-color:var(--bs-tertiary-bg)">
    <div class="container-admin">
        <div class="side-navbar" style="background-color: var(--bs-dark-bg-subtle);">
            <nav>
                <ul>
                    <li class="mb-4 d-flex "><a href="./index-admin.php" class="brand"><i class="fa-brands fa-drupal"></i>&nbsp; Mizu</a></li>
                    <li class="nav-item"><a href="./jumlah-karyawan.php" class="fw-semibold"><i class="fa-solid fa-users"></i>&nbsp;&nbsp;Jumlah Karyawan</a></li>
                    <li class="nav-item"><a href="#" class="fw-semibold"><i class="fa-solid fa-right-to-bracket"></i>&nbsp;&nbsp;Sudah ClockIn</a></li>
                    <li class="nav-item"><a href="./sudah-clockout.php" class="fw-semibold"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp;Sudah ClockOut</a></li>
                    <li class="nav-item"><a href="./additional-info.php" class="fw-semibold"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Additional Info</a></li>
                    <li class="nav-item"><a href="./edit-data.php" class="fw-semibold"><i class="fa-solid fa-user-gear"></i>&nbsp;&nbsp;Edit Data</a></li>
                </ul>
            </nav>
        </div>
        <div class="wrapper-admin" style="background-color:var(--bs-tertiary-bg)">
            <!-- NAVBAR -->
            <div class="navbar-admin">
                <nav>
                    <ul>
                        <li class="h-100 align-items-center">
                            <a href="./index-admin.php" class="title-admin" style="color:var(--bs-emphasis-color)">Admin</a>
                        </li>
                    </ul>
                    <div class="dropdown">
                        <button class="user-btn btn btn-sm dropdown-toggle" style="color: var(--bs-emphasis-color);
    background-color:var(--bs-body-bg) ;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <form action="" method="POST">
                                <li><button class="dropdown-item" style="background-color:var(--bs-danger-text); color : var(--bs-body-bg)" type="submit" name="logout">Logout</button></li>
                            </form>
                            <li><button class="dropdown-item" onclick="window.open('./print-table-clockin.php')">Print Table</button></li>
                        </ul>
                    </div>


                    <!-- SEARCH USERS -->
                    <form class="ms-3" action="search.php" method="POST">
                        <div class="input-navbar-admin">
                            <button name="search" style="color:var(--bs-emphasis-color); background-color:var(--bs-body-bg)" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <input name="search_input" type="text" placeholder="Cari : '102'" style="color:var(--bs-emphasis-color); background-color:var(--bs-body-bg)">
                        </div>
                    </form>


                    <!-- Dropdown MODE  -->
                    <div class="dropdown">
                        <button class="user-btn btn btn-sm dropdown-toggle" style="color: var(--bs-emphasis-color);
    background-color:var(--bs-body-bg) ;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-sun theme-icon-active" data-theme-icon-active="fa-sun"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button class="dropdown-item d-flex align-items-center " type="button" data-bs-theme-value="light">
                                    <i class="fa-solid fa-sun theme-icon-active me-2 " data-theme-icon="fa-sun"></i>
                                    Light
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item d-flex align-items-center " type="button" data-bs-theme-value="dark">
                                    <i class="fa-solid fa-moon theme-icon-active me-2 " data-theme-icon="fa-moon"></i>
                                    Dark
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item d-flex align-items-center " type="button" data-bs-theme-value="auto">
                                    <i class="fa-solid fa-circle-half-stroke theme-icon-active me-2 " data-theme-icon="fa--circle-half-stroke"></i>
                                    Auto
                                </button>
                            </li>
                        </ul>
                    </div>
                    <!-- DROPDOWN MODE -->
                </nav>
            </div>

            <div class="item-admin d-flex ">
                <div class="item-admin-start gap-4 d-flex flex-column justify-content-center align-items-center pb-4" style="width: 65%; height:auto">
                    <!-- DATA KARYAWAN -->
                    <div class="data-karyawan w-100">
                        <div class="output-karyawan d-flex gap-2" style="width:99%">
                            <!-- OUTPUT JUMLAH KARYAWAN  -->
                            <div class="h-auto p-4 rounded-2 ms-2" style="background-color:var(--bs-info-bg-subtle); color:var(--bs-info-text); border:1px solid var(--bs-info-border-subtle);width:430px">
                                <p class="fw-semibold"><i class="fa-solid fa-users"></i>&nbsp;&nbsp;Jumlah Karyawan</p>
                                <h4 style="color: var(--bs-info-text);">
                                    <?= $jumlah_karyawan; ?>
                                </h4>
                            </div>
                            <!-- OUTPUT JUMLAH KARYAWAN  -->
                            <div class="h-auto p-4 rounded-2" style="background-color: var(--bs-warning-bg-subtle); color:var(--bs-warning-text); border:1px solid var(--bs-warning-border-subtle);width:430px">
                                <!-- OUTPUT JUMLAH CLOCKOUT -->
                                <p class="fw-semibold"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp;Karyawan ClockOut</p>
                                <h4 style="color:var(--bs-warning-text)">
                                    <?= $jumlah_data_clockout ?>
                                </h4>
                                <!-- OUTPUT JUMLAH CLOCKOUT -->
                            </div>
                        </div>
                    </div>
                    <!-- TABEL DATA KARYAWAN -->
                    <div class="additional-item rounded-4 p-4 " style="width:95%; box-shadow: 10px 14px 0px 0px rgba(0,0,0,0.53);
        -webkit-box-shadow: 10px 14px 0px 0px rgba(0,0,0,0.53);
        -moz-box-shadow: 10px 14px 0px 0px rgba(0,0,0,0.53); background-color:var(--bs-light-bg-subtle);color:var(--bs-light-text);border:1px solid var(--bs-light-border-subtle);">

                        <h3 class="ms-3">Jumlah Karyawan</h3>

                        <table class="table table-striped ms-2 me-2 mt-2" style="width:98%">
                            <tr class="tr-header table-dark">
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIP</th>
                                <th>Role</th>
                                <th>Tanggal</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>

                            </tr>
                            <?php
                            include("../connection.php");

                            $user_id = $_SESSION["user_id"];

                            $sql = "SELECT * FROM users JOIN absensi ON users.user_id = absensi.user_id WHERE tgl = '$tgl' AND jam_masuk IS NOT NULL";
                            $result = $db->query($sql);

                            $no = 1;
                            while ($data = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $data["nama_lengkap"] . "</td>";
                                echo "<td>" . $data["user_id"] . "</td>";
                                echo "<td>" . $data["role"] . "</td>";
                                echo "<td>" . $data["tgl"] . "</td>";
                                echo  "<td>" . $data["jam_masuk"] . "</td>";
                                echo  "<td>" . $data["jam_keluar"] . "</td>";
                                echo "</tr>";
                            }



                            ?>


                        </table>
                    </div>
                </div>
                <div class="item-admin-end d-flex flex-column ms-1" style="width: 35%;  font-family: 'Open Sans', sans-serif;">
                    <div class="admin-profile p-5 d-flex flex-column align-items-center  rounded-2" style="width:95%; height:351px;color: var(--bs-light-text);background-color:var(--bs-light-bg-subtle);border:1px solid var(--bs-light-border-subtle)">
                        <div class="icon">
                            <h1><i class="fa-solid fa-headset fa-3x"></i></h1>
                        </div>
                        <h3 class="role fw-bold text-uppercase mt-3 fst-italic">
                            <?= $role ?>
                        </h3>
                        <p class="nama fw-bold">
                            <?= $nama_lengkap ?>
                        </p>
                        <i><?php
                            if (isset($_GET["message"])) {
                                echo $_GET["message"];
                            };
                            ?></i>

                    </div>
                    <!-- SISA CLOCKIN, CLOCKOUT DAN KARYAWAN YANG SUDAH PULANG -->
                    <div class="admin-status d-flex flex-column justify-content-evenly p-4 mt-2 rounded-2" style="width:95%; height:222.3px;background-color:var(--bs-body-color); color: var(--bs-body-bg); ">
                        <h4 style="color: var(--bs-body-bg);">Additional Status</h4>
                        <div class="sisa-clockin d-flex flex-column">
                            <div class="">
                                <i class="fa-solid fa-right-to-bracket"></i>&nbsp;<i class="fa-solid fa-x fa-2xs"></i>&nbsp;:&nbsp;<?= $emp_not_clockin ?>
                            </div>
                            <i class="fw-lighter opacity-50" style="color: var(--bs-body-bg);">Belum ClockIn</i>
                        </div>
                        <div class="sisa-clockout d-flex flex-column">
                            <div class="">
                                <i class="fa-solid fa-right-from-bracket"></i>&nbsp;<i class="fa-solid fa-x fa-2xs"></i>&nbsp;:&nbsp;<?= $emp_not_clockout ?>
                            </div>
                            <i class="fw-lighter opacity-50 fs-6" style="color: var(--bs-body-bg);">Belum ClockOut</i>
                        </div>
                        <div class="sudah-pulang d-flex flex-column">
                            <div class="">
                                <i class="fa-solid fa-house-chimney"></i>&nbsp;:&nbsp;<?= $emp_home ?>
                            </div>
                            <i class="fw-lighter opacity-50 fs-6" style="color: var(--bs-body-bg);">Sudah Pulang</i>
                        </div>

                    </div>


                </div>

            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        (() => {
            'use strict'

            const storedTheme = localStorage.getItem('theme')

            const getPreferredTheme = () => {
                if (storedTheme) {
                    return storedTheme
                }

                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
            }

            const setTheme = function(theme) {
                if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.setAttribute('data-bs-theme', 'dark')
                } else {
                    document.documentElement.setAttribute('data-bs-theme', theme)
                }
            }

            setTheme(getPreferredTheme())

            const showActiveTheme = theme => {
                const activeThemeIcon = document.querySelector('.theme-icon-active')
                const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
                const iconOfActiveBtn = btnToActive.querySelector('i').dataset.themeIcon

                document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
                    element.classList.remove('active')
                })

                btnToActive.classList.add('active')
                activeThemeIcon.classList.remove(activeThemeIcon.dataset.themeIconActive)
                activeThemeIcon.classList.add(iconOfActiveBtn)
                activeThemeIcon.dataset.iconActive = iconOfActiveBtn
            }

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (storedTheme !== 'light' || storedTheme !== 'dark') {
                    setTheme(getPreferredTheme())
                }
            })

            window.addEventListener('DOMContentLoaded', () => {
                showActiveTheme(getPreferredTheme())

                document.querySelectorAll('[data-bs-theme-value]')
                    .forEach(toggle => {
                        toggle.addEventListener('click', () => {
                            const theme = toggle.getAttribute('data-bs-theme-value')
                            localStorage.setItem('theme', theme)
                            setTheme(theme)
                            showActiveTheme(theme)
                        })
                    })
            })
        })()
    </script>
</body>

</html>