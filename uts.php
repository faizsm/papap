<?php
// session_start();
// if(ISSET($_SESSION['kunci'])){
?>
<?php
include "koneksidb.php";

$mahasiswa = mysqli_query($conn, "SELECT * FROM m_mahasiswa");
$matakuliah = mysqli_query($conn, "SELECT * FROM m_matakuliah");

// Inisialisasi variabel
$form_action = "index.php?menu=m_nilai";
$form_title = "TAMBAH DATA";
$nim = "";
$kode_mk = "";
$thn_akademik = "";
$nilai = "";
$is_update = false;

if (isset($_GET['id'])) {
    $b = mysqli_query($conn, "SELECT * FROM nilai WHERE id=" . $_GET['id']);
    $c = mysqli_fetch_assoc($b);

    $nim = $c['nim'];
    $kode_mk = $c['kode_mk'];
    $thn_akademik = $c['thn_akademik'];
    $nilai = $c['nilai'];
    $is_update = true;
    $form_action = "uts.php?id=" . $_GET['id'];
    $form_title = "UBAH DATA";
}

// Inisialisasi array untuk opsi mahasiswa dan matakuliah
$mahasiswa_options = array();
$matakuliah_options = array();

// Tambahkan opsi "Pilih NIM" dan "Pilih Mata Kuliah" jika dalam mode tambah data
if (!$is_update) {
    $mahasiswa_options[] = "<option value='' disabled selected>Pilih NIM</option>";
    $matakuliah_options[] = "<option value='' disabled selected>Pilih Mata Kuliah</option>";
}

// Memasukkan semua opsi NIM ke dalam array dan memindahkan yang dipilih ke atas
while ($row = mysqli_fetch_assoc($mahasiswa)) {
    $nim_option = "<option value='" . $row['nim'] . "'" . ($nim == $row['nim'] ? ' selected' : '') . ">" . $row['nim'] . " - " . $row['nama_mhs'] . "</option>";
    if ($nim == $row['nim']) {
        array_unshift($mahasiswa_options, $nim_option);
    } else {
        $mahasiswa_options[] = $nim_option;
    }
}

// Memasukkan semua opsi kode MK ke dalam array dan memindahkan yang dipilih ke atas
while ($row = mysqli_fetch_assoc($matakuliah)) {
    $mk_option = "<option value='" . $row['kode_mk'] . "'" . ($kode_mk == $row['kode_mk'] ? ' selected' : '') . ">" . $row['kode_mk'] . " - " . $row['nama_mk'] . "</option>";
    if ($kode_mk == $row['kode_mk']) {
        array_unshift($matakuliah_options, $mk_option);
    } else {
        $matakuliah_options[] = $mk_option;
    }
}

// Form tambah atau ubah data
echo "<table border='1' width='30%' align='center'>";
echo "<form method='POST' action='$form_action'>";
echo "<tr><th colspan='2'>$form_title</th></tr>";
echo "<tr><td>NIM</td><td>: <select name='npm' required>";
foreach ($mahasiswa_options as $option) {
    echo $option;
}
echo "</select></td></tr>";
echo "<tr><td>MK</td><td>: <select name='mk' required>";
foreach ($matakuliah_options as $option) {
    echo $option;
}
echo "</select></td></tr>";
echo "<tr><td>THN AKADEMIK</td><td>: <input type='text' name='tahun' size='8' placeholder='" . (!$is_update ? "2024/2025" : "") . "' value='$thn_akademik' required></td></tr>";
echo "<tr><td>NILAI</td><td>: <select name='nilai' required>";
if (!$is_update) {
    echo "<option value='' disabled selected>Pilih Nilai</option>";
}
echo "<option value='A'" . ($nilai == 'A' ? ' selected' : '') . ">A</option>";
echo "<option value='B'" . ($nilai == 'B' ? ' selected' : '') . ">B</option>";
echo "<option value='C'" . ($nilai == 'C' ? ' selected' : '') . ">C</option>";
echo "<option value='D'" . ($nilai == 'D' ? ' selected' : '') . ">D</option>";
echo "<option value='E'" . ($nilai == 'E' ? ' selected' : '') . ">E</option>";
echo "<option value='T'" . ($nilai == 'T' ? ' selected' : '') . ">T</option>";
echo "</select></td></tr>";
echo "<tr><th colspan='2'><input type='submit' value='OK' name='" . ($is_update ? "tombol_ubah" : "tombol_tambah") . "'></th></tr>";
echo "</form>";
echo "</table>";

if (isset($_POST['tombol_tambah'])) {
    // Tangkap nilai dari form tambah
    $npm = $_POST['npm'];
    $mk = $_POST['mk'];
    $tahun = $_POST['tahun'];
    $nilai = $_POST['nilai'];

    // Lindungi dari serangan SQL Injection dengan mysqli_real_escape_string
    $npm = mysqli_real_escape_string($conn, $npm);
    $mk = mysqli_real_escape_string($conn, $mk);
    $tahun = mysqli_real_escape_string($conn, $tahun);
    $nilai = mysqli_real_escape_string($conn, $nilai);

    // Insert data ke database
    $b = mysqli_query($conn, "INSERT INTO nilai (nim, kode_mk, thn_akademik, nilai) VALUES ('$npm', '$mk', '$tahun', '$nilai')");
    echo "<META http-equiv=refresh content=\"0; URL=index.php?menu=m_nilai\">";
}

if (isset($_POST['tombol_ubah'])) {
    // Tangkap nilai dari form ubah
    $tahun_akademik = $_POST['tahun'];

    // Lindungi dari serangan SQL Injection dengan mysqli_real_escape_string
    $tahun_akademik = mysqli_real_escape_string($conn, $tahun_akademik);

    // Update data di database
    $b = mysqli_query($conn, "UPDATE nilai SET nim='" . $_POST['npm'] . "', kode_mk='" . $_POST['mk'] . "', nilai='" . $_POST['nilai'] . "', thn_akademik='$tahun_akademik' WHERE id=" . $_GET['id']);
    echo "<META http-equiv=refresh content=\"0; URL=index.php?menu=m_nilai\">";
}

// Menangani penghapusan data
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Lindungi dari serangan SQL Injection dengan mysqli_real_escape_string
    $delete_id = mysqli_real_escape_string($conn, $delete_id);
    // Hapus data dari database
    $b = mysqli_query($conn, "DELETE FROM nilai WHERE id='$delete_id'");
    echo "<META http-equiv=refresh content=\"0; URL=index.php?menu=m_nilai\">";
}

$keyword = '';
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT a.*, b.nama_mhs, c.nama_mk
        FROM nilai a
        INNER JOIN m_mahasiswa b ON a.nim = b.nim
        INNER JOIN m_matakuliah c ON a.kode_mk = c.kode_mk
        WHERE b.nim LIKE '%$keyword%' OR b.nama_mhs LIKE '%$keyword%' OR c.nama_mk LIKE '%$keyword%'
        ORDER BY a.id DESC";
} else {
    $query = "SELECT a.*, b.nama_mhs, c.nama_mk 
        FROM nilai a 
        INNER JOIN m_mahasiswa b ON a.nim = b.nim 
        INNER JOIN m_matakuliah c ON a.kode_mk = c.kode_mk 
        ORDER BY a.id DESC";
}

$a = mysqli_query($conn, $query);
$no = 0;
echo "<br>";
// echo "<a href='logout.php'>KELUAR</a>";
echo "<table border='1' width='80%' align='center'>";
echo "<form method='POST' action=''>";
echo "<tr><td colspan=2>Pencarian</td><td colspan=7><input type=text name=keyword value='$keyword'><input type='submit' name='search' value='CARI'> <input type='submit' value='NORMAL'></td></tr>";
echo "<tr><th> NO </th><th> NIM </th><th> NAMA </th><th> KODE MK</th><th> NAMA MK </th><th> THN AKADEMIK</th><th>NILAI</th><th colspan=2>AKSI</th></tr>";
echo "</form>";
while ($b = mysqli_fetch_array($a)) {
    $no = $no + 1;
    echo "<tr><td> $no </td> <td> $b[nim] </td> <td> $b[nama_mhs] </td> <td>$b[kode_mk]</td> <td>$b[nama_mk] </td>";
    echo "<td>$b[thn_akademik] </td><td>$b[nilai]</td><td><a href='index.php?menu=m_nilai&id=$b[id]'><img src='ubah.png' style='width:25px;height:25px;'></a></td>";
    echo "<td><a href='index.php?menu=m_nilai&delete_id=$b[id]'><img src='pngwing.com.png' style='width:25px;height:25px;'></a></td></tr>";
}
echo "</table>";
?>
<?php
// }else {
// 		echo "Maaf ini halaman khusus klik <a href='form_login.php'>DISINI</a> untuk masuk";

// }
?>