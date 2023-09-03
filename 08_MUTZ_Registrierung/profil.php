<?php
require("includes/login_logout.inc.php");

require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");
require("includes/registrierung.inc.php");

$msg = "";

if(count($_POST)>0) {
    ta($_POST);
    $sql = "
        UPDATE tbl_user SET
            Vorname=" . value_set($_POST["VN"]) . ",
            Nachname=" . value_set($_POST["NN"]) . ",
            GebDatum=" . value_set($_POST["GD"]) . ",
            FIDGebLand=" .value_set($_POST["IDStaat"],false) . ",
            FIDGeschlecht=" . value_set($_POST["IDGeschlecht"],false) . "
        WHERE(
            IDUser=" . $_SESSION["idUser"] . "
        )
    ";
    ta($sql);
    $ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
    if(!$ok) {
        $msg = '<p class="error">Fehler beim Speichern des Profils.</p>';
    }
    
    if(strlen($_POST["P0"])>0) {
        $p0 = $_POST["P0"];
        $p1 = $_POST["P1"];
        
        if($p0==$p1) {
            //Passwörter stimmen überein
            if(
                strlen($p0)>=8 &&
                validate_string($p0,"uppercase") &&
                validate_string($p0,"lowercase") &&
                validate_string($p0,"special")
            ) {
                $sql = "
                    INSERT INTO tbl_passwoerter
                        (FIDUser,Passwort)
                    VALUES(
                        " . $_SESSION["idUser"] . ",
                        " . quotes_add($p0) . "
                    )
                ";
                $ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
                
                if(!$ok) {
                    $msg = '<p class="error">Fehler beim Speichern des Passwortes.</p>';
                }
            }
            else {
                $msg = '<p class="error">Das Passwort erfüllt die Passwort-Kriterien nicht.</p>';
            }
        }
        else {
            $msg = '<p class="error">Die Passwörter stimmen nicht überein.</p>';
        }
    }
}

if(count($_FILES)>0) {
    ta($_FILES);
    $f = $_FILES["PB"];
    if($f["error"]==0) {
        $dir = "profilbilder/".$_SESSION["idUser"]."/";
        if(!file_exists($dir)) {
            $ok = mkdir($dir,0755,true);
        }
        else {
            dir_content_erase("profilbilder/".$_SESSION["idUser"]."/");
            $ok = true;
        }
        
        if($ok) {
            $ok = move_uploaded_file($f["tmp_name"],$dir.$f["name"]);
            if(!$ok) {
                $msg = '<p class="error">Leider konnte das Profilbild nicht gespeichert werden (1).</p>';
            }
            else {
                $sql = "
                    UPDATE tbl_user SET
                        Profilbild=" . quotes_add($dir.$f["name"]) . "
                    WHERE(
                        IDUser=" . $_SESSION["idUser"] . "
                    )
                ";
                $ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
                if(!$ok) {
                    $msg = '<p class="error">Leider konnte das Profilbild nicht gespeichert werden (2).</p>';
                }
            }
        }
    }
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Profil</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
		<link rel="stylesheet" href="css/registrierung.css">
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="index.html">Startseite</a></li>
				<li><a href="registrierung.php">Registrierung</a></li>
				<li><a href="login_admin.php">Login (Admin)</a></li>
			</ul>
		</nav>
        <form method="post">
            <input type="submit" name="btnLogout" value="logout">
        </form>
        <?php
        echo($msg);
        
        $sql ="
            SELECT
                *
            FROM tbl_user
            WHERE(
                IDUser=" . $_SESSION["idUser"] . "
            )
        ";
        $userliste = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
        $user = $userliste->fetch_object();
        ?>
        <form method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Passwort ändern für <?php echo($user->Emailadresse); ?></legend>
                <label>
                    Passwort (mind. 8 Zeichen, mind. ein Groß- und ein Kleinbuchstabe, mind. ein Sonderzeichen):
                    <input type="password" name="P0">
                    <input type="password" name="P1" placeholder="Passwort wiederholen">
                </label>
            </fieldset>
            <fieldset>
                <legend>freiwillige Angaben</legend>
                <label>
                    Vorname:
                    <input type="text" name="VN" value="<?php echo($user->Vorname); ?>">
                </label>
                <label>
                    Nachname:
                    <input type="text" name="NN" value="<?php echo($user->Nachname); ?>">
                </label>
                <label>
                    Geschlecht:
                    <?php 
                    echo(geschlechter_show($user->FIDGeschlecht));
                    ?>
                </label>
                <label>
                    Geburtsdatum:
                    <input type="date" name="GD" value="<?php echo($user->GebDatum); ?>">
                </label>
                <label>
                    Geburtsland:
                    <?php
                    echo(staaten_show($user->FIDGebLand));
                    ?>
                </label>
                <label>
                    Profilbild:
                    <input type="file" name="PB">
                    <?php
                    echo(profilbild_show($user->Profilbild));
                    ?>
                </label>
            </fieldset>
            <input type="submit" value="Profil aktualisieren">
        </form>
	</body>
</html>