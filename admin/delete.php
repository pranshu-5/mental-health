<?php
require_once "../functions.php"; require_admin();
$type=$_GET["type"]??""; $id=(int)($_GET["id"]??0);
$map=["doctor"=>"doctors","suggestion"=>"suggestions"];
if(isset($map[$type]) && $id){$stmt=$pdo->prepare("DELETE FROM ".$map[$type]." WHERE id=?");$stmt->execute([$id]);flash("success","Item deleted.");}
header("Location: index.php"); exit;
?>