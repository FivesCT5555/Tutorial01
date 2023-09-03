<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

ta($_FILES);

$msg = "";
$whitelist = ["image/jpeg","image/gif","image/png","image/webp","image/svg"]; //Liste erlaubter Bildtypen

if(count($_FILES)>0) {
	//es gibt ein Formular, das abgeschickt wurde und in dem zumindest die Möglichkeit besteht, eine Datei hochzuladen; ob tatsächlich eine Datei hochgeladen wurde, wissen wir noch nicht
	if($_FILES["Upload"]["error"]==0) {
		//während des Uploads ist kein Fehler aufgetreten --> Datei aus dem temporären Verzeichnis nehmen und im Zielverzeichnis ablegen
		
		if(in_array($_FILES["Upload"]["type"],$whitelist)) {
			//die hochgeladene Datei ist von einem Typen, der in unserer Whitelist erlaubt wird
			$ok = move_uploaded_file(
				$_FILES["Upload"]["tmp_name"],
				"uploads/" . $_FILES["Upload"]["name"]
			);
			if($ok) {
				$msg = '<p class="success">Vielen Dank, die Datei ' . $_FILES["Upload"]["name"] . ' wurde erfolgreich hochgeladen.</p>';
			}
			else {
				$msg = '<p class="error">Leider konnte die Datei ' . $_FILES["Upload"]["name"] . ' nicht gespeichert werden. Bitte melden Sie sich bei uns unter unserer <a href="mailto:noreply@test.at" target="_blank">Support-Email</a></p>';
			}
		}
		else {
			$msg = '<p class="error">Die Datei ' . $_FILES["Upload"]["name"] . ' ist leider keine erlaubte Bilddatei. Bitte laden Sie eine andere Datei hoch.</p>';
		}
	}
	else {
		$msg = '<p class="error">Leider ist beim Upload ein Fehler aufgetreten. Bitte versuchen Sie es erneut.</p>';
	}
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>Upload</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php echo($msg); ?>
		<form method="post" enctype="multipart/form-data">
			<input type="file" name="Upload">
			<input type="submit" value="hochladen">
		</form>
	</body>
</html>