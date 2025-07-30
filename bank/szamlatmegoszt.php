<?php
session_start();
include("fuggvenyek.php");

//POST-tal lekérjük az átküldött adatokat,
$v_szamlaszam = $_POST['szamlaszam'];
$v_kivel = $_POST['kivel'];

//ellenőrizzük, hogy kaptak-e értéket,
if ( empty($v_szamlaszam) ) {
	    header("Location: szamlanyitas.php?error=szamlaszam2");
        exit();
}
else if ( empty($v_kivel) ) {
	    header("Location: szamlanyitas.php?error=kivel");
        exit();
}
else {
	//adat tisztítása: karaktereket karakterkódokra cseréljük,
	$v_tiszta_szamlaszam = htmlspecialchars($v_szamlaszam);
	$v_tiszta_kivel = htmlspecialchars($v_kivel);
	
	//beszúrjuk a rekordot az adatbázisba
	$sikeres = szamlat_megoszt($v_tiszta_szamlaszam, $v_tiszta_kivel );
	
	if ( $sikeres == false ) {
		die("Nem sikerült felvinni a rekordot.");
	} else {
		//visszalépünk a szamlanyitas.php-ra,
		header("Location: szamlanyitas.php?megosztotta=Sikeresen megosztotta számláját!");
		exit();
	}
}

?>