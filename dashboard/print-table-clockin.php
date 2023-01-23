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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        @media screen {
            button {
                display: block !important;
            }

        }

        @media print {
            button {
                display: none !important;
            }
        }
    </style>
    <title>Print</title>
</head>

<body>
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
    <button class="btn btn-primary" onclick="window.print()">
        PRINT
    </button>


</body>

</html>