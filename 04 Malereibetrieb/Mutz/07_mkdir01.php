<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

$vz = "./a/c/x";
if(!file_exists($vz)) {
	$ok = mkdir($vz,0755,true); //legt das Verzeichnis a im aktuellen Verzeichnis an und vergibt die Verzeichnisrechte 0755
	if($ok) {
		$msg = '<p class="success">Das Wunschverzeichnis wurde erfolgreich angelegt.</p>';
	}
	else {
		$msg = '<p class="error">Das Wunschverzeichnis konnte leider nicht angelegt werden.</p>';
	}
}
else {
	$msg = '<p class="error">Dieses Verzeichnis existiert bereits.</p>';
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Anlegen von Verzeichnissen</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php echo($msg); ?>
	</body>
</html>