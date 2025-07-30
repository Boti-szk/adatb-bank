<?php
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
				echo '<th><a href="kijelentkezes.php"><span class="link">Kijelentkezés</span></a></th>';
			}

			//ügyfél nyitólapja bejelentkezés után
			else {
				// Az alkalmazott szerepkörhöz tartozó átirányító link
				echo '<th><a href="szamlanyitas.php"><span class="link">Számláim</span></a><th>';
				echo '<th><a href="utalasok.php"><span class="link">Utalásaim</span></a></th>';
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
		<div id="adatok">
		<br>
			<?php
			if (!empty($_GET['bejelentkezett'])) {
			//kiírjuk az üzenetet
			$bejelentkezett= $_GET['bejelentkezett'];
			echo '<p style="color: green; font-size: 15px; margin-left: 45%;">' . htmlspecialchars($bejelentkezett) . '</p>';
			}
			?>
		
		
		<h3>Üdvözöljük!</h3>
		<form>
		<h3><pre>A fenti menüből tudja kiválasztani mit szeretne tenni!</pre></h3>
		
			
		</form>
		</div>
	</BODY>
</HTML>