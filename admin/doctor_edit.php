<?php
require_once "../functions.php"; require_admin();
$id = (int)($_GET["id"] ?? 0);
$data = ["name"=>"","qualification"=>"","specialization"=>"","location"=>"","phone"=>"","website"=>"","min_level"=>"moderate","active"=>1,"featured"=>0];
if ($id) { $stmt=$pdo->prepare("SELECT * FROM doctors WHERE id=?"); $stmt->execute([$id]); $data=$stmt->fetch() ?: $data; }
if ($_SERVER["REQUEST_METHOD"]==="POST") {
    $fields=[trim($_POST["name"]),trim($_POST["qualification"]),trim($_POST["specialization"]),trim($_POST["location"]),trim($_POST["phone"]),trim($_POST["website"]),$_POST["min_level"],isset($_POST["active"])?1:0,isset($_POST["featured"])?1:0];
    if ($id) { $stmt=$pdo->prepare("UPDATE doctors SET name=?,qualification=?,specialization=?,location=?,phone=?,website=?,min_level=?,active=?,featured=? WHERE id=?"); $stmt->execute([...$fields,$id]); }
    else { $stmt=$pdo->prepare("INSERT INTO doctors(name,qualification,specialization,location,phone,website,min_level,active,featured) VALUES(?,?,?,?,?,?,?,?,?)"); $stmt->execute($fields); }
    flash("success","Professional saved successfully."); header("Location: index.php"); exit;
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Professional — Admin</title><link rel="stylesheet" href="../assets/style.css"></head><body><main class="admin-form"><a href="index.php">← Dashboard</a><h1><?= $id ? "Edit" : "Add" ?> professional</h1><form method="post" class="content-card">
<label>Name<input name="name" value="<?= e($data["name"]) ?>" required></label>
<label>Qualification<input name="qualification" value="<?= e($data["qualification"]) ?>" required></label>
<label>Specialization<input name="specialization" value="<?= e($data["specialization"]) ?>" required></label>
<label>Location<input name="location" value="<?= e($data["location"]) ?>" required></label>
<label>Phone<input name="phone" value="<?= e($data["phone"]) ?>"></label>
<label>Website<input type="url" name="website" value="<?= e($data["website"]) ?>" placeholder="https://..."></label>
<label>Show for support level<select name="min_level"><option value="low" <?= $data["min_level"]==="low"?"selected":"" ?>>Low</option><option value="mild" <?= $data["min_level"]==="mild"?"selected":"" ?>>Mild</option><option value="moderate" <?= $data["min_level"]==="moderate"?"selected":"" ?>>Moderate</option><option value="high" <?= $data["min_level"]==="high"?"selected":"" ?>>High</option></select></label>
<label class="checkline"><input type="checkbox" name="active" <?= $data["active"]?"checked":"" ?>> Active</label><label class="checkline"><input type="checkbox" name="featured" <?= $data["featured"]?"checked":"" ?>> Featured</label>
<button class="primary-btn">Save professional</button></form></main></body></html>