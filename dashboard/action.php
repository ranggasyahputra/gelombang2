<?php
include("../connection.php");
session_start();

date_default_timezone_set("Asia/Jakarta");
$user_id = $_SESSION["user_id"];
$tgl = date("Y-m-d");
$time = date("H:i:s");

$check_absen = "SELECT * FROM absensi WHERE user_id = $user_id AND tgl ='$tgl' ";
$check = $db->query($check_absen);

echo $tgl;


if ($check->num_rows > 0) {
    header("location:index-employee.php?message=Anda Sudah Checkin");
} else {
    $sql = "INSERT INTO absensi (`id`,user_id, `tgl`, `jam_masuk`, `jam_keluar` ) VALUES (NULL, '$user_id' , '$tgl', '$time', NULL )";
    $result = $db->query($sql);
    if ($result === TRUE) {
        // echo "absen berhasil";
        header("location:index-employee.php?message=✔ terimakasih telah LOG IN hari ini!!");
    } else {
        // echo "absen gagal";
        header("location:index-employee.php?message=❌ Gagal Absen ❌");
    };
};
