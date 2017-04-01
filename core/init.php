<?php
ob_start(); // Added to avoid a common error of 'header already sent'
session_start();
require_once 'connect/database.php';
function my_autoload($class)
{   $filename = 'classes/'.$class.'.php';
	include_once $filename;
}
spl_autoload_register('my_autoload');
try {
	$general 	= new General();
	$users 		= new Users($db);
	$mahasiswa 	= new Mahasiswa($db);
	$dosen 	= new Dosen($db);
	$prodi = new Prodi($db);
	$jurusan = new Jurusan($db);
	$semester = new Semester($db);
	$kelas = new Kelas($db);
	$matakuliah = new Matakuliah($db);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
