<?php
session_start();
if (isset($_SESSION['kunci'])) {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
            }

            .navbar {
                overflow: hidden;
                background-color: #333;
            }

            .navbar a {
                float: left;
                font-size: 16px;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            .dropdown {
                float: left;
                overflow: hidden;
            }

            .dropdown .dropbtn {
                font-size: 16px;
                border: none;
                outline: none;
                color: white;
                padding: 14px 16px;
                background-color: inherit;
                font-family: inherit;
                margin: 0;
            }

            .navbar a:hover,
            .dropdown:hover .dropbtn {
                background-color: red;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                z-index: 1;
            }

            .dropdown-content a {
                float: none;
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                text-align: left;
            }

            .dropdown-content a:hover {
                background-color: #ddd;
            }

            .dropdown:hover .dropdown-content {
                display: block;
            }
            
            .navbar a[href="logout.php"] {
            float: right;
        }
        </style>
    </head>

    <body style="background-color:white;">

        <div class="navbar">
            <a href="index.php">Home</a>
            <div class="dropdown">
                <button class="dropbtn">Master Data
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="index.php?menu=m_mahasiswa">Mahasiswa</a>
                    <a href="index.php?menu=m_mata_kuliah">Matakuliah</a>
                    <a href="index.php?menu=m_nilai">Nilai</a>
                    <a href="index.php?menu=m_dosen">Dosen</a>
                    <a href="index.php?menu=m_pengguna">Pengguna</a>
                </div>
            </div>
            <a href="logout.php">Logout</a>
        </div>

        <div>
            <?php
            if (isset($_GET['menu'])) {
                if ($_GET['menu'] == 'm_nilai') {
                    include 'uts.php';
                }
                if($_GET['menu'] == 'm_mahasiswa') { 
                    include "mahasiswa.php";
                }
                 if($_GET['menu'] == 'm_mata_kuliah') { 
                     include "matakuliah.php";
                }
                 if($_GET['menu'] == 'm_dosen') { 
                     include "dosen.php";
                 }
                if($_GET['menu'] == 'm_pengguna') { 
                    include "pengguna.php";
                 }
            }
            ?>
        </div>

    </body>

    </html>
<?php
} else {
    echo "Maaf ini halaman khusus klik <a href='form_login.php'>DISINI</a> untuk masuk";
}
?>