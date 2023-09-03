<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");

$sql = "
	DELETE FROM tbl_user
	WHERE(
		IDUser=8 OR
		IDUser=17 OR
		IDUser=23
	)
";
$ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);

if($ok) {
	$msg = '<p class="success">Das SQL-Statement wurde erfolgreich ausgeführt. Es waren ' . $conn->affected_rows . ' Datensätze davon betroffen.</p>';
}
else {
	$msg = '<p class="error">Der Datensatz konnte leider nicht wie gewünscht gelöscht werden.</p>';
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>DB: DELETE</title>
		<meta charset="utf-8">
	</head>
	<body>
		<?php echo($msg); ?>
	</body>
</html>