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
			<th><a href="kezdolap.php"><span class="link">Kezdőlap</span></a></th>
			<th><a href="regisztracio.php"><span class="link">Regisztráció</span></a>
			<th>Bejelentkezés</th>
		</tr>
		</table>
	</BODY>
	<BODY>
		<div id="adatok"><h2>Belépés</h2>
		<?php
			if (!empty($_GET['kijelentkezett'])) {
			//kiírjuk az üzenetet
			$kijelentkezett= $_GET['kijelentkezett'];
			echo '<p style="color: green; font-size: 15px; margin-left: 20%;">' . htmlspecialchars($kijelentkezett) . '</p>';
			}
			if (!empty($_GET['regisztralt'])) {
			//kiírjuk az üzenetet
			$regisztralt= $_GET['regisztralt'];
			echo '<p style="color: green; font-size: 15px; margin-left: 20%;">' . htmlspecialchars($regisztralt) . '</p>';
			}
            // Hibaüzenet
            if (!empty($_GET["error"]) && $_GET["error"] === "azonosito") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Hibás azonosítót adott meg!</p>';
            }
			if (!empty($_GET["error"]) && $_GET["error"] === "felhasznalonev") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Hibás nevet adott meg!</p>';
            }
			if (!empty($_GET["error"]) && $_GET["error"] === "jelszo") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Hibás jelszót adott meg!</p>';
            }
            ?>
		<form method="POST" action="adatellenorzes.php" accept-charset"utf-8">
			<label>Azonosító:</label>
			<input type="text" name="azonosito"/>
			<br>
			<label>Név:</label>
			<input type="text" name="nev"/>
			<br>
			<label>Jelszó:</label>
			<input type="password" name="jelszo"/>
			<br>
			<input class="gomb" type="submit" value="Bejelentkezés"></input>
		</form>
		</div>
	</BODY>
</HTML>