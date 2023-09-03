<?php
require("includes/config.inc.php");
require("includes/common.inc.php");
require("includes/conn.inc.php");

//ta($_POST);

function checkIfNULL($in) {
	if(strlen($in)==0) {
		$r = "NULL";
	}
	else {
		$r = "'" . $in . "'";
	}
	return $r;
}

$where = "";

if(count($_POST)>0) {
	if(isset($_POST["btnInsert"])) {
		$vn = checkIfNULL($_POST["VN_0"]);
		$nn = checkIfNULL($_POST["NN_0"]);
		$gd = checkIfNULL($_POST["GD_0"]);
		
		$sql = "
			INSERT INTO tbl_user
				(Emailadresse, Passwort, Vorname, Nachname, GebDatum)
			VALUES (
				'" . $_POST["E_0"] . "',
				'" . $_POST["P_0"] . "',
				" . $vn . ",
				" . $nn . ",
				" . $gd . "
			)
		";
		ta($sql);
		$ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
	}
	else {
		if(isset($_POST["btnFilter"])) {
			$arr = [];
			if(strlen($_POST["F_NN"])>0) {
				$arr[] = "Nachname LIKE '%" . $_POST["F_NN"] . "%'";
			}
			if(strlen($_POST["F_VN"])>0) {
				$arr[] = "Vorname LIKE '%" . $_POST["F_VN"] . "%'";
			}
			if(strlen($_POST["F_E"])>0) {
				$arr[] = "Emailadresse LIKE '%" . $_POST["F_E"] . "'";
			}
			
			ta($arr);
			if(count($arr)>0) {
				$where = "
					WHERE(" . implode(" AND ",$arr) . ")
				";
			}
		}
		else {
			switch($_POST["wasTun"]) {
				case "loeschen":
					$sql = "
						DELETE FROM tbl_user
						WHERE(
							IDUser=" . $_POST["welcheID"] . "
						)
					";
					ta($sql);
					$ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
					break;
					
				case "aktualisieren":
					$id = $_POST["welcheID"]; //Hilfsvariable
					
					$sql = "
						UPDATE tbl_user SET
							Emailadresse='" . $_POST["E_".$id] . "',
							Passwort='" . $_POST["P_".$id] . "',
							Vorname=" . checkIfNULL($_POST["VN_".$id]) . ",
							Nachname=" . checkIfNULL($_POST["NN_".$id]) . ",
							GebDatum=" . checkIfNULL($_POST["GD_".$id]) . "
						WHERE(
							IDUser=" . $id . "
						)
					";
					ta($sql);
					$ok = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
					break;
			}
		}
	}
}
/*
// mit Filter:
$sql = "
	SELECT
		*
	FROM tbl_user
	WHERE(
		Nachname LIKE '%Müller%'
	)
";

// ohne Filter:
$sql = "
	SELECT
		*
	FROM tbl_user
";
*/

$sql = "
	SELECT
		*
	FROM tbl_user
	" . $where . "
";
ta($sql);


$datensaetze = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
?>
<!doctype html>
<html lang="de">
	<head>
		<title>DB</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/common.css">
		<script>
		function loesche(IDDS) {
			if(confirm("Wollen Sie diesen Datensatz wirklich löschen?")) {
				document.querySelector("[name=welcheID]").value = IDDS;
				document.querySelector("[name=wasTun]").value = "loeschen";
				document.querySelector("#frm").submit();
			}
		}
		function aktualisiere(IDDS) {
			document.querySelector("[name=welcheID]").value = IDDS;
			document.querySelector("[name=wasTun]").value = "aktualisieren";
			document.querySelector("#frm").submit();
		}
		</script>
	</head>
	<body>
		<form method="post" id="frm">
			<input type="hidden" name="welcheID">
			<input type="hidden" name="wasTun">
			<table>
				<thead>
					<tr>
						<th scope="col">IDUser</th>
						<th scope="col">Emailadresse</th>
						<th scope="col">Passwort</th>
						<th scope="col">Vorname</th>
						<th scope="col">Nachname</th>
						<th scope="col">Geb-Datum</th>
						<th scope="col">Reg-Zeitpunkt</th>
						<th></th>
					</tr>
					<tr>
						<td></td>
						<td><input type="text" name="F_E"></td>
						<td></td>
						<td><input type="text" name="F_VN"></td>
						<td><input type="text" name="F_NN"></td>
						<td></td>
						<td></td>
						<td><input type="submit" name="btnFilter" value="filtern"></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="email" name="E_0"></td>
						<td><input type="text" name="P_0"></td>
						<td><input type="text" name="VN_0"></td>
						<td><input type="text" name="NN_0"></td>
						<td><input type="text" name="GD_0"></td>
						<td></td>
						<td><input type="submit" name="btnInsert" value="INS"></td>
					</tr>
				</thead>
				<tbody>
					<?php
					while($ds = $datensaetze->fetch_object()) {
						echo('
							<tr>
								<td>' . $ds->IDUser . '</td>
								<td><input type="email" value="' . $ds->Emailadresse . '" name="E_' . $ds->IDUser . '"></td>
								<td><input type="text" value="' . $ds->Passwort . '" name="P_' . $ds->IDUser . '"></td>
								<td><input type="text" value="' . $ds->Vorname . '" name="VN_' . $ds->IDUser . '"></td>
								<td><input type="text" value="' . $ds->Nachname . '" name="NN_' . $ds->IDUser . '"></td>
								<td><input type="date" value="' . $ds->GebDatum . '" name="GD_' . $ds->IDUser . '"></td>
								<td>' . $ds->RegZeitpunkt . '</td>
								<td>
									<input type="button" value="DEL" onclick="loesche(' . $ds->IDUser . ');">
									<input type="button" value="UPD" onclick="aktualisiere(' . $ds->IDUser . ');">
								</td>
							</tr>
						');
					}
					?>
				</tbody>
			</table>
		</form>
	</body>
</html>