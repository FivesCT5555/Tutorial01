<?php
require("includes/common.inc.php");
require("includes/config.inc.php");
require("includes/conn.inc.php");
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>alle Teile zum Modelle</title>
    <link rel="stylesheet" href="css/common.css">
</head>

<body>
    <h1>Modellteileliste</h1>
    <?php
    if(count($_GET)>0 && intval($_GET["IDBaureihe"])>0) {
        echo('<ul>');
        $sql = "
            SELECT tbl_teile.* FROM tbl_teile
            LEFT JOIN tbl_teile_baureihen ON tbl_teile.IDTeil=tbl_teile_baureihen.FIDTeil
            WHERE(
                tbl_teile_baureihen.FIDBaureihe=" . $_GET["IDBaureihe"] . " OR
                tbl_teile.isUniversell=1
            )
        ";
        $teile = $GLOBALS["conn"]->query($sql) or die("Fehler in der Query: " . $GLOBALS["conn"]->error . "<br>" . $sql);
        while($teil = $teile->fetch_object()) {
            echo('
                <li>
                    ' . $teil->Bezeichnung . '
                </li>
            ');
        }
        echo('</ul>');
    }
    else {
        echo('<p class="error">Keine Baureihe ausgewählt.</p>');
    }
    ?>
</body>
</html>