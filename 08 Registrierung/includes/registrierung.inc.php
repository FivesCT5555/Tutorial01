<?php
function geschlechter_show(?int $idGeschlecht=0):string {
    global $conn;
    
    $r = '
        <select name="IDGeschlecht">
            <option value="0">Bitte wählen Sie:</option>
    ';
    
    $sql = "
        SELECT
            *
        FROM tbl_geschlechter
        ORDER BY Geschlecht ASC
    ";
    $geschlechter = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
    while($geschlecht = $geschlechter->fetch_object()) {
        if($geschlecht->IDGeschlecht==$idGeschlecht) {
            $selected = "selected";
        }
        else {
            $selected = "";
        }
        $r.= '
            <option value="' . $geschlecht->IDGeschlecht . '" ' .$selected . '>' . $geschlecht->Geschlecht . '</option>
        ';
    }
    
    $r.= '
        </select>
    ';
    return $r;
}

function staaten_show(?int $idStaat=0):string {
    global $conn;
    
    $r = '
        <select name="IDStaat">
            <option value="0">Bitte wählen Sie:</option>
    ';
    
    $sql = "
        SELECT
            *
        FROM tbl_staaten
        ORDER BY Staat ASC
    ";
    $staaten = $conn->query($sql) or die("Fehler in der Query: " . $conn->error . "<br>" . $sql);
    while($staat = $staaten->fetch_object()) {
        if($staat->IDStaat==$idStaat) {
            $selected = "selected";
        }
        else {
            $selected = "";
        }
        $r.= '
            <option value="' . $staat->IDStaat . '" ' .$selected . '>' . $staat->Staat . '</option>
        ';
    }
    
    $r.= '
        </select>
    ';
    return $r;
}

function validate_string(string $str, string $type):bool {
    switch($type) {
        case "uppercase":
            $r = preg_match('/[A-Z]/', $str)===1;
            ta("uppercase: ".$r);
            break;
        case "lowercase":
            $r = preg_match('/[a-z]/', $str)===1;
            ta("lowercase: ".$r);
            break;
        case "special":
            $r = preg_match('/[^A-Za-z0-9]+/i',$str)===1;
            ta("special: ".$r);
            break;
    }
    
    return $r;
}

function quotes_add(string $in):string {
    return "'" . $in . "'";
}
function value_set(?string $in, bool $useQuotes=true):string {
    return is_null($in) || ($useQuotes && strlen($in)==0) || ((!$useQuotes || is_int($in)) && intval($in)==0) ? "NULL" : ($useQuotes ? quotes_add($in) : $in);
}

function profilbild_show(?string $path):string {
    $r = "";
    if(!is_null($path)) {
        $r = '<img src="' . $path . '" class="profilbild">';
    }
    
    return $r;
}

function dir_content_erase(string $dir, bool $removeDir=false):bool {
    $r = true;
    if(file_exists($dir)) {
        $inhalt = scandir($dir);
        foreach($inhalt as $d) {
            if($d!="." && $d!="..") {
                if(is_dir($dir.$d)) {
                    $r = $r && dir_content_erase($dir.$d."/",true);
                }
                else {
                    $r = $r && unlink($dir.$d);
                }
            }
        }
        
        if($removeDir) {
            $r = $r && rmdir($dir);
        }
    }
    
    return $r;
}
?>