<?php
session_start();
include("fuggvenyek.php");

//POST-tal lekérjük az átküldött adatokat,
$v_tipusnev = $_POST['tipusnev'];
$v_egyenleg = $_POST['egyenleg'];

//ellenőrizzük, hogy kaptak-e értéket,
if ( empty($v_tipusnev)) {
	header("Location: szamlanyitas.php?error=tipusnev");
        exit();
}
else if(empty($v_egyenleg)) {
		 header("Location: szamlanyitas.php?error=egyenleg");
        exit();
}
else {
	//adat tisztítása: karaktereket karakterkódokra cseréljük,
	$v_tiszta_tipusnev = htmlspecialchars($v_tipusnev);
	$v_tiszta_egyenleg = htmlspecialchars($v_egyenleg);
	
	//beszúrjuk a rekordot az adatbázisba
	$sikeres = szamlat_beszur($v_tiszta_tipusnev, $v_tiszta_egyenleg );
	
	if ( $sikeres == false ) {
		die("Nem sikerült felvinni a rekordot.");
	} else {
		//visszalépünk a szamlanyitas.php-ra,
		header("Location: szamlanyitas.php?letrehozta=Sikeres számlanyitás!");
		exit();
	}
}

?>