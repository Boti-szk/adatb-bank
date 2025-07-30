<?php
session_start();
include("fuggvenyek.php");

//POST-tal lekérjük az átküldött adatokat,
$v_tipusnevek = $_POST['tipusnevek'];
$v_allapot = $_POST['allapot'];

//ellenőrizzük, hogy kaptak-e értéket,
if ( empty($v_tipusnevek) ) {
	    header("Location: ujtipus.php?error=tipusnevek");
        exit();
}
else if ( empty($v_allapot) ) {
	    header("Location: ujtipus.php?error=allapot");
        exit();
}
else {
	//adat tisztítása: karaktereket karakterkódokra cseréljük,
	$v_tiszta_tipusnevek = htmlspecialchars($v_tipusnevek);
	$v_tiszta_allapot = htmlspecialchars($v_allapot);
	
	//beszúrjuk a rekordot az adatbázisba
	$sikeres = tipusallapotot_valtoztat($v_tiszta_tipusnevek, $v_tiszta_allapot );
	
	if ( $sikeres == false ) {
		die("Nem sikerült felvinni a rekordot.");
	} else {
		//visszalépünk az ujtipus.php-ra,
		header("Location: ujtipus.php?valtoztatta=Sikeresen megváltoztatta a számlatípus állapotát!");
		exit();
	}
}

?>