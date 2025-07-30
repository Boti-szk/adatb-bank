<?php

//csatlakozunk a kiválasztott adatbázishoz
function bank_csatlakozas () {
	$conn = mysqli_connect("localhost", "root", "")
	or die("Csatlakozási hiba");
	if ( false == mysqli_select_db($conn, "BANK") ) {
		return NULL;
	}
	
	//karakterkódolás beállítása,
	mysqli_query($conn, 'SET NAMES UTF8');
	mysqli_query($conn, 'SET character_set_results=utf8');
	mysqli_set_charset($conn, 'utf8');
	
	return $conn;
}




function felhasznalot_beszur($azonosito, $nev, $jelszo, $jelszoujra, $szerepkor) {
	if ( !($conn = bank_csatlakozas()) ) {
		//ha nem sikerül csatlakozni kilépünk,
		return false;
	}
	
	//megnézzük egyeznek-e a megadott jelszók
	 if ($jelszo !== $jelszoujra) {
        header("Location: regisztracio.php?error=jelszo");
        exit();
    }
	
	//megnézzük adott-e meg szerepkört
	if($szerepkor != 'ugyfel' AND $szerepkor != 'alkalmazott') {
		header("Location: regisztracio.php?error=szerepkor");
		exit();
	} 
	
	//először ellenőrizzük, hogy van-e már a megadottal egyező azonosító a táblában,
	$stmt = mysqli_prepare( $conn, "SELECT * FROM FELHASZNALOK WHERE azonosito = ?");
	//bekötjük a aparamétereket
	mysqli_stmt_bind_param($stmt, "s", $azonosito);
	//lefuttatjuk az SQL utasítást
	mysqli_stmt_execute($stmt);
	//kiolvasás és eltárolás
	$eredmeny = mysqli_stmt_get_result($stmt);
		//ez adja vissza sikerült-e
	//ha van, akkor visszatérünk a regisztracio.php-re
	if (mysqli_num_rows($eredmeny) > 0) {
	header("Location: regisztracio.php?error=azonosito");
	exit();
	} else if ( strlen($azonosito) >= 20){
		header("Location: regisztracio.php?error=azonosito2");
		exit();
	}
	//ha nincs megyunk tovább
	
	//Titkosítjuk a jelszót
    $titkosjelszo = password_hash($jelszo, PASSWORD_DEFAULT);
	//előkészítjük az utasítást,
	$stmt = mysqli_prepare( $conn, "INSERT INTO FELHASZNALOK(azonosito, nev, jelszo, szerepkor) VALUES (?, ?, ?, ?)");
	
	//bekötjük a paramétereket
	mysqli_stmt_bind_param($stmt, "ssss", $azonosito, $nev, $titkosjelszo, $szerepkor);
	
	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
		//Ez adja vissza sikerült-e

	if ( $sikeres == false ) {
		die(mysqli_error($conn));
	}
	mysqli_close($conn);
	return $sikeres;
}




function bejelentkezik( $azonosito, $nev, $jelszo ) {
	if ( !($conn = bank_csatlakozas()) ) {
		//ha nem sikerül csatlakozni kilépünk,
		return false;
	}
	
	//Lekérdezzük az adatokat az azonosito alapján
	$stmt = mysqli_prepare( $conn, "SELECT * FROM FELHASZNALOK WHERE azonosito = ?");
	//bekötjük a paramétereket
	mysqli_stmt_bind_param($stmt, "s", $azonosito);
	//lefuttatjuk az SQL utasítást
	mysqli_stmt_execute($stmt);
	//kiolvasás és eltárolas,
	$eredmeny = mysqli_stmt_get_result($stmt);
		//Ez adja vissza sikerült-e
	//megnézzük van e ilyen azonosító megadva
	if ( mysqli_num_rows($eredmeny) == 1 ) {
		
		//kigyűjtjük sorban az adatokat
		$adatok = mysqli_fetch_assoc($eredmeny);
		if ($adatok['nev'] == $nev) {
            // a felhasználónév egyezik, ellenőrizzük a jelszót
            $titkosjelszo = $adatok['jelszo'];
            if (password_verify($jelszo, $titkosjelszo)) {
				// azonosítót és szerepkört sessionbe tároljuk
				session_start(); 
				$_SESSION['azonosito'] = $adatok['azonosito'];
				$_SESSION['szerepkor'] = $adatok['szerepkor'];

				//utolsó belépés frissítése
				$sql = 'UPDATE FELHASZNALOK SET bejelentkezve = 1, utolso_belepes_idopontja = CURRENT_TIMESTAMP WHERE azonosito = "'.$_SESSION["azonosito"].'"';
				$stmt = mysqli_stmt_init($conn);
				mysqli_stmt_prepare($stmt, $sql);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
                return $adatok;
            } else {
                header("Location: belepes.php?error=jelszo");
                exit();
            }
        } else {
            header("Location: belepes.php?error=felhasznalonev");
            exit();
        }
    } else {
        header("Location: belepes.php?error=azonosito");
        exit();
    }
}




function szamlat_beszur($tipusnev, $egyenleg) {
	if ( !($conn = bank_csatlakozas()) ) {
		//ha nem sikerül csatlakozni kilépünk,
		return false;
	}
	if($egyenleg < 0) {
		header("Location: szamlanyitas.php?error=osszeg");
		exit();
	}
	
	 // Lekérdezzük a számlatípus azonosítóját a név alapján
    $stmt = mysqli_prepare($conn, "SELECT tipus_azonosito FROM SZAMLATIPUSOK WHERE szamlatipus_neve = ?");
	//bekötjük a paramétereket
    mysqli_stmt_bind_param($stmt, "s", $tipusnev);
	//lefuttatjuk az SQL utasítást
    mysqli_stmt_execute($stmt);
	//kiolvasás és eltárolás
    $eredmeny = mysqli_stmt_get_result($stmt);

    // Ellenőrizzük, hogy létezik-e a számlatípus
    if ($row = mysqli_fetch_assoc($eredmeny)) {
        // A számlatípus létezik, így hozzáadhatjuk a FOLYOSZAMLAK táblához
        $tipus_azonosito = $row['tipus_azonosito'];

	$stmt = mysqli_prepare( $conn, "INSERT INTO FOLYOSZAMLAK(tipus_azonosito, egyenleg) VALUES (?, ?)");
	
	//bekötjük a paramétereket
	mysqli_stmt_bind_param($stmt, "id", $tipus_azonosito, $egyenleg );
	
	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
		//Ez adja vissza sikerült-e

	//megnézzük az utolsó beszúrt sort az adatbázis által adott egyedi azonosító alapján majd tároljuk
	$szamlaszam = $conn ->insert_id;
	//előkészítjük az utasítást,
	$stmt = mysqli_prepare( $conn, "INSERT INTO BIRTOKOLJA(azonosito, szamlaszam) VALUES (?, ?)");
	
	//bekötjük a paramétereket
	mysqli_stmt_bind_param($stmt, "si", $_SESSION["azonosito"], $szamlaszam);
	
	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
		//Ez adja vissza sikerült-e
	if ( $sikeres == false ) {
		die(mysqli_error($conn));
	}
	mysqli_close($conn);
	return $sikeres;
	}
}




function szamla_torles($szamlaszam) {
	if ( !($conn = bank_csatlakozas()) ) {
		//ha nem sikerül csatlakozni kilépünk,
		return false;
	}
	
	//előkészítjük az utasítást,
	$stmt = mysqli_prepare( $conn, "DELETE FROM FOLYOSZAMLAK WHERE szamlaszam = $szamlaszam");

	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
		//Ez adja vissza sikerült-e
	if ( $sikeres == false ) {
		die(mysqli_error($conn));
	}
	mysqli_close($conn);
	return $sikeres;
}




function befizetes($szamlaszam, $osszeg) {
	if ( !($conn = bank_csatlakozas()) ) {
		//ha nem sikerül csatlakozni kilépünk,
		return false;
	}
	
	//előkészítjük az utasítást,
	$stmt = mysqli_prepare( $conn, "UPDATE FOLYOSZAMLAK SET egyenleg = egyenleg + '$osszeg' WHERE szamlaszam = '$szamlaszam'");

	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
		//Ez adja vissza sikerült-e
	if ( $sikeres == false ) {
		die(mysqli_error($conn));
	}
	mysqli_close($conn);
	return $sikeres;
}




function szamlaallapotot_valtoztat($szamlaszam, $nyitzar) {
	if ( !($conn = bank_csatlakozas()) ) {
		//ha nem sikerül csatlakozni kilépünk,
		return false;
	}
	
	//először szűrünk a számlaszám alapján
	$stmt = mysqli_prepare( $conn, "SELECT * FROM FOLYOSZAMLAK WHERE szamlaszam = ?");
	
	//bekötjük a aparamétereket
	mysqli_stmt_bind_param($stmt, "i", $szamlaszam);
	
	//lefuttatjuk az SQL utasítást
	mysqli_stmt_execute($stmt);
	//kiolvasás és eltárolás
	$eredmeny = mysqli_stmt_get_result($stmt);
	// Ellenőrizzük, hogy létezik-e a számlaszám
    if ($row = mysqli_fetch_assoc($eredmeny)) {
        // A számlaszam létezik, így hozzáadhatjuk a FOLYOSZAMLAK táblához
        $szamlaszam = $row['szamlaszam'];
		
	
	$stmt = mysqli_prepare( $conn, "UPDATE FOLYOSZAMLAK SET zarolva_van = ? WHERE szamlaszam = ?");
	mysqli_stmt_bind_param($stmt, "si", $nyitzar, $szamlaszam);
	mysqli_stmt_execute($stmt);
	
	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
		//Ez adja vissza sikerült-e

	if ( $sikeres == false ) {
		die(mysqli_error($conn));
	}
	mysqli_close($conn);
	return $sikeres;
	}
}




function szamlat_megoszt ($szamlaszam, $kivel) {
	if ( !($conn = bank_csatlakozas()) ) {
		//ha nem sikerül csatlakozni kilépünk,
		return false;
	}
	
	//előkészítjük az utasítást,
	$stmt = mysqli_prepare( $conn, "INSERT INTO BIRTOKOLJA(szamlaszam, azonosito) VALUES (?, ?)");
	
	//bekötjük a paramétereket
	mysqli_stmt_bind_param($stmt, "is", $szamlaszam, $kivel);
	
	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
		//Ez adja vissza sikerült-e
	if ( $sikeres == false ) {
		die(mysqli_error($conn));
	}
	mysqli_close($conn);
	return $sikeres;
}




function utalas($kitol, $kinek, $mennyit) {
	if ( !($conn = bank_csatlakozas()) ) {
		//ha nem sikerül csatlakozni kilépünk,
		return false;
	}
	
	// SQL-lekérdezés a számlaegyenleg lekérdezésére
    $egyenleg = "SELECT egyenleg FROM folyoszamlak WHERE szamlaszam = $kitol";
    $eredmeny = mysqli_query($conn, $egyenleg);

	if (!$eredmeny) {
        die("Query failed: " . mysqli_error($conn));
    }

    // A lekérdezés eredménye egy asszociatív tömb lesz
    $row = mysqli_fetch_assoc($eredmeny);
	$egyenleg = $row['egyenleg'];
	//aktuális dátum-idő eltárolása
	$aktualis = date('Y-m-d H:i:s');
	
	if($mennyit <= 0) {
		$sikerult = "nem";
		header("Location: utalasok.php?error=osszeg");
	}
	else if(($egyenleg-$mennyit) < 0) {
		$sikerult = "nem";
		header("Location: utalasok.php?error=fedezet");
	}
	else{
		$sikerult = "igen";
	}
	$hatarido = date('Y-m-d H:i:s', strtotime('+3 day'));
	$stmt = mysqli_prepare( $conn, "INSERT INTO UTALASOK(azonosito, atutalas_osszege, teljesitesi_hatarido, sikerult, forras_szamlaszam, cel_szamlaszam) VALUES (?, ?, ?, ?, ?, ?)");
	//bekötjük a paramétereket
	mysqli_stmt_bind_param($stmt, "sdssii", $_SESSION["azonosito"], $mennyit, $hatarido, $sikerult, $kitol, $kinek);
	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
	
	if($sikerult == "nem"){
	exit();
	}
	else{
	$stmt = mysqli_prepare( $conn, "UPDATE FOLYOSZAMLAK SET egyenleg = egyenleg - '$mennyit' WHERE szamlaszam = '$kitol'");
	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
	
	$stmt = mysqli_prepare( $conn, "UPDATE FOLYOSZAMLAK SET egyenleg = egyenleg + '$mennyit' WHERE szamlaszam = '$kinek'");
	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
	
	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
		//Ez adja vissza sikerült-e

	if ( $sikeres == false ) {
		die(mysqli_error($conn));
	}
	mysqli_close($conn);
	return $sikeres;
	}	
}




function tipust_beszur($tipusnev, $mettol, $meddig) {
	if ( !($conn = bank_csatlakozas()) ) {
		//ha nem sikerül csatlakozni kilépünk,
		return false;
	}

	//megnézzük a dátumok jól vannak-e beállítva
	if($mettol > $meddig){
			header ("Location: ujtipus.php?error=ervenyesseg");
			exit();
	}
	
	//először ellenőrizzük, hogy van-e már a megadottal egyező típusnév a táblában,
	$stmt = mysqli_prepare( $conn, "SELECT * FROM SZAMLATIPUSOK WHERE szamlatipus_neve = ?");
	//bekötjük a aparamétereket
	mysqli_stmt_bind_param($stmt, "s", $tipusnev);
	//lefuttatjuk az SQL utasítást
	mysqli_stmt_execute($stmt);
	//kiolvasás és eltárolás
	$eredmeny = mysqli_stmt_get_result($stmt);
	
	//ha van visszalépünk az ujtipus.php-re
	if (mysqli_num_rows($eredmeny) > 0) {
	header("Location: ujtipus.php?error=tipusnev2");
	exit();
	}

	$stmt = mysqli_prepare( $conn, "INSERT INTO SZAMLATIPUSOK(szamlatipus_neve, mettol_van_ervenyben, meddig_van_ervenyben) VALUES (?, ?, ?)");
	
	//bekötjük a paramétereket
	mysqli_stmt_bind_param($stmt, "sss", $tipusnev, $mettol, $meddig);
	
	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
		//Ez adja vissza sikerült-e

	if ( $sikeres == false ) {
		die(mysqli_error($conn));
	}
	mysqli_close($conn);
	return $sikeres;
}




function tipusallapotot_valtoztat($tipusnevek, $allapot) {
	if ( !($conn = bank_csatlakozas()) ) {
		//ha nem sikerül csatlakozni kilépünk,
		return false;
	}
	
	//először ellenőrizzük, hogy van-e már a megadottal egyező típusnév a táblában,
	$stmt = mysqli_prepare( $conn, "SELECT * FROM SZAMLATIPUSOK WHERE szamlatipus_neve = ?");
	
	//bekötjük a aparamétereket
	mysqli_stmt_bind_param($stmt, "s", $tipusnevek);
	
	//lefuttatjuk az SQL utasítást
	mysqli_stmt_execute($stmt);
	//kiolvasás és eltárolás
	$eredmeny = mysqli_stmt_get_result($stmt);
	// Ellenőrizzük, hogy létezik-e a számlatípus
    if ($row = mysqli_fetch_assoc($eredmeny)) {
		//ha igen akkor kiszűrjök a tömbből
        $szamlatipus_neve = $row['szamlatipus_neve'];
	
	
	$stmt = mysqli_prepare( $conn, "UPDATE SZAMLATIPUSOK SET allapot = ? WHERE szamlatipus_neve = ?");
	mysqli_stmt_bind_param($stmt, "ss", $allapot, $szamlatipus_neve);
	mysqli_stmt_execute($stmt);
	
	//lefuttatjuk az SQL utasítást(kiolvasás és eltárolas),
	$sikeres = mysqli_stmt_execute($stmt);
		//Ez adja vissza sikerült-e

	if ( $sikeres == false ) {
		die(mysqli_error($conn));
	}
	mysqli_close($conn);
	return $sikeres;
	}
}	
?>