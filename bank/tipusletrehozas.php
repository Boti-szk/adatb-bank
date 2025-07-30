<?php
session_start();
include("fuggvenyek.php");

//POST-tal lekérjük az átküldött adatokat,
$v_tipusnev = $_POST['tipusnev'];
$v_mettol = $_POST['mettol'];
$v_meddig = $_POST['meddig'];

//ellenőrizzük, hogy kaptak-e értéket,
if ( empty($v_tipusnev)) {
	    header("Location: ujtipus.php?error=tipusnev");
        exit();
}
else if ( empty($v_mettol)) {
	    header("Location: ujtipus.php?error=mettol");
        exit();
}
else if (  empty($v_meddig)) {
	    header("Location: ujtipus.php?error=meddig");
        exit();
} else {
	//adat tisztítása: karaktereket karakterkódokra cseréljük,
	$v_tiszta_tipusnev = htmlspecialchars($v_tipusnev);
	$v_tiszta_mettol = htmlspecialchars($v_mettol);
	$v_tiszta_meddig = htmlspecialchars($v_meddig);
	
	//beszúrjuk a rekordot az adatbázisba
	$sikeres = tipust_beszur($v_tiszta_tipusnev, $v_tiszta_mettol, $v_tiszta_meddig);
	
	if ( $sikeres == false ) {
		die("Nem sikerült felvinni a rekordot.");
	} else {
		//visszalépünk az ujtipus.php-ra,
		header("Location: ujtipus.php?letrehozta=Sikeresen létrehozta a számlatípust!");
		exit();
	}
}

?>