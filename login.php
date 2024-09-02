<?php
session_start();
include "koneksidb.php";
if (isset($_POST['fLogin'])) {
    $u = $_POST['user'];
    $p = $_POST['pass'];
    //echo"$u $p";
    $g = mysqli_query($conn, "select * from m_pengguna where kode_op='$u' and pass=SHA1('$p')");
    $j = mysqli_num_rows($g);
    if ($j > 0) {
        echo "User dan Pass Benar";
        $_SESSION['kunci'] = "Admin";
        echo "<META http-equiv=refresh content=\"0; URL=index.php\">";
    } else {

        echo "User dan atau Password Salah";
        echo "<META http-equiv=refresh content=\"0; URL=form_login.php\">";
    }
}

?>