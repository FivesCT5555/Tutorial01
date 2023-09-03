<?php
define("DB",[
	"host" => "localhost",
	"user" => "root",
	"pwd" => "",
	"name" => "db_lap_registrierung"
]);

define("TESTMODE",1); //0: Testmodus abgeschaltet, 1: Testmodus an

if(TESTMODE>0) {
    error_reporting(E_ALL);
    ini_set("display_errors",1);
}
else {
    error_reporting(0);
    ini_set("display_errors",0);
}
?>