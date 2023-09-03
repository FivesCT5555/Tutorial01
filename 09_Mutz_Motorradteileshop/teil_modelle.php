<?php
require("includes/common.inc.php");
require("includes/config.inc.php");
require("includes/conn.inc.php");
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>alle Modelle zum Teil</title>
    <link rel="stylesheet" href="css/common.css">
</head>

<body>
    <h1>Modellliste</h1>
    <?php
    if(count($_GET)>0 && intval($_GET["IDTeil"])>0) {
        echo('<ul>');
        $where = "";
        if(intval($_GET["isUniversell"])==0) {
            $where = "
                WHERE(
                    tbl_teile_baureihen.FIDTeil=" . $_GET["IDTeil"] . "
                )
            ";
        }
        $sql = "
            SELECT
                tbl_marken.Markenname,
                tbl_modelle.Modell,
                tbl_baureihen.BaujahrVon,
                tbl_baureihen.BaujahrBis
            FROM tbl_teile_baureihen
            INNER JOIN tbl_baureihen ON tbl_teile_baureihen.FIDBaureihe=tbl_baureihen.IDBaureihe
            INNER JOIN tbl_modelle ON tbl_modelle.IDModell=tbl_baureihen.FIDModell
            INNER JOIN tbl_marken ON tbl_marken.IDMarke=tbl_modelle.FIDMarke
            " . $where . "
            ORDER BY Markenname ASC, Modell ASC, BaujahrVon ASC
        ";
        $modelle = $GLOBALS["conn"]->query($sql) or die("Fehler in der Query: " . $GLOBALS["conn"]->error . "<br>" . $sql);
        while($modell = $modelle->fetch_object()) {
            echo('
                <li>
                    ' . $modell->Markenname . ' ' . $modell->Modell . ' (' . $modell->BaujahrVon . ' bis ' . $modell->BaujahrBis . ')
                </li>
            ');
        }
        echo('</ul>');
    }
    else {
        echo('<p class="error">Kein Teil ausgewählt.</p>');
    }
    ?>
</body>
</html>