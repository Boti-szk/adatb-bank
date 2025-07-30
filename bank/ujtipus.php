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
				echo '<th><a href="utalasok.php"><span class="link">Utalások kezelése</span></a></th>';
				echo '<th>Számlatípusok létrehozása</th>';
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
		<form method="POST" action="tipusletrehozas.php" accept-charset"utf-8">
		<div id="adatok"><h2>Új számlatípus létrehozása</h2>
		 <?php
            // Hibaüzenet
			 if (!empty($_GET["error"]) && $_GET["error"] === "tipusnev") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem adott meg típusnevet!</p>';
            }
			 if (!empty($_GET["error"]) && $_GET["error"] === "mettol") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott dátumot!</p>';
            }
			 if (!empty($_GET["error"]) && $_GET["error"] === "meddig") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott dátumot!</p>';
            }
			if (!empty($_GET["error"]) && $_GET["error"] === "ervenyesseg") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Az érvényesség vége nem lehet korábbi dátum mint a kezdete!</p>';
            }
			if (!empty($_GET["error"]) && $_GET["error"] === "tipusnev2") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Már van ilyen típusnév, adjon meg másikat!</p>';
            }
            ?>
		<label>Típus név:</label>
		<input type="text" name="tipusnev"/>
		<br>
		<label>Érvényesség kezdete:</label>
		<input type="datetime-local" name="mettol"/>
		<br>
		<label>Érvényesség vége:</label>
		<input type="datetime-local" name="meddig"/>
		<br>
		<input class="gomb" type="submit" value="Létrehozás"></input>
		<br>
		</form>
		
		
		<form method="POST" action="tipusallapotvaltas.php" accept-charset"utf-8">
		<h2>Számlatípus aktiválása/passziválása</h2>
		<?php
			if (!empty($_GET['valtoztatta'])) {
			//kiírjuk az üzenetet
			$valtoztatta= $_GET['valtoztatta'];
			echo '<p style="color: green; font-size: 15px; margin-left: 20%;">' . htmlspecialchars($valtoztatta) . '</p>';
			}
            // Hibaüzenet
			if (!empty($_GET["error"]) && $_GET["error"] === "tipusnevek") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott típusnevet!</p>';
            }
			if (!empty($_GET["error"]) && $_GET["error"] === "allapot") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott állapotot!</p>';
            }
            ?>
		<label>Típus név:</label>
		<?php
		// Számlatípusok lekérdezése
		$tipusnevek = "SELECT szamlatipus_neve FROM SZAMLATIPUSOK";
		$eredmeny = mysqli_query($conn, $tipusnevek);

		// Ellenőrizd a lekérdezést
		if (!$eredmeny) {
		die("Query failed: " . mysqli_error($conn));
		}
		?>
		<select style="margin-left:10px; min-width: 160px; display: inline-block; " name="tipusnevek">
		 <option value="" disabled selected>Válasszon számlatípust!</option>
		<?php
		// Adatok kiolvasása és a select elem feltöltése
		while ($row = mysqli_fetch_assoc($eredmeny)) {
        echo '<option value="' . $row['szamlatipus_neve'] . '">' . $row['szamlatipus_neve'] . '</option>';
		}
		?>
		</select>
		<br>
		<label>Állapot:</label>
		<select style="margin-left:10px; min-width: 160px; display: inline-block" name="allapot">
		<option value="" disabled selected>Válasszon  állapotot!</option>
		<option value="aktiv">Aktív</option>
		<option value="passziv">Passzív</option>
		</select>
		<br>
		<input class="gomb" type="submit" value="Módosítás"></input>
		<br>
		</form>
		
		
		<h2>Számlatípusok:</h2>
		<table>
		<tr>
			<th>Típus azonosító</th>
			<th>Típus név</th>
			<th>Érvényesség kezdete</th>
			<th>Érvényesség vége</th>
			<th>Állapot</th>
			
		</tr>
		<?php
		//kilistázzuk az adatbázis számlatípusok adatait
		$lista = "SELECT * FROM SZAMLATIPUSOK";
		//futtatás
		$eredmeny = mysqli_query($conn, $lista);
		if (!$eredmeny) {
		die("Lekérdezési hiba: " . mysqli_error($conn));
		}
		//végigmegyünk az eredményen
		while ($row = mysqli_fetch_assoc($eredmeny)) {
		echo "<tr><td>" . $row["tipus_azonosito"] . "</td><td>" . $row["szamlatipus_neve"] . "</td><td>" . $row["mettol_van_ervenyben"] . "</td>
		<td>" . $row["meddig_van_ervenyben"] . "</td><td>" . $row["allapot"] . "</td></tr>";
		}
		?>
		</table>
		</div>
	</BODY>
</HTML>