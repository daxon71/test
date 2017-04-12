<?
$host = !isDenwer() ? "localhost" : "localhost";
$bazaLogin = !isDenwer() ? "goltsegv_baza" : "root" ;
$bazaPassword = !isDenwer() ? "kOOswap3" : "";
$baza = !isDenwer() ? "goltsegv_baza" : "akrobatika";

mysql_connect($host,$bazaLogin,$bazaPassword)
or die ("Не могу соединится с MySQL.");
mysql_select_db($baza)
or die ("Соединился, но не могу выбрать базу данных.");
mysql_query("SET NAMES 'utf8'");