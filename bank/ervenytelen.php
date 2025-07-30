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
				echo '<th><a href="ujtipus.php"><span class="link">Számlatípusok létrehozása</span></a></th>';
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
				echo '<th>Érvénytelen számlák</th>';
				echo '<th><a href="egyenlegnelkuli.php"><span class="link">Egyenleg nélküli számlák</span></a></th>';
			}
			?>
		
		</tr>
		</table>
	</BODY>
	
	
	<BODY>

		<div id="adatok">
		<br>
		<form>
		<h2>Érvénytelen számlák:</h2>
		<table>
		<tr>
			<th>Azonosító</th>
			<th>Név</th>
			<th>Számlák darabszáma</th>

		</tr>
		<?php
		$lista = "SELECT FELHASZNALOK.azonosito AS id, FELHASZNALOK.nev AS nev, COUNT(FOLYOSZAMLAK.szamlaszam) AS szamlak FROM FELHASZNALOK INNER JOIN BIRTOKOLJA ON BIRTOKOLJA.azonosito = FELHASZNALOK.azonosito INNER JOIN FOLYOSZAMLAK ON FOLYOSZAMLAK.szamlaszam = BIRTOKOLJA.szamlaszam INNER JOIN SZAMLATIPUSOK ON FOLYOSZAMLAK.tipus_azonosito = SZAMLATIPUSOK.tipus_azonosito WHERE MONTH(SZAMLATIPUSOK.meddig_van_ervenyben) < MONTH(DATE_ADD(NOW(), INTERVAL 1 MONTH)) AND YEAR(SZAMLATIPUSOK.meddig_van_ervenyben) = YEAR(DATE_ADD(NOW(), INTERVAL 1 MONTH)) GROUP BY id, nev;;";
		//futtatás
		$eredmeny = mysqli_query($conn, $lista);
		if (!$eredmeny) {
		die("Lekérdezési hiba: " . mysqli_error($conn));
		}
		//végigmegyünk az eredményen
		while ($row = mysqli_fetch_assoc($eredmeny)) {
		echo "<tr><td>" . $row["azonosito"] . "</td><td>" . $row["nev"] . "</td>";
		}
		?>
		</table>
		
			
		</form>
		</div>
	</BODY>
</HTML>