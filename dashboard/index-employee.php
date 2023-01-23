<?php
session_start();
$user_id = $_SESSION["user_id"];
$nama_lengkap = $_SESSION["nama_lengkap"];
$role = $_SESSION["role"];
$status = $_SESSION["status"];
if (!isset($user_id) && !isset($nama_lengkap) && !isset($role) && !isset($status)) {
    header("location:../index.php?message=Silahkan Login terlebih dahulu");
}
if (isset($status) && $status != "login") {
    // Jika status isset/ ada dan statusnya bukan login maka pindahkan kehalaman login
    header("location:../login.php?message=silahkan login terlebih dahulu");
}
if (isset($_POST["logout"])) {
    session_destroy();
    header("location:../index.php?message=Terima kasih atas kinerja anda");
}
if (isset($role) && $role == "admin") {
    header("location:index-admin.php?message=Terima kasih atas kinerja anda");
}
date_default_timezone_set("Asia/Jakarta");
$tgl = date("Y-m-d");
$time = date("H:i:s");
include("../connection.php");
if (isset($_POST["clockout"])) {
    $sql = "UPDATE absensi SET jam_keluar= '$time' WHERE user_id='$user_id' AND tgl='$tgl'";
    $clockout = $db->query($sql);
    if ($clockout == TRUE) {
        session_destroy();
        header("location:../index.php?message=Terimakasih dengan kinerja hari ini!!");
    } else {
        echo "maaf terjadi kesalahan";
    }
};
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
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

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
    <title>Dashboard</title>
</head>

<body>
    <div class="container-employee w-100 h-100" style="box-sizing:border-box;">
        <div class="side-navbar" style="background-color: var(--bs-dark-bg-subtle);">
            <nav>
                <ul>
                    <li class="mb-4 d-flex "><a href="#" class="brand"><i class="fa-brands fa-drupal"></i>&nbsp; Mizu</a></li>
                </ul>
            </nav>
        </div>


        <div class="wrapper-admin" style="background-color:var(--bs-tertiary-bg)">
            <!-- NAVBAR -->
            <div class="navbar-admin">
                <nav>
                    <ul>
                        <li class="h-100 align-items-center">
                            <a href="#" class="title-admin" style="color:var(--bs-emphasis-color)">Employee</a>
                        </li>
                    </ul>
                    <!-- USER DROPDOWN -->
                    <div class="dropdown">
                        <button class="user-btn btn btn-sm dropdown-toggle" style="color: var(--bs-emphasis-color);
    background-color:var(--bs-body-bg) ;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <form action="" method="POST">
                                <li><button class="dropdown-item" style="background-color:var(--bs-danger-text); color : var(--bs-body-bg)" type="submit" name="logout">Logout</button></li>
                            </form>
                        </ul>
                    </div>
                    <!-- Dropdown MODE  -->
                    <div class="dropdown" style="margin-left:340px ;">
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
                <div class="item-admin-start" style="width: 65%; height:585px">
                    <!-- TABEL DATA ABSENSI -->
                    <table class="table table-striped ms-2 me-2 mt-2" style="width:98%">
                        <tr class="tr-header table-dark">
                            <th>Tanggal</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Performa</th>
                        </tr>

                        <?php
                        date_default_timezone_set("Asia/Jakarta");
                        date_default_timezone_set("Asia/Jakarta");
                        $user_id = $_SESSION["user_id"];
                        $tgl = date("Y-m-d");
                        $time = date("H:i:s");



                        $user_id = $_SESSION["user_id"];
                        $sql = "SELECT * FROM absensi WHERE user_id = '$user_id' ";
                        $result = $db->query($sql);

                        while ($data = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $data['tgl'] . "</td>";
                            echo "<td>" . $data['jam_masuk'] . "</td>";
                            if (empty($data["jam_keluar"]) && !empty($data["jam_masuk"]) && $data["tgl"] == $tgl) {
                                echo "<td>
            <form action='' method ='POST'>
            <button class='btn btn-danger' name ='clockout' type='submit'>Keluar</button>
            </form>
            </td>";
                            } else {
                                echo "<td>" . $data['jam_keluar'] . "</td>";
                            };

                            if (!empty($data["jam_keluar"]) && !empty($data["jam_masuk"])) {
                                echo "<td>✔</td>";
                            } else {
                                echo "<td>❌</td>";
                            }
                            echo "</tr>";
                        };
                        ?>
                    </table>

                    <form action="action.php" method="POST">
                        <button class="btn btn-success ms-2" name="absen" type="submit">ABSENSI</button>
                    </form>

                </div>
                <div class="item-admin-end d-flex flex-column ms-1" style="width: 35%;  font-family: 'Open Sans', sans-serif;">
                    <div class="admin-profile p-5 d-flex flex-column align-items-center  rounded-2" style="width:95%; height:60%;color: var(--bs-light-text);background-color:var(--bs-light-bg-subtle);border:1px solid var(--bs-light-border-subtle)">
                        <div class="icon">
                            <h1><i class="fa-solid fa-user fa-3x"></i></h1>
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
                    <?php
                    include("../connection.php");
                    $emp_not_clockin = $jumlah_karyawan - $jumlah_data_clockin;
                    $emp_not_clockout = $jumlah_karyawan - $jumlah_data_clockout;


                    $sql = "SELECT jam_masuk AND jam_keluar FROM absensi WHERE jam_masuk IS NOT NULL AND jam_keluar IS NOT NULL AND tgl = '$tgl'";
                    $result = $db->query($sql);
                    $emp_home = mysqli_num_rows($result);
                    ?>
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