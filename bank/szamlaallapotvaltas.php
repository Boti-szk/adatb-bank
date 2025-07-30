<?php
session_start();
include("fuggvenyek.php");

//POST-tal lekérjük az átküldött adatokat,
$v_szamlaszam = $_POST['szamlaszam'];
$v_nyitzar = $_POST['nyitzar'];

//ellenőrizzük, hogy kaptak-e értéket,
if ( empty($v_szamlaszam) ) {
	    header("Location: szamlanyitas.php?error=szamlaszam");
        exit();
}
else if ( empty($v_nyitzar) ) {
	    header("Location: szamlanyitas.php?error=nyitzar");
        exit();
}
else {
	//adat tisztítása: karaktereket karakterkódokra cseréljük,
	$v_tiszta_szamlaszam = htmlspecialchars($v_szamlaszam);
	$v_tiszta_nyitzar = htmlspecialchars($v_nyitzar);
	
	//beszúrjuk a rekordot az adatbázisba
	$sikeres = szamlaallapotot_valtoztat($v_tiszta_szamlaszam, $v_tiszta_nyitzar );
	
	if ( $sikeres == false ) {
		die("Nem sikerült felvinni a rekordot.");
	} else {
		//visszalépünk a szamlanyitas.php-ra,
		header("Location: szamlanyitas.php?valtoztatta=Sikeresen megváltoztatta a számla állapotát!");
		exit();
	}
}

?>