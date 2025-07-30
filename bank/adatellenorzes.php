<?php
session_start();
include("fuggvenyek.php");

//POST-tal lekérjük az átküldött adatokat,
$v_azonosito = $_POST['azonosito'];
$v_nev = $_POST['nev'];
$v_jelszo = $_POST['jelszo'];

//ellenőrizzük, hogy kaptak-e értéket,
if ( empty($v_azonosito) && empty($v_nev) && empty($v_jelszo)) {
	
	error_log("Nincs beállítva minden érték");
	
} else {
	//adat tisztítása: karaktereket karakterkódokra cseréljük,
	$v_tiszta_azonosito = htmlspecialchars($v_azonosito);
	$v_tiszta_nev = htmlspecialchars($v_nev);
	$v_tiszta_jelszo = htmlspecialchars($v_jelszo);
	
	//beszúrjuk a rekordot az adatbázisba
	$sikeres = bejelentkezik($v_tiszta_azonosito, $v_tiszta_nev, $v_tiszta_jelszo);
	
	if ( $sikeres == false ) {
		die("Nem sikerült bejelentkezni.");
	} else {
		//átlépünk a bejelentkezve.php-ra,
		header("Location: bejelentkezve.php?bejelentkezett=Sikeresen bejelentkezett!");
	}
}

?>