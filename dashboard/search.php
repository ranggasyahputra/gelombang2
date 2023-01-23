
<table>
<tr>
    <td>No</td>
    <td>Nama Lengkap</td>
    <td>NIP</td>
    <td>Role</td>
    <td>Tanggal</td>
    <td>Clockin</td>
    <td>Clockout</td>
</tr>
    <?php
include("../connection.php");
include("../users_class.php");

$user = new Users();
if(isset($_POST["search"])) {
    $user->set_user_data($_POST["search_input"]);
    $search_input = $user->get_user_data();
    
    $sql = "SELECT * FROM users JOIN absensi ON users.user_id = absensi.user_id WHERE users.user_id = $search_input OR nama_lengkap ='$search_input'";
    
    $no = 1;    
    $result = $db->query($sql);
    if($result->num_rows > 0) {
        header("location:./search/users.php?users=$search_input");
        
    } else {
        header("location:index-admin.php?message=User Not Found");
    }
    
} 
?>
</table>
