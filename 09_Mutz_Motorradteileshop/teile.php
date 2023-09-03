<?php
require("includes/common.inc.php");
require("includes/config.inc.php");
require("includes/conn.inc.php");
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Teileliste</title>
</head>

<body>
    <h1>Teileliste</h1>
    <ul> 
        <?php
        $sql = "
            SELECT * FROM tbl_teile
            ORDER BY Bezeichnung ASC
        ";
        $teile = $GLOBALS["conn"]->query($sql) or die("Fehler in der Query: " . $GLOBALS["conn"]->error . "<br>" . $sql);
        while($teil = $teile->fetch_object()) {
            echo('
                <li>
                    <a href="teil_modelle.php?IDTeil=' . $teil->IDTeil . '&isUniversell=' . $teil->isUniversell . '">' . $teil->Bezeichnung . '</a>
                </li>
            ');
        }
        ?>
    </ul>
</body>
</html>