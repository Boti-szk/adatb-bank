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
				echo '<th>Indított utalások összege<th>';
				echo '<th><a href="beerkezett.php"><span class="link">Beérkezett utalások összege</span></a></th>';
				echo '<th><a href="ervenytelen.php"><span class="link">Érvénytelen számlák</span></a></th>';
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
		<h2>Indított utalások összege:</h2>
		<table>
		<tr>
			<th>Év</th>
			<th>Hónap<//th>
			<th>Azonosító</th>
			<th>Név</th>
			<th>Összeg</th>

		</tr>
		<?php
		$lista = "SELECT YEAR(UTALASOK.idopontja) AS ev, MONTH(UTALASOK.idopontja) AS honap, UTALASOK.azonosito, SUM(UTALASOK.atutalas_osszege) AS osszeg, FELHASZNALOK.nev FROM UTALASOK INNER JOIN FELHASZNALOK ON FELHASZNALOK.azonosito=UTALASOK.azonosito GROUP BY ev, honap, UTALASOK.azonosito, FELHASZNALOK.nev;";
		//futtatás
		$eredmeny = mysqli_query($conn, $lista);
		if (!$eredmeny) {
		die("Lekérdezési hiba: " . mysqli_error($conn));
		}
		//végigmegyünk az eredményen
		while ($row = mysqli_fetch_assoc($eredmeny)) {
		echo "<tr><td>" . $row["ev"] . "</td><td>" . $row["honap"] . "</td><td>" . $row["azonosito"] . "</td><td>" . $row["nev"] . "</td><td>" . $row["osszeg"] . "</td>";
		}
		?>
		</table>
		
			
		</form>
		</div>
	</BODY>
</HTML>