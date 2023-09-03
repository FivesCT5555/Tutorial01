<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");

$sql = "
	UPDATE tbl_user SET
		isAktiv=1
	WHERE(
		Nachname LIKE '%Müller%'
	)
";
$ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);

if($ok) {
	$msg = '<p class="success">Das SQL-Statement wurde erfolgreich ausgeführt. Es waren ' . $conn->affected_rows . ' Datensätze davon betroffen.</p>';
}
else {
	$msg = '<p class="error">Der Datensatz konnte leider nicht wie gewünscht geändert werden.</p>';
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>DB: UPDATE</title>
		<meta charset="utf-8">
	</head>
	<body>
		<?php echo($msg); ?>
	</body>
</html>