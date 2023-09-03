<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/verzeichnisstruktur.inc.php");
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Löschen von Verzeichnissen</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php
		$geloescht = loescheVZ("a/");
		echo("gelöscht? --> ".$geloescht);
		?>
	</body>
</html>