<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");

$sql = "
	INSERT INTO tbl_user
		(Emailadresse, Passwort, Vorname, Nachname, GebDatum)
	VALUES (
		'test10@test.at',
		'test123',
		'Harald',
		'Maierhofer',
		'1999-08-09'
	)
";
$ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
if($ok) {
	$msg = '<p class="success">Der Datensatz wurde erfolgreich eingetragen.</p>';
}
else {
	$msg = '<p class="error">Der Datensatz konnte leider nicht wie gewünscht eingetragen werden.</p>';
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>DB: INSERT</title>
		<meta charset="utf-8">
	</head>
	<body>
		<?php echo($msg); ?>
	</body>
</html>