<?php
session_start();
include("fuggvenyek.php");

//POST-tal lekérjük az átküldött adatokat,
$v_kitol = $_POST['kitol'];
$v_kinek = $_POST['kinek'];
$v_mennyit = $_POST['mennyit'];

//ellenőrizzük, hogy kaptak-e értéket,
if (empty($v_kitol)){
	header("Location: utalasok.php?error=kitol");
	exit();
}
else if ( empty($v_kinek)) {
	header("Location: utalasok.php?error=kinek");
        exit();
}
else if(empty($v_mennyit)) {
		 header("Location: utalasok.php?error=mennyit");
        exit();
}

else {
	//adat tisztítása: karaktereket karakterkódokra cseréljük,
	$v_tiszta_kitol = htmlspecialchars($v_kitol);
	$v_tiszta_kinek = htmlspecialchars($v_kinek);
	$v_tiszta_mennyit = htmlspecialchars($v_mennyit);
	
	//beszúrjuk a rekordot az adatbázisba
	$sikeres = utalas($v_tiszta_kitol, $v_tiszta_kinek, $v_tiszta_mennyit);
	
	if ( $sikeres == false ) {
		die("Nem sikerült felvinni a rekordot.");
	}
	//visszatérünk az utalasok.php-re
	else{
		header("Location: utalasok.php?sikerult=Sikeres tranzakció!");
		exit();
	}
}

?>