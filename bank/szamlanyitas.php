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
				echo '<th>Számlák kezelése</th>';
				echo '<th><a href="utalasok.php"><span class="link">Utalások kezelése</span></a></th>';
				echo '<th><a href="ujtipus.php"><span class="link">Számlatípusok létrehozása</span></a></th>';
				echo '<th><a href="bejelentkezve.php"><span class="link">Vissza</span></a></th>';
				echo '<th><a href="kijelentkezes.php"><span class="link">Kijelentkezés</span></a></th>';
			}

			//ügyfél nyitólapja bejelentkezés után
			else {
				// Az ügyfél szerepkörhöz tartozó átirányító link
				echo '<th>Számláim</th>';
				echo '<th><a href="utalasok.php"><span class="link">Utalásaim</span></a></th>';
				echo '<th><a href="bejelentkezve.php"><span class="link">Vissza</span></a></th>';
				echo '<th><a href="kijelentkezes.php"><span class="link">Kijelentkezés</span></a></th>';
			}
			?>
		
		</tr>
		</table>
		<br>
		<table>
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
			</table>
	</BODY>
	
	
	<BODY>
		<form method="POST" action="szamlaletrehozas.php" accept-charset"utf-8">
		<div id="adatok"><h2>Új számla létrehozása</h2>
			<?php
			if (!empty($_GET['letrehozta'])) {
			//kiírjuk az üzenetet
			$letrehozta= $_GET['letrehozta'];
			echo '<p style="color: green; font-size: 15px; margin-left: 20%;">' . htmlspecialchars($letrehozta) . '</p>';
			}
			// Hibaüzenet
			 if (!empty($_GET["error"]) && $_GET["error"] === "tipusnev") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott típusnevet!</p>';
            }
			 if (!empty($_GET["error"]) && $_GET["error"] === "egyenleg") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem adott meg nyitó egyenleget!</p>';
            }
			if (!empty($_GET["error"]) && $_GET["error"] === "osszeg") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Adjon meg tényleges összeget!</p>';
            }
			?>
		<label>Típus:</label>
		<?php
		// Számlatípusok lekérdezése
		$aktualisido = date('Y-m-d H:i:s');
		$aktiv = "SELECT szamlatipus_neve FROM SZAMLATIPUSOK WHERE allapot = 'aktív' AND meddig_van_ervenyben > '$aktualisido'";
		$eredmeny = mysqli_query($conn, $aktiv);

		// Ellenőrizd a lekérdezést
		if (!$eredmeny) {
		die("Query failed: " . mysqli_error($conn));
		}
		?>
		<select style="margin-left:10px; min-width: 160px; display: inline-block; " name="tipusnev">
		 <option value="" disabled selected>Válasszon számlatípust!</option>
		<?php
		// Adatok kiolvasása és a select elem feltöltése
		while ($row = mysqli_fetch_assoc($eredmeny)) {
        echo '<option value="' . $row['szamlatipus_neve'] . '">' . $row['szamlatipus_neve'] . '</option>';
		}
		?>
		</select>
		<br>
		<label>Nyitási egyenleg:</label>
		<input style="text-align: right" type="text" name="egyenleg"/>Ft
		<br>
		<input class="gomb" type="submit" value="Számlanyitás"></input>
		<br>
		</form>
		
		
		<form method="POST" action="szamlatorles.php" accept-charset"utf-8">
		<h2>Számla törlése</h2>
		<?php
		if (!empty($_GET['törölte'])) {
			//kiírjuk az üzenetet
			$törölte= $_GET['törölte'];
			echo '<p style="color: green; font-size: 15px; margin-left: 20%;">' . htmlspecialchars($törölte) . '</p>';
			}
			// Hibaüzenet
			  if (!empty($_GET["error"]) && $_GET["error"] === "szamlaszam") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott számlát!</p>';
            }
			?>
		<label>Számla:</label>
		<?php
		//Lekérdezzük azokat a számlaszámokat amelyek a birtokolja tábla alapján a bejelentkezett azonositohoz köthető(összekapcsoljuk a táblákat)
		$azonosito = $_SESSION['azonosito'];
		$letezik = "SELECT FOLYOSZAMLAK.szamlaszam FROM FOLYOSZAMLAK INNER JOIN BIRTOKOLJA ON FOLYOSZAMLAK.szamlaszam = BIRTOKOLJA.szamlaszam WHERE BIRTOKOLJA.azonosito = '$azonosito'";
		$eredmeny = mysqli_query($conn, $letezik);

		// Ellenőrizd a lekérdezést
		if (!$eredmeny) {
		die("Query failed: " . mysqli_error($conn));
		}
		?>
		<select style="margin-left:10px; min-width: 160px; display: inline-block; " name="szamlaszam">
		 <option value="" disabled selected>Válasszon számlát!</option>
		<?php
		// Adatok kiolvasása és a select elem feltöltése
		while ($row = mysqli_fetch_assoc($eredmeny)) {
        echo '<option value="' . $row['szamlaszam'] . '">' . $row['szamlaszam'] . '</option>';
		}
		?>
		</select>
		<br>
		<input class="gomb" type="submit" value="Törlés"></input>
		<br>
		</form>
		
		
		<form method="POST" action="egyenlegfeltoltes.php" accept-charset"utf-8">
		<h2>Számlára befizetés:</h2>
		<?php
		if (!empty($_GET['befizetve'])) {
			//kiírjuk az üzenetet
			$befizetve= $_GET['befizetve'];
			echo '<p style="color: green; font-size: 15px; margin-left: 20%;">' . htmlspecialchars($befizetve) . '</p>';
			}
			// Hibaüzenet
			  if (!empty($_GET["error"]) && $_GET["error"] === "szamlaszam") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott számlát!</p>';
            }
			 if (!empty($_GET["error"]) && $_GET["error"] === "osszeg") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem adott meg összeget!</p>';
            }
			?>
		<label>Számla:</label>
		<?php
		//Lekérdezzük azokat a számlaszámokat amelyek a birtokolja tábla alapján a bejelentkezett azonositohoz köthető(összekapcsoljuk a táblákat)
		$azonosito = $_SESSION['azonosito'];
		$letezik = "SELECT FOLYOSZAMLAK.szamlaszam FROM FOLYOSZAMLAK INNER JOIN BIRTOKOLJA ON FOLYOSZAMLAK.szamlaszam = BIRTOKOLJA.szamlaszam WHERE BIRTOKOLJA.azonosito = '$azonosito'";
		$eredmeny = mysqli_query($conn, $letezik);

		// Ellenőrizd a lekérdezést
		if (!$eredmeny) {
		die("Query failed: " . mysqli_error($conn));
		}
		?>
		<select style="margin-left:10px; min-width: 160px; display: inline-block; " name="szamlaszam">
		 <option value="" disabled selected>Válasszon számlát!</option>
		<?php
		// Adatok kiolvasása és a select elem feltöltése
		while ($row = mysqli_fetch_assoc($eredmeny)) {
        echo '<option value="' . $row['szamlaszam'] . '">' . $row['szamlaszam'] . '</option>';
		}
		?>
		</select>
		<br>
		<label>Befizetni kívánt összeg:</label>
		<input style="text-align: right" type="text" name="osszeg"/>Ft
		<br>
		<input class="gomb" type="submit" value="Befizetés"></input>
		<br>
		</form>
		
		
		<form method="POST" action="szamlaallapotvaltas.php" accept-charset"utf-8">
		<h2>Számla állapotának változtatása</h2>
		<?php
		if (!empty($_GET['valtoztatta'])) {
			//kiírjuk az üzenetet
			$valtoztatta= $_GET['valtoztatta'];
			echo '<p style="color: green; font-size: 15px; margin-left: 20%;">' . htmlspecialchars($valtoztatta) . '</p>';
			}
			// Hibaüzenet
			  if (!empty($_GET["error"]) && $_GET["error"] === "szamlaszam") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott számlát!</p>';
            }
			 if (!empty($_GET["error"]) && $_GET["error"] === "nyitzar") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott állapotot!</p>';
            }
			?>
		<label>Számla:</label>
		<?php
		//Lekérdezzük azokat a számlaszámokat amelyek a birtokolja tábla alapján a bejelentkezett azonositohoz köthető(összekapcsoljuk a táblákat)
		$azonosito = $_SESSION['azonosito'];
		$letezik = "SELECT FOLYOSZAMLAK.szamlaszam FROM FOLYOSZAMLAK INNER JOIN BIRTOKOLJA ON FOLYOSZAMLAK.szamlaszam = BIRTOKOLJA.szamlaszam WHERE BIRTOKOLJA.azonosito = '$azonosito'";
		$eredmeny = mysqli_query($conn, $letezik);

		// Ellenőrizd a lekérdezést
		if (!$eredmeny) {
		die("Query failed: " . mysqli_error($conn));
		}
		?>
		<select style="margin-left:10px; min-width: 160px; display: inline-block; " name="szamlaszam">
		 <option value="" disabled selected>Válasszon számlát!</option>
		<?php
		// Adatok kiolvasása és a select elem feltöltése
		while ($row = mysqli_fetch_assoc($eredmeny)) {
        echo '<option value="' . $row['szamlaszam'] . '">' . $row['szamlaszam'] . '</option>';
		}
		?>
		</select>
		<br>
		<label>Állapota:</label>
		<select style="margin-left:10px; min-width: 160px; display: inline-block" name="nyitzar">
			<option value="" disabled selected>Válasszon mit szeretne tenni!</option>
			<option value="nyitva">Nyitás</option>
			<option value="zarva">Zárás</option>
		</select>
		<br>
		<input class="gomb" type="submit" value="Változtatás"></input>
		<br>
		</form>
		
		
		<form method="POST" action="szamlatmegoszt.php" accept-charset"utf-8">
		<h2>Számla megosztása</h2>
		<?php
		if (!empty($_GET['megosztotta'])) {
			//kiírjuk az üzenetet
			$megosztotta= $_GET['megosztotta'];
			echo '<p style="color: green; font-size: 15px; margin-left: 20%;">' . htmlspecialchars($megosztotta) . '</p>';
			}
			// Hibaüzenet
			  if (!empty($_GET["error"]) && $_GET["error"] === "szamlaszam2") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott számlát!</p>';
            }
			 if (!empty($_GET["error"]) && $_GET["error"] === "kivel") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott személyt!</p>';
            }
			?>
		<label>Számla:</label>
		<?php
		//Lekérdezzük azokat a számlaszámokat amelyek a birtokolja tábla alapján a bejelentkezett azonositohoz köthető(összekapcsoljuk a táblákat)
		$azonosito = $_SESSION['azonosito'];
		$letezik = "SELECT FOLYOSZAMLAK.szamlaszam FROM FOLYOSZAMLAK INNER JOIN BIRTOKOLJA ON FOLYOSZAMLAK.szamlaszam = BIRTOKOLJA.szamlaszam WHERE BIRTOKOLJA.azonosito = '$azonosito'";
		$eredmeny = mysqli_query($conn, $letezik);

		// Ellenőrizd a lekérdezést
		if (!$eredmeny) {
		die("Query failed: " . mysqli_error($conn));
		}
		?>
		<select style="margin-left:10px; min-width: 160px; display: inline-block; " name="szamlaszam">
		 <option value="" disabled selected>Válasszon számlát!</option>
		<?php
		// Adatok kiolvasása és a select elem feltöltése
		while ($row = mysqli_fetch_assoc($eredmeny)) {
        echo '<option value="' . $row['szamlaszam'] . '">' . $row['szamlaszam'] . '</option>';
		}
		?>
		</select>
		<br>
		<label>Személy:</label>
		<?php
		// Számlatípusok lekérdezése
		$szemelyek = "SELECT azonosito FROM FELHASZNALOK WHERE azonosito <> '$azonosito' AND FELHASZNALOK.szerepkor='ugyfel'";
		$eredmeny = mysqli_query($conn, $szemelyek);

		// Ellenőrizd a lekérdezést
		if (!$eredmeny) {
		die("Query failed: " . mysqli_error($conn));
		}
		?>
		<select style="margin-left:10px; min-width: 160px; display: inline-block; " name="kivel">
		 <option value="" disabled selected>Válasszon személyt!</option>
		<?php
		// Adatok kiolvasása és a select elem feltöltése
		while ($row = mysqli_fetch_assoc($eredmeny)) {
        echo '<option value="' . $row['azonosito'] . '">' . $row['azonosito'] . '</option>';
		}
		?>
		</select>
		<br>
		<br>
		<input class="gomb" type="submit" value="Megosztás"></input>
		<br>
		</form>
		
		
		<h2>Számlák:</h2>
		<table>
		<tr>
			<th>Számlaszám</th>
			<th>Típusa</th>
			<th>Egyenleg</th>
			<th>Nyitás dátuma</th>
			<th>Zárolva</th>
			
		</tr>
		<?php
		//alkalmazott
			if ($_SESSION['szerepkor'] == 'alkalmazott'){
		//kilistázzuk az adatbázis számlaszámok adatait 
		$lista = "SELECT * FROM FOLYOSZAMLAK";
		//futtatás
		$eredmeny = mysqli_query($conn, $lista);
		if (!$eredmeny) {
		die("Lekérdezési hiba: " . mysqli_error($conn));
		}
		//végigmegyünk az eredményen
		while ($row = mysqli_fetch_assoc($eredmeny)) {
		echo "<tr><td>" . $row["szamlaszam"] . "</td><td>" . $row["tipus_azonosito"] . "</td><td>" . $row["egyenleg"] . "</td>
		<td>" . $row["mikor_nyitottak"] . "</td><td>" . $row["zarolva_van"] . "</td></tr>";
		}
		}
		
		//ügyfél
		else {
		$azonosito = $_SESSION['azonosito'];
		$lista = "SELECT * FROM FOLYOSZAMLAK INNER JOIN BIRTOKOLJA ON FOLYOSZAMLAK.szamlaszam = BIRTOKOLJA.szamlaszam WHERE BIRTOKOLJA.azonosito = $azonosito";
		$eredmeny = mysqli_query($conn, $lista);
		if (!$eredmeny) {
		die("Lekérdezési hiba: " . mysqli_error($conn));
		}

		while ($row = mysqli_fetch_assoc($eredmeny)) {
		echo "<tr><td>" . $row["szamlaszam"] . "</td><td>" . $row["tipus_azonosito"] . "</td><td>" . $row["egyenleg"] . "</td>
		<td>" . $row["mikor_nyitottak"] . "</td><td>" . $row["zarolva_van"] . "</td></tr>";
		}
		}
		?>
		</table>
			
		</div>
	</BODY>
</HTML>