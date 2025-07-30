<?php
session_start();
include("fuggvenyek.php");

//POST-tal lekérjük az átküldött adatokat,
$v_szamlaszam = $_POST['szamlaszam'];
$v_osszeg = $_POST['osszeg'];

//ellenőrizzük, hogy kaptak-e értéket,
if ( empty($v_szamlaszam) ) {
	    header("Location: szamlanyitas.php?error=szamlaszam");
        exit();
}
else if ( empty($v_osszeg) ) {
	    header("Location: szamlanyitas.php?error=osszeg");
        exit();
}
else {
	//adat tisztítása: karaktereket karakterkódokra cseréljük,
	$v_tiszta_szamlaszam = htmlspecialchars($v_szamlaszam);
	$v_tiszta_osszeg = htmlspecialchars($v_osszeg);
	
	//beszúrjuk a rekordot az adatbázisba
	$sikeres = befizetes($v_tiszta_szamlaszam, $v_tiszta_osszeg );
	
	if ( $sikeres == false ) {
		die("Nem sikerült felvinni a rekordot.");
	} else {
		//visszalépünk a szamlanyitas.php-ra,
		header("Location: szamlanyitas.php?befizetve=Sikeres befizetés!");
		exit();
	}
}

?>