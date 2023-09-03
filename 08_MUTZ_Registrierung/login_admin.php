<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");
require("includes/registrierung.inc.php");

$msg = "";

if(count($_POST)>0) {
    ta($_POST);
    $e = $_POST["E"];
    $p = $_POST["P"];
    $sql = "
        SELECT
            tbl_user.IDUser,
            tbl_rollen.Berechtigungsstufe
        FROM tbl_user
        INNER JOIN tbl_rollen ON tbl_rollen.IDRolle=tbl_user.FIDRolle
        WHERE(
            tbl_user.Emailadresse=" . quotes_add($e) . " AND
            (
                SELECT Passwort
                FROM tbl_passwoerter
                WHERE(
                    FIDUser=IDUser
                )
                ORDER BY Nutzungszeitpunkt DESC
                LIMIT 1
            )=" . quotes_add($p) . " AND
            tbl_user.aktiv=1 AND
            tbl_rollen.Berechtigungsstufe<=20
        )
    ";
    $userliste = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
    ta($sql);
    ta($userliste);
    
    if($userliste->num_rows==1) {
        $user = $userliste->fetch_object();
        session_start();
        $_SESSION["eingeloggt"] = true;
        $_SESSION["idUser"] = $user->IDUser;
        $_SESSION["Berechtigungsstufe"] = $user->Berechtigungsstufe;
        header("Location: redaktion.php");
    }
    else {
        $msg = '<p class="error">Leider waren die eingegebenen Daten nicht korrekt oder Sie haben keine Berechtigung, sich hier einzuloggen. Bitte versuchen Sie es ggf. erneut.</p>';
    }
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Login (Admin &amp; Moderator)</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="index.html">Startseite</a></li>
				<li><a href="registrierung.php">Registrierung</a></li>
				<li><a href="login.php">Login (Profil)</a></li>
			</ul>
		</nav>
        <?php echo($msg); ?>
        <form method="post">
            <label>
                Emailadresse:
                <input type="email" name="E" required>
            </label>
            <label>
                Passwort:
                <input type="password" name="P" required>
            </label>
            <input type="submit" value="einloggen">
        </form>
	</body>
</html>