<?php
$sql = "SELECT * FROM users WHERE role = 'employee'";
$result = $db->query($sql);
$jumlah_karyawan = mysqli_num_rows($result)


?>