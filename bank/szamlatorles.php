<?php
session_start();
include("fuggvenyek.php");

//POST-tal lekérjük az átküldött adatokat,
$v_szamlaszam = $_POST['szamlaszam'];

//ellenőrizzük, hogy kaptak-e értéket,
if ( empty($v_szamlaszam) ) {
	    header("Location: szamlanyitas.php?error=szamlaszam");
        exit();
}
else {
	//adat tisztítása: karaktereket karakterkódokra cseréljük,
	$v_tiszta_szamlaszam = htmlspecialchars($v_szamlaszam);
	
	//beszúrjuk a rekordot az adatbázisba
	$sikeres = szamla_torles($v_tiszta_szamlaszam );
	
	if ( $sikeres == false ) {
		die("Nem sikerült felvinni a rekordot.");
	} else {
		//visszalépünk a szamlanyitas.php-ra,
		header("Location: szamlanyitas.php?törölte=Sikeresen törölte a számlát!");
		exit();
	}
}

?>