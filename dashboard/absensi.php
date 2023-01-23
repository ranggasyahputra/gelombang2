<table class="table table-striped ms-2 me-2 mt-2" style="width:98%">
    <tr class="tr-header table-dark">
        <th>Tanggal</th>
        <th>Clock In</th>
        <th>Clock Out</th>
        <th>Performa</th>
    </tr>

    <?php
    include("../connection.php");
    date_default_timezone_set("Asia/Jakarta");
    date_default_timezone_set("Asia/Jakarta");
    $user_id = $_SESSION["user_id"];
    $tgl = date("Y-m-d");
    $time = date("H:i:s");

    if (isset($_POST["clockout"])) {
        $sql = "UPDATE absensi SET jam_keluar= '$time' WHERE user_id='$user_id' AND tgl='$tgl'";
        $clockout = $db->query($sql);
        if ($clockout == TRUE) {
            session_start();
            session_destroy();
            header("location:../index.php?message=Terimakasih dengan kinerja hari ini!!");
        } else {
            echo "maaf terjadi kesalahan";
        }
    };


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
