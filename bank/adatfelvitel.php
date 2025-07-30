<?php

include "fuggvenyek.php";

$nev = $_POST['nev'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$jelszo = $_POST['jelszo'];
$jelszo2 = $_POST['jelszo2'];
$nem = $_POST['nem'];
$kedvenc = $_POST['kedvenc'];

if ( empty($nev) || empty($email) || empty($tel) || empty($jelszo) || empty($jelszo2) || empty($nem) || empty($kedvenc)) {
    header("Location: regisztracio.php?error=kitoltes");
    exit();

}

else {

    if (strlen($jelszo) > 64 || strlen($jelszo2) > 64) {
        header("Location: regisztracio.php?error=jelszohossz");
        exit();
    }

    if (strlen($jelszo) < 8 || strlen($jelszo2) < 8){
        header("Location: regisztracio.php?error=jelszohossz2");
        exit();
    }

    if (strlen($nev) > 100) {
        header("Location: regisztracio.php?error=nevhossz");
        exit();
    }

    if (empty($nem)){
        header("Location: regisztracio.php?error=nem");
        exit();
    }

    if ($jelszo != $jelszo2){
        header("Location: regisztracio.php?error=nemegyezik");
        exit();
    }

    $users = load_users("users.json");
    foreach ($users["users"] as $felhasznalok) {
        $userdata = $felhasznalok[0];
        if ($userdata["nev"] == $nev) {
            header("Location: regisztracio.php?error=nev_letezik");
            exit();
        }
        if ($userdata["email"] == $email) {
            header("Location: regisztracio.php?error=email_letezik");
            exit();
        }
        if ($userdata["tel"] == $tel) {
            header("Location: regisztracio.php?error=tel_letezik");
            exit();
        }
    }

    $hashelt_jelszo = password_hash($jelszo, PASSWORD_DEFAULT);
    $fiok["users"][] = [
        "nev" => $nev,
        "email" => $email,
        "tel" => $tel,
        "jelszo" => $hashelt_jelszo,
        "nem" => $nem,
        "kedvenc" => $kedvenc
    ];

    save_users("users.json", $fiok);
    header("Location: bejelentkezes.php?regisztralt=sikeres");
}

?>
