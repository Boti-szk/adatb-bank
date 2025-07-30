<?php
	//session leállítása
	session_start();
	include("fuggvenyek.php");
	
	if ( !($conn = bank_csatlakozas()) ) {
		//ha nem sikerül csatlakozni kilépünk,
		exit ();
	}
	//átállítjuk a bejelentkezés állapotát a sessionbe tárolt személynél
	$sql = 'UPDATE FELHASZNALOK SET bejelentkezve = 0 WHERE azonosito = "'.$_SESSION["azonosito"].'"';
	//statement objektum inivializálása
	$stmt = mysqli_stmt_init($conn);
	//előkészítjük, végrehajtjuk majd bezárjuk
	mysqli_stmt_prepare($stmt, $sql);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	//töröljük a sessiont
	session_destroy();
	session_unset();
	
	//visszalepünk a belepes.php-ra
	header("Location:belepes.php?kijelentkezett=Sikeresen kijelentkezett!");

?>