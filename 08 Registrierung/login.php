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
            IDUser
        FROM tbl_user
        WHERE(
            Emailadresse=" . quotes_add($e) . " AND
            (
                SELECT Passwort
                FROM tbl_passwoerter
                WHERE(
                    FIDUser=IDUser
                )
                ORDER BY Nutzungszeitpunkt DESC
                LIMIT 1
            )=" . quotes_add($p) . " AND
            aktiv=1
        )
    ";
    $userliste = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
    
    if($userliste->num_rows==1) {
        $user = $userliste->fetch_object();
        session_start();
        $_SESSION["eingeloggt"] = true;
        $_SESSION["idUser"] = $user->IDUser;
        header("Location: profil.php");
    }
    else {
        $msg = '<p class="error">Leider waren die eingegebenen Daten nicht korrekt oder sie sind gesperrt. Bitte versuchen Sie es ggf. erneut.</p>';
    }
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Login</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="index.html">Startseite</a></li>
				<li><a href="registrierung.php">Registrierung</a></li>
				<li><a href="login_admin.php">Login (Admin)</a></li>
			</ul>
		</nav>
        <?php echo($msg); ?>
        <form method="post" enctype="multipart/form-data">
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