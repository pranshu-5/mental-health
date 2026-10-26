<?php
require_once "../functions.php"; require_admin();
$id=(int)($_GET["id"]??0); $data=["title"=>"","description"=>"","min_level"=>"low","priority"=>1];
if($id){$stmt=$pdo->prepare("SELECT * FROM suggestions WHERE id=?");$stmt->execute([$id]);$data=$stmt->fetch()?:$data;}
if($_SERVER["REQUEST_METHOD"]==="POST"){
  $fields=[trim($_POST["title"]),trim($_POST["description"]),$_POST["min_level"],(int)$_POST["priority"]];
  if($id){$stmt=$pdo->prepare("UPDATE suggestions SET title=?,description=?,min_level=?,priority=? WHERE id=?");$stmt->execute([...$fields,$id]);}
  else{$stmt=$pdo->prepare("INSERT INTO suggestions(title,description,min_level,priority) VALUES(?,?,?,?)");$stmt->execute($fields);}
  flash("success","Suggestion saved successfully.");header("Location: index.php");exit;
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Suggestion — Admin</title><link rel="stylesheet" href="../assets/style.css"></head><body><main class="admin-form"><a href="index.php">← Dashboard</a><h1><?= $id?"Edit":"Add" ?> suggestion</h1><form method="post" class="content-card"><label>Title<input name="title" value="<?= e($data["title"]) ?>" required></label><label>Description<textarea name="description" rows="5" required><?= e($data["description"]) ?></textarea></label><label>Minimum support level<select name="min_level"><option value="low" <?= $data["min_level"]==="low"?"selected":"" ?>>Low</option><option value="mild" <?= $data["min_level"]==="mild"?"selected":"" ?>>Mild</option><option value="moderate" <?= $data["min_level"]==="moderate"?"selected":"" ?>>Moderate</option><option value="high" <?= $data["min_level"]==="high"?"selected":"" ?>>High</option></select></label><label>Priority<input type="number" name="priority" value="<?= e($data["priority"]) ?>" min="1" max="100"></label><button class="primary-btn">Save suggestion</button></form></main></body></html>