<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");
require("includes/registrierung.inc.php");

$msg = "";
$idUser = null;

if(count($_POST)>0) {
    ta($_POST);
    $e = $_POST["E"];
    if(filter_var($e, FILTER_VALIDATE_EMAIL)) {
        $sql = "
            SELECT
                COUNT(*) AS cnt
            FROM tbl_user
            WHERE(
                Emailadresse='" . $e . "'
            )
        ";
        $userliste = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
        $user = $userliste->fetch_object();
        if($user->cnt==0) {
            //Emailadresse noch nicht vorhanden
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
                        INSERT INTO tbl_user
                            (FIDRolle,Emailadresse,Vorname,Nachname,GebDatum,FIDGebLand,FIDGeschlecht)
                        VALUES (
                            1,
                            " . value_set($e) . ",
                            " . value_set($_POST["VN"]) . ",
                            " . value_set($_POST["NN"]) . ",
                            " . value_set($_POST["GD"]) . ",
                            " . value_set($_POST["IDStaat"],false) . ",
                            " . value_set($_POST["IDGeschlecht"],false) . "
                        )
                    ";
                    ta($sql);
                    $ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
                    if($ok) {
                        $idUser = $conn->insert_id;

                        $sql = "
                            INSERT INTO tbl_passwoerter
                                (FIDUser,Passwort)
                            VALUES(
                                " . $idUser . ",
                                " . quotes_add($p0) . "
                            )
                        ";
                        $ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
                        if($ok) {
                            $msg = '<p class="success">Vielen Dank. Sie wurden erfolgreich registriert.</p>';
                        }
                        else {
                            $msg = '<p class="error">Fehler bei der Registrierung (2).</p>';
                        }
                    }
                    else {
                        $msg = '<p class="error">Fehler bei der Registrierung (1).</p>';
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
        else {
            $msg = '<p class="error">Diese Emailadresse ist in unserem System bereits registriert. Bitte loggen Sie sich ein.</p>';
        }
    }
    else {
        $msg = '<p class="error">Das ist keine gültige Emailadresse.</p>';
    }
}

if(count($_FILES)>0 && !is_null($idUser)) {
    ta($_FILES);
    $f = $_FILES["PB"];
    if($f["error"]==0) {
        $dir = "profilbilder/".$idUser."/";
        if(!file_exists($dir)) {
            $ok = mkdir($dir,0755,true);
        }
        else {
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
                        IDUser=" . $idUser . "
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
		<title>Registrierung</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="index.html">Startseite</a></li>
				<li><a href="login.php">Login (Profil)</a></li>
				<li><a href="login_admin.php">Login (Admin)</a></li>
			</ul>
		</nav>
        <?php echo($msg); ?>
        <form method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>verpflichtende Angaben</legend>
                <label>
                    Emailadresse:
                    <input type="email" name="E" required>
                </label>
                <label>
                    Passwort (mind. 8 Zeichen, mind. ein Groß- und ein Kleinbuchstabe, mind. ein Sonderzeichen):
                    <input type="password" name="P0" required>
                    <input type="password" name="P1" required placeholder="Passwort wiederholen">
                </label>
            </fieldset>
            <fieldset>
                <legend>freiwillige Angaben</legend>
                <label>
                    Vorname:
                    <input type="text" name="VN">
                </label>
                <label>
                    Nachname:
                    <input type="text" name="NN">
                </label>
                <label>
                    Geschlecht:
                    <?php 
                    echo(geschlechter_show());
                    ?>
                </label>
                <label>
                    Geburtsdatum:
                    <input type="date" name="GD">
                </label>
                <label>
                    Geburtsland:
                    <?php
                    echo(staaten_show());
                    ?>
                </label>
                <label>
                    Profilbild:
                    <input type="file" name="PB">
                </label>
            </fieldset>
            <input type="submit" value="registrieren">
        </form>
	</body>
</html>