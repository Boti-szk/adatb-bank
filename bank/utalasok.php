<?php
include('fuggvenyek.php');

		// Adatbázis kapcsolat létrehozása
		$conn = bank_csatlakozas();

	session_start();
?>


<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<meta http-equiv="content-type" content="text/html; charset="utf-8" >
		<title>GOLDEN BANK</title>
		<link rel="stylesheet" href="asd.css">
	</HEAD>
	<BODY>
		<h1>GOLDEN BANK</h1>
		<table>
		<tr>
			
			<?php
			//alkalmazott nyitólapja bejelentkezés után
			if ($_SESSION['szerepkor'] == 'alkalmazott'){
				// Az alkalmazott szerepkörhöz tartozó átirányító link
				echo '<th><a href="szamlanyitas.php"><span class="link">Számlák kezelése</span></a><th>';
				echo '<th>Utalások kezelése</th>';
				echo '<th><a href="ujtipus.php"><span class="link">Számlatípusok létrehozása</span></a></th>';
				echo '<th><a href="bejelentkezve.php"><span class="link">Vissza</span></a></th>';
				echo '<th><a href="kijelentkezes.php"><span class="link">Kijelentkezés</span></a></th>';
			}

			//ügyfél nyitólapja bejelentkezés után
			else {
				// Az alkalmazott szerepkörhöz tartozó átirányító link
				echo '<th><a href="szamlanyitas.php"><span class="link">Számláim</span></a><th>';
				echo '<th>Utalásaim</th>';
				echo '<th><a href="bejelentkezve.php"><span class="link">Vissza</span></a></th>';
				echo '<th><a href="kijelentkezes.php"><span class="link">Kijelentkezés</span></a></th>';
			}
			?>
		
		</tr>
		</table>
		<br>
		<table>
		<tr>
			
			<?php
			//alkalmazott nyitólapja bejelentkezés után
			if ($_SESSION['szerepkor'] == 'alkalmazott'){
				// Az alkalmazott szerepkörhöz tartozó átirányító link
				echo '<th><a href="inditott.php"><span class="link">Indított utalások összege</span></a><th>';
				echo '<th><a href="beerkezett.php"><span class="link">Beérkezett utalások összege</span></a></th>';
				echo '<th><a href="ervenytelen.php"><span class="link">Érvénytelen számlák</span></a></th>';
				echo '<th><a href="egyenlegnelkuli.php"><span class="link">Egyenleg nélküli számlák</span></a></th>';
			}
			?>
		
		</tr>
		</table>
	</BODY>
	
	<BODY>
		<form method="POST" action="utalas.php" accept-charset"utf-8">
		<div id="adatok"><h2>Utalások kezelése</h2>
			<?php
			if (!empty($_GET['sikerult'])) {
			//kiírjuk az üzenetet
			$sikerult= $_GET['sikerult'];
			echo '<p style="color: green; font-size: 15px; margin-left: 20%;">' . htmlspecialchars($sikerult) . '</p>';
			}
			// Hibaüzenet
			  if (!empty($_GET["error"]) && $_GET["error"] === "kitol") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott kezdeményező számlaszámot!</p>';
            }
			 if (!empty($_GET["error"]) && $_GET["error"] === "kinek") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott cél számlaszámot!</p>';
            }
			 if (!empty($_GET["error"]) && $_GET["error"] === "mennyit") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem adott meg összeget!</p>';
            }
			if (!empty($_GET["error"]) && $_GET["error"] === "hatarido") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott határidőt!</p>';
            }
			 if (!empty($_GET["error"]) && $_GET["error"] === "osszeg") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Adjon meg tényleges összeget!</p>';
            }
			if (!empty($_GET["error"]) && $_GET["error"] === "fedezet") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nincs elég fedezet a számláján!</p>';
            }
			if (!empty($_GET["error"]) && $_GET["error"] === "hatarido2") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Csak az akutális dátumnál későbbi határidőt adhat meg!</p>';
            }
			?>
		<label>Kezdeményező számlaszám:</label>
		<?php
		if ($_SESSION['szerepkor'] == 'alkalmazott'){
		//kilistázzuk az adatbázis számlatípusok adatait
		$letezik = "SELECT szamlaszam FROM FOLYOSZAMLAK";
		$eredmeny = mysqli_query($conn, $letezik);
		if (!$eredmeny) {
		die("Lekérdezési hiba: " . mysqli_error($conn));
		}
		?>
		<select style="margin-left:10px; min-width: 160px; display: inline-block; " name="kitol">
		 <option value="" disabled selected>Válasszon számlát!</option>
		<?php
		// Adatok kiolvasása és a select elem feltöltése
		while ($row = mysqli_fetch_assoc($eredmeny)) {
        echo '<option value="' . $row['szamlaszam'] . '">' . $row['szamlaszam'] . '</option>';
		}
		?>
		</select>
		<br>
		<?php
		}
		if ($_SESSION['szerepkor'] == 'ugyfel'){
		//Lekérdezzük azokat a számlaszámokat amelyek a birtokolja tábla alapján a bejelentkezett azonositohoz köthető(összekapcsoljuk a táblákat)
		$azonosito = $_SESSION['azonosito'];
		$letezik = "SELECT FOLYOSZAMLAK.szamlaszam FROM FOLYOSZAMLAK INNER JOIN BIRTOKOLJA ON FOLYOSZAMLAK.szamlaszam = BIRTOKOLJA.szamlaszam WHERE BIRTOKOLJA.azonosito = '$azonosito' AND FOLYOSZAMLAK.zarolva_van = 'nyitva'";
		$eredmeny = mysqli_query($conn, $letezik);

		// Ellenőrizd a lekérdezést
		if (!$eredmeny) {
		die("Query failed: " . mysqli_error($conn));
		}
		?>
		<select style="margin-left:10px; min-width: 160px; display: inline-block; " name="kitol">
		 <option value="" disabled selected>Válasszon számlát!</option>
		<?php
		// Adatok kiolvasása és a select elem feltöltése
		while ($row = mysqli_fetch_assoc($eredmeny)) {
        echo '<option value="' . $row['szamlaszam'] . '">' . $row['szamlaszam'] . '</option>';
		}
		}
		?>
		</select>
		<br>
		<label>Cél számlaszám:</label>
		<?php
		//Lekérdezzük azokat a számlaszámokat amelyek a birtokolja tábla alapján a bejelentkezett azonositohoz nem köthető(összekapcsoljuk a táblákat)
		$azonosito = $_SESSION['azonosito'];
		$letezik = "SELECT DISTINCT FOLYOSZAMLAK.szamlaszam FROM FOLYOSZAMLAK INNER JOIN BIRTOKOLJA ON FOLYOSZAMLAK.szamlaszam = BIRTOKOLJA.szamlaszam WHERE BIRTOKOLJA.azonosito <> '$azonosito'";
		$eredmeny = mysqli_query($conn, $letezik);

		// Ellenőrizd a lekérdezést
		if (!$eredmeny) {
		die("Query failed: " . mysqli_error($conn));
		}
		?>
		<select style="margin-left:10px; min-width: 160px; display: inline-block; " name="kinek">
		 <option value="" disabled selected>Válasszon számlát!</option>
		<?php
		// Adatok kiolvasása és a select elem feltöltése
		while ($row = mysqli_fetch_assoc($eredmeny)) {
        echo '<option value="' . $row['szamlaszam'] . '">' . $row['szamlaszam'] . '</option>';
		}
		?>
		</select>
		<br>
		<label>Összeg:</label>
		<input style="text-align: right" type="text" name="mennyit"/>Ft
		<br>
		<input class="gomb" type="submit" value="Utalás"></input>
		</form>
		<h2>Utalások:</h2>
		<table>
		<tr>
			<th>Utalás azonosítója</th>
			<th>Azonosító</th>
			<th>Forrás számlaszám</th>
			<th>Cél számlaszám</th>
			<th>Időpont</th>
			<th>Összeg</th>
			<th>Határidő</th>
			<th>Sikerült</th>
			
		</tr>
		<?php
		//alkalmazott
			if ($_SESSION['szerepkor'] == 'alkalmazott'){
		//kilistázzuk az adatbázis számlatípusok adatait
		$lista = "SELECT * FROM UTALASOK";
		$eredmeny = mysqli_query($conn, $lista);
		if (!$eredmeny) {
		die("Lekérdezési hiba: " . mysqli_error($conn));
		}
		while ($row = mysqli_fetch_assoc($eredmeny)) {
		echo "<tr><td>" . $row["utalas_azonositoja"] . "</td><td>" . $row["azonosito"] . "</td><td>" . $row["forras_szamlaszam"] . "</td>
		<td>" . $row["cel_szamlaszam"] . "</td><td>" . $row["idopontja"] . "</td><td>" . $row["atutalas_osszege"] . "</td>
		<td>" . $row["teljesitesi_hatarido"] . "</td><td>" . $row["sikerult"] . "</td></tr>";
		}
		}
		
		//ügyfél
		else {
		$azonosito = $_SESSION['azonosito'];
		$lista = "SELECT * FROM UTALASOK INNER JOIN FELHASZNALOK ON UTALASOK.azonosito = FELHASZNALOK.azonosito WHERE FELHASZNALOK.azonosito = $azonosito";
		$eredmeny = mysqli_query($conn, $lista);
		if (!$eredmeny) {
		die("Lekérdezési hiba: " . mysqli_error($conn));
		}

		while ($row = mysqli_fetch_assoc($eredmeny)) {
		echo "<tr><td>" . $row["utalas_azonositoja"] . "</td><td>" . $row["azonosito"] . "</td><td>" . $row["forras_szamlaszam"] . "</td>
		<td>" . $row["cel_szamlaszam"] . "</td><td>" . $row["idopontja"] . "</td><td>" . $row["atutalas_osszege"] . "</td>
		<td>" . $row["teljesitesi_hatarido"] . "</td><td>" . $row["sikerult"] . "</td></tr>";
		}
		}
		?>
		</table>
		</div>
	</BODY>
</HTML>