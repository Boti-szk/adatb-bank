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
			<th>Regisztráció</th>
			<th><a href="belepes.php"><span class="link">Bejelentkezés</span></a></th>
		</tr>
		</table>
	</BODY>
	
	<BODY>
		<div id="adatok"><h2>Regisztráció</h2>
		 <?php
            // Hibaüzenet
			 if (!empty($_GET["error"]) && $_GET["error"] === "kitoltes") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem töltött ki minden mezőt!</p>';
            }
            if (!empty($_GET["error"]) && $_GET["error"] === "azonosito") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Ez az azonosító már létezik, kérem adjon meg másikat!</p>';
            }
			 if (!empty($_GET["error"]) && $_GET["error"] === "azonosito2") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Túl hosszú azonosítót adott meg!</p>';
            }
			  if (!empty($_GET["error"]) && $_GET["error"] === "jelszo") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">A jelszók nem egyeznek!</p>';
            }
			 if (!empty($_GET["error"]) && $_GET["error"] === "szerepkor") {
                echo '<p style="color: red; font-size: 15px; margin-left: 20%;">Nem választott szerepkört!</p>';
            }
            ?>
		<form method="POST" action="adatfelvitel.php" accept-charset"utf-8">
			<label>Azonosító:</label>
			<input type="text" name="azonosito"/>
			<br>
			<label>Név:</label>
			<input type="text" name="nev"/>
			<br>
			<label>Jelszó:</label>
			<input type="password" name="jelszo"/>
			<br>
			<label>Jelszó mégegyszer:</label>
			<input type="password" name="jelszoujra"/>
			<br>
			<label>Szerepkör:</label>
			<select style="margin-left:10px; min-width: 160px; display: inline-block" name="szerepkor">
			<option value="" disabled selected>Válasszon szerepkört!</option>
			<option value="ugyfel">Ügyfél vagyok</option>
			<option value="alkalmazott">Banki alkalmazott vagyok</option>
			</select>
			<br>
			<label>Amennyiben már rendelkezik felhasználói fiókkal kattintson a <a href="belepes.php"><span style="color:black;">ide</span></a> vagy a lap tetején a belépés menüpontra.</label>
			<br>
			<input class="gomb" type="submit" value="Regisztráció"></input>
		</form>
		</div>
	</BODY>
</HTML>

