<?php
require("includes/login_logout.inc.php");

require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");
require("includes/redaktion.inc.php");

$msg = "";

ta($_POST);
if(count($_POST)>0) {
    if($_SESSION["Berechtigungsstufe"]<=20) {
        if(isset($_POST["aktiv"])) {
            $arr = [];
            for($i=0; $i<count($_POST["aktiv"]); $i++) {
                $arr[] = "IDUser=" . $_POST["aktiv"][$i];
            }
            
            $sql = "
                UPDATE tbl_user SET
                    aktiv=0
                WHERE(
                    IDUser<>" . $_SESSION["idUser"] . "
                )
            ";
            $ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
            
            $sql = "
                UPDATE tbl_user SET
                    aktiv=1
                WHERE(
                    " . implode(" OR ",$arr) . "
                )
            ";
            $ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
        }
    }
    
    if($_SESSION["Berechtigungsstufe"]<=10) {
        $arr = [];
        for($i=0; $i<count($_POST["IDRolle"]); $i++) {
            $vals = explode(",",$_POST["IDRolle"][$i]);
            $sql = "
                UPDATE tbl_user SET
                    FIDRolle=" . $vals[1] . "
                WHERE(
                    IDUser=" . $vals[0] . "
                )
            ";
            $ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
        }
    }
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Redaktion</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
		<link rel="stylesheet" href="css/registrierung.css">
	</head>
	<body>
		<nav>
			<ul>
				<li><a href="index.html">Startseite</a></li>
				<li><a href="registrierung.php">Registrierung</a></li>
				<li><a href="login.php">Login (Profil)</a></li>
			</ul>
		</nav>
        <form method="post">
            <input type="submit" name="btnLogout" value="logout">
        </form>
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Emailadresse</th>
                        <th scope="col">aktiv?</th>
                        <th scope="col">Rolle</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    echo($msg);

                    $sql ="
                        SELECT
                            tbl_user.*,
                            tbl_rollen.Rolle
                        FROM tbl_user
                        INNER JOIN tbl_rollen ON tbl_rollen.IDRolle=tbl_user.FIDRolle
                        WHERE(
                            tbl_user.IDUser<>" . $_SESSION["idUser"] . " AND
                            tbl_rollen.Berechtigungsstufe>" . $_SESSION["Berechtigungsstufe"] . "
                        )
                        ORDER BY tbl_user.Emailadresse ASC
                    ";
                    $userliste = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
                    while($user = $userliste->fetch_object()) {
                        if($user->aktiv==1) { $aktiv = "checked"; }
                        else { $aktiv = ""; }
                        echo('
                            <tr>
                                <td>' . $user->Emailadresse . '</td>
                                <td><input type="checkbox" name="aktiv[]" value="' . $user->IDUser . '" ' . $aktiv . '></td>
                                <td>' . rollen_show($user->IDUser,$user->FIDRolle) . '</td>
                            </tr>
                        ');
                    }
                    ?>
                </tbody>
            </table>
            <input type="submit" value="Änderungen speichern">
        </form>
	</body>
</html>