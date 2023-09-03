<?php
print_r($_POST);
?>
<!doctype html>
<html lang="de">
	<head>
		<title>JS: Formulare</title>
		<meta charset="utf-8">
		<script>
		document.addEventListener("DOMContentLoaded", function() {
			const btn = document.querySelector("#btn");
			
			btn.addEventListener("click", function() {
				console.log("Button wurde geklickt");
				
				document.querySelector("[name=Nachname]").value = "Mutz"; //greift auf das Element mit dem Namen "Nachname" zu ([name=Nachname]) und schreibt in das value-Attribut den Wert "Mutz" --> dem Feld Nachname wurde der Wert Mutz zugewiesen
				
				let vn = document.querySelector("[name=Vorname]").value; //greift auf das Element mit dem Namen "Vorname" zu und liest (über das value-Attribut) den eingegebenen Wert aus
				
				console.log("Vorname=",vn);
				
				document.querySelector("#frm").submit();
			});
		});
		</script>
	</head>
	<body>
		<form method="post" id="frm">
			<input type="text" name="Vorname">
			<input type="text" name="Nachname">
			<input type="button" value="abschicken" id="btn">
		</form>
	</body>
</html>