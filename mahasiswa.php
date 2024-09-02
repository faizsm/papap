<?php
include "koneksidb.php";

// Inisialisasi variabel
$form_action = "index.php?menu=m_mahasiswa";
$form_title = "TAMBAH DATA";
$nim = "";
$nama = "";
$jk = "";
$alamat = "";
$is_update = false;

if (isset($_GET['id'])) {
    $b = mysqli_query($conn, "SELECT * FROM m_mahasiswa WHERE id=" . $_GET['id']);
    $c = mysqli_fetch_assoc($b);

    $nim = $c['nim'];
    $nama = $c['nama_mhs'];
    $jk = $c['jk'];
    $alamat = $c['alamat'];
    $is_update = true;
    $form_action = "index.php?menu=m_mahasiswa&id=" . $_GET['id'];
    $form_title = "UBAH DATA";
}

// Form tambah atau ubah data
echo "<table border='1' width='30%' align='center'>";
echo "<form method='POST' action='$form_action'>";
echo "<tr><th colspan='2'>$form_title</th></tr>";
echo "<tr><td>NIM</td><td>: <input type='text' name='nim' value='$nim' required></td></tr>";
echo "<tr><td>Nama</td><td>: <input type='text' name='nama' value='$nama' required></td></tr>";
echo "<tr><td>Jenis Kelamin</td><td>: <select name='jk' required>";
if (!$is_update) {
    echo "<option value='' disabled selected>Pilih Jenis Kelamin</option>";
}
echo "<option value='Laki-laki'" . ($jk == 'Laki-laki' ? ' selected' : '') . ">Laki-laki</option>";
echo "<option value='Perempuan'" . ($jk == 'Perempuan' ? ' selected' : '') . ">Perempuan</option>";
echo "</select></td></tr>";
echo "<tr><td>Alamat</td><td>: <textarea name='alamat' required>$alamat</textarea></td></tr>";
echo "<tr><th colspan='2'><input type='submit' value='OK' name='" . ($is_update ? "tombol_ubah" : "tombol_tambah") . "'></th></tr>";
echo "</form>";
echo "</table>";

if (isset($_POST['tombol_tambah'])) {
    // Tangkap nilai dari form tambah
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];

    // Lindungi dari serangan SQL Injection dengan mysqli_real_escape_string
    $nim = mysqli_real_escape_string($conn, $nim);
    $nama = mysqli_real_escape_string($conn, $nama);
    $jk = mysqli_real_escape_string($conn, $jk);
    $alamat = mysqli_real_escape_string($conn, $alamat);

    // Insert data ke database
    $b = mysqli_query($conn, "INSERT INTO m_mahasiswa (nim, nama_mhs, jk, alamat) VALUES ('$nim', '$nama', '$jk', '$alamat')");
    echo "<META http-equiv=refresh content=\"0; URL=index.php?menu=m_mahasiswa\">";
}

if (isset($_POST['tombol_ubah'])) {
    // Tangkap nilai dari form ubah
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];

    // Lindungi dari serangan SQL Injection dengan mysqli_real_escape_string
    $nim = mysqli_real_escape_string($conn, $nim);
    $nama = mysqli_real_escape_string($conn, $nama);
    $jk = mysqli_real_escape_string($conn, $jk);
    $alamat = mysqli_real_escape_string($conn, $alamat);

    // Update data di database
    $b = mysqli_query($conn, "UPDATE m_mahasiswa SET nim='$nim', nama_mhs='$nama', jk='$jk', alamat='$alamat' WHERE id=" . $_GET['id']);
    echo "<META http-equiv=refresh content=\"0; URL=index.php?menu=m_mahasiswa\">";
}

// Menangani penghapusan data
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Lindungi dari serangan SQL Injection dengan mysqli_real_escape_string
    $delete_id = mysqli_real_escape_string($conn, $delete_id);
    // Hapus data dari database
    $b = mysqli_query($conn, "DELETE FROM m_mahasiswa WHERE id='$delete_id'");
    echo "<META http-equiv=refresh content=\"0; URL=index.php?menu=m_mahasiswa\">";
}

$keyword = '';
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT * FROM m_mahasiswa 
        WHERE nim LIKE '%$keyword%' OR nama_mhs LIKE '%$keyword%' 
        ORDER BY id DESC";
} else {
    $query = "SELECT * FROM m_mahasiswa 
        ORDER BY id DESC";
}

$a = mysqli_query($conn, $query);
$no = 0;
echo "<br>";
echo "<table border='1' width='80%' align='center'>";
echo "<form method='POST' action=''>";
echo "<tr><td colspan=2>Pencarian</td><td colspan=7><input type=text name=keyword value='$keyword'><input type='submit' name='search' value='CARI'> <input type='submit' value='NORMAL'></td></tr>";
echo "<tr><th> NO </th><th> NIM </th><th> NAMA </th><th width='150'> JENIS KELAMIN</th><th> ALAMAT </th><th colspan=2>AKSI</th></tr>";
echo "</form>";
while ($b = mysqli_fetch_array($a)) {
    $no = $no + 1;
    echo "<tr><td> $no </td> <td> $b[nim] </td> <td> $b[nama_mhs] </td> <td>$b[jk]</td><td>$b[alamat]</td>";
    echo "<td><a href='index.php?menu=m_mahasiswa&id=$b[id]'><img src='ubah.png' style='width:25px;height:25px;'></a></td>";
    echo "<td><a href='index.php?menu=m_mahasiswa&delete_id=$b[id]'><img src='pngwing.com.png' style='width:25px;height:25px;'></a></td></tr>";
}
echo "</table>";
?>
