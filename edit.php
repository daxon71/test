<?
include_once "functions.php";
include_once "mysql.php";

mysql_query("UPDATE `classes` SET `html` = '$_POST[html]' WHERE `classes`.`id` = $_POST[id];");
echo "$_POST[html]' \n\n\n $_POST[id]";
?>
























