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
				echo '<th><a href="ervenytelen.php"><span class="link">Érvénytelen számlák</span></a></th>';
				echo '<th>Egyenleg nélküli számlák</th>';
			}
			?>
		
		</tr>
		</table>
	</BODY>
	
	
	<BODY>

		<div id="adatok">
		<br>
		<form>
		<h2>Egyenleg nélküli számlák:</h2>
		<table>
		<tr>
			<th>Azonosító</th>
			<th>Név</th>

		</tr>
		<?php
		$lista = "SELECT DISTINCT FELHASZNALOK.azonosito, FELHASZNALOK.nev FROM FELHASZNALOK INNER JOIN BIRTOKOLJA ON BIRTOKOLJA.azonosito=FELHASZNALOK.azonosito INNER JOIN FOLYOSZAMLAK ON FOLYOSZAMLAK.szamlaszam=BIRTOKOLJA.szamlaszam WHERE FOLYOSZAMLAK.egyenleg=0;";
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