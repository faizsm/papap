<?php
include "koneksidb.php";

// Inisialisasi variabel
$form_action = "index.php?menu=m_mata_kuliah";
$form_title = "TAMBAH DATA";
$kode_mk = "";
$nama_mk = "";
$sks = "";
$sem = "";
$id_dosen        = "";
$is_update = false;

if (isset($_GET['id'])) {
    $b = mysqli_query($conn, "SELECT * FROM m_matakuliah WHERE id=" . $_GET['id']);
    $c = mysqli_fetch_assoc($b);

    // Query tambahan untuk mengambil nama dosen
    $dosen_query = mysqli_query($conn, "SELECT nama_dosen FROM m_dosen WHERE id_dosen=" . $c['id_dosen']);
    $dosen = mysqli_fetch_assoc($dosen_query);
    $nama_dosen = $dosen['nama_dosen'];

    $kode_mk = $c['kode_mk'];
    $nama_mk = $c['nama_mk'];
    $sks = $c['sks'];
    $sem = $c['smt'];
    $id_dosen = $c['id_dosen'];
    $is_update = true;
    $form_action = "index.php?menu=m_mata_kuliah&id=" . $_GET['id'];
    $form_title = "UBAH DATA";
}

$dosen_options = "";
$dosen_query = mysqli_query($conn, "SELECT id_dosen, nama_dosen FROM m_dosen"); // Update table name if needed
while ($dosen = mysqli_fetch_assoc($dosen_query)) {
    $selected = ($dosen['id_dosen'] == $id_dosen) ? "selected" : "";
    $dosen_options .= "<option value='{$dosen['id_dosen']}' $selected>{$dosen['nama_dosen']}</option>";
}
// Form tambah atau ubah data
echo "<table border='1' width='30%' align='center'>";
echo "<form method='POST' action='$form_action'>";
echo "<tr><th colspan='2'>$form_title</th></tr>";
echo "<tr><td>Kode MK</td><td>: <input type='text' name='kode_mk' value='$kode_mk' required></td></tr>";
echo "<tr><td>Nama MK</td><td>: <input type='text' name='nama_mk' value='$nama_mk' required></td></tr>";
echo "<tr><td>SKS</td><td>: <input type='number' name='sks' value='$sks' required></td></tr>";
echo "<tr><td>Semester</td><td>: <input type='number' name='smt' value='$sem' required></td></tr>";
echo "<tr><td>Dosen Pengampu</td><td>: <select name='id_dosen' required>$dosen_options</select></td></tr>";
echo "<tr><th colspan='2'><input type='submit' value='OK' name='" . ($is_update ? "tombol_ubah" : "tombol_tambah") . "'></th></tr>";
echo "</form>";
echo "</table>";

if (isset($_POST['tombol_tambah'])) {
    // Tangkap nilai dari form tambah
    $kode_mk = $_POST['kode_mk'];
    $nama_mk = $_POST['nama_mk'];
    $sks = $_POST['sks'];
    $sem = $_POST['smt'];
    $id_dosen = $_POST['id_dosen'];

    // Lindungi dari serangan SQL Injection dengan mysqli_real_escape_string
    $kode_mk = mysqli_real_escape_string($conn, $kode_mk);
    $nama_mk = mysqli_real_escape_string($conn, $nama_mk);
    $sks = mysqli_real_escape_string($conn, $sks);
    $sem = mysqli_real_escape_string($conn, $sem);
    $id_dosen = mysqli_real_escape_string($conn, $id_dosen);

    // Insert data ke database
    $b = mysqli_query($conn, "INSERT INTO m_matakuliah (kode_mk, nama_mk, sks, smt, id_dosen) VALUES ('$kode_mk', '$nama_mk', '$sks', '$sem', '$id_dosen')");
    echo "<META http-equiv=refresh content=\"0; URL=index.php?menu=m_mata_kuliah\">";
}

if (isset($_POST['tombol_ubah'])) {
    // Tangkap nilai dari form ubah
    $kode_mk = $_POST['kode_mk'];
    $nama_mk = $_POST['nama_mk'];
    $sks = $_POST['sks'];
    $sem = $_POST['smt'];
    $id_dosen = $_POST['id_dosen'];

    // Lindungi dari serangan SQL Injection dengan mysqli_real_escape_string
    $kode_mk = mysqli_real_escape_string($conn, $kode_mk);
    $nama_mk = mysqli_real_escape_string($conn, $nama_mk);
    $sks = mysqli_real_escape_string($conn, $sks);
    $sem = mysqli_real_escape_string($conn, $sem);
    $id_dosen = mysqli_real_escape_string($conn, $id_dosen);

    // Update data di database
    $b = mysqli_query($conn, "UPDATE m_matakuliah SET kode_mk='$kode_mk', nama_mk='$nama_mk', sks='$sks', smt='$sem', id_dosen='$id_dosen' WHERE id=" . $_GET['id']);
    echo "<META http-equiv=refresh content=\"0; URL=index.php?menu=m_mata_kuliah\">";
}

// Menangani penghapusan data
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Lindungi dari serangan SQL Injection dengan mysqli_real_escape_string
    $delete_id = mysqli_real_escape_string($conn, $delete_id);
    // Hapus data dari database
    $b = mysqli_query($conn, "DELETE FROM m_matakuliah WHERE id='$delete_id'");
    echo "<META http-equiv=refresh content=\"0; URL=index.php?menu=m_mata_kuliah\">";
}

$keyword = '';
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT * FROM m_matakuliah 
        WHERE kode_mk LIKE '%$keyword%' OR nama_mk LIKE '%$keyword%' 
        ORDER BY id DESC";
} else {
    $query = "SELECT * FROM m_matakuliah 
        ORDER BY id DESC";
}

$a = mysqli_query($conn, $query);
$no = 0;
echo "<br>";
echo "<table border='1' width='80%' align='center'>";
echo "<form method='POST' action=''>";
echo "<tr ><td colspan=2>Pencarian</td><td colspan=8><input type=text name=keyword value='$keyword'><input type='submit' name='search' value='CARI'> <input type='submit' value='NORMAL'></td></tr>";
echo "<tr ><th> NO </th><th> KODE MK </th><th> NAMA MK </th><th> SKS </th><th> Semester </th><th> Dosen Pengampu </th><th colspan=2>AKSI</th></tr>";
echo "</form>"; 
while ($b = mysqli_fetch_array($a)) {
    $no = $no + 1;

    $dosen = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_dosen FROM m_dosen WHERE id_dosen='{$b['id_dosen']}'"))['nama_dosen'];
    echo "<tr align='center'><td> $no </td> <td> $b[kode_mk] </td> <td> $b[nama_mk] </td> <td>$b[sks]</td><td>$b[smt]</td><td>$dosen</td>";
    echo "<td><a href='index.php?menu=m_mata_kuliah&id=$b[id]'><img src='ubah.png' style='width:25px;height:25px;'></a></td>";
    echo "<td><a href='index.php?menu=m_mata_kuliah&delete_id=$b[id]'><img src='pngwing.com.png' style='width:25px;height:25px;'></a></td></tr>";
}
echo "</table>";
?>
