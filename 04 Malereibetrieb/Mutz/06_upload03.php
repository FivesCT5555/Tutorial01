<?php
require("includes/config.inc.php");
require("includes/common.inc.php");

ta($_FILES);

$msg = "";

if(count($_FILES)>0) {
	$f = $_FILES["Upload"];
	for($i=0; $i<count($f["name"]); $i++) {
		if($f["error"][$i]==0) {
			//für DIESE Datei ist beim Upload kein Fehler aufgetreten
			$ok = move_uploaded_file($f["tmp_name"][$i],"uploads/".$f["name"][$i]);
			if($ok) {
				$msg = $msg . '<p class="success">Die Datei ' . $f["name"][$i] . ' wurde erfolgreich hochgeladen.</p>';
			}
			else {
				$msg .= '<p class="error">Leider konnte die Datei ' . $f["name"][$i] . ' nicht erfolgreich hochgeladen werden.</p>';
			}
		}
		else {
			$msg .= '<p class="error">Leider ist während des Uploads ein Fehler aufgetreten.</p>';
		}
	}			
}
?>
<!doctype html>
<html lang="de">
	<head>
		<title>multiple Upload</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
	</head>
	<body>
		<?php echo($msg); ?>
		<form method="post" enctype="multipart/form-data">
			<input type="file" name="Upload[]" multiple>
			<input type="submit" value="hochladen">
		</form>
	</body>
</html>