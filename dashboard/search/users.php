<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2ce69c7166.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        @media screen {
            button,head {
                display: block !important;
            }
        }

        @media print {
            button, title {
                display: none !important;
            }
        }
    </style>
    <title>
        Data
        <?php
        if (isset($_GET["users"])) {
            echo ($_GET["users"]);
        }
        ?>

    </title>
</head>

<body>
    <div class="container" id="table-karyawan">

        <table class="table">
            <thead class="tr-header table-light">
                <td>No</td>
                <td>Nama Lengkap</td>
                <td>NIP</td>
                <td>Role</td>
                <td>Tanggal</td>
                <td>Clockin</td>
                <td>Clockout</td>
            </thead>
            <?php
            $user_input = ($_GET["users"]);
            include("../../connection.php");
            include("../../users_class.php");

            $sql = "SELECT * FROM users JOIN absensi ON users.user_id = absensi.user_id WHERE users.user_id = $user_input OR users.nama_lengkap ='$user_input'";
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

        <div class="d-flex gap-2">
            <button class="btn btn-primary p-2" type="button" onclick="window.print()">PRINT</button>
            <button class="btn bg-primary-subtle border border-primary-subtle p-2 text-primary" type="button" onclick="window.location.replace('../index-admin.php')">BACK</button>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        function printDiv() {
            var tableKaryawan = document.getElementById("table-karyawan")
            newWin = window.open("./print.html");
            newWin.document.write(tableKaryawan.outerHTML);
            newWin.print();
            newWin.close();
        }
    </script>
</body>