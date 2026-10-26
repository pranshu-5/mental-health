<?php require_once "../functions.php"; require_admin(); $flash=get_flash(); $doctors=$pdo->query("SELECT * FROM doctors ORDER BY id DESC")->fetchAll(); $suggestions=$pdo->query("SELECT * FROM suggestions ORDER BY id DESC")->fetchAll(); $count=$pdo->query("SELECT COUNT(*) c FROM assessments")->fetch()["c"]; ?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Dashboard — MindCare</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<nav class="nav admin-nav"><a class="brand" href="../index.php"><span>✦</span> MindCare Admin</a><span>Welcome, <?= e($_SESSION["admin_name"]) ?></span><a class="nav-btn ghost" href="logout.php">Logout</a></nav>
<main class="admin-main">
<?php if($flash): ?><div class="notice"><?= e($flash["message"]) ?></div><?php endif; ?>
<div class="admin-header"><div><span class="eyebrow">CONTROL PANEL</span><h1>Manage guidance</h1><p>Update the content users see after completing the assessment.</p></div><div class="stat"><b><?= e($count) ?></b><span>assessments</span></div></div>

<section class="admin-section"><div class="section-title"><h2>Professionals</h2><a class="primary-btn" href="doctor_edit.php">+ Add professional</a></div>
<div class="table-wrap"><table><thead><tr><th>Name</th><th>Specialization</th><th>Location</th><th>Level</th><th>Status</th><th>Actions</th></tr></thead><tbody>
<?php foreach($doctors as $d): ?><tr><td><b><?= e($d["name"]) ?></b><br><small><?= e($d["qualification"]) ?></small></td><td><?= e($d["specialization"]) ?></td><td><?= e($d["location"]) ?></td><td><?= e(ucfirst($d["min_level"])) ?></td><td><?= $d["active"] ? "Active" : "Hidden" ?></td><td><a href="doctor_edit.php?id=<?= $d["id"] ?>">Edit</a> · <a class="danger-link" href="delete.php?type=doctor&id=<?= $d["id"] ?>" onclick="return confirm('Delete this professional?')">Delete</a></td></tr><?php endforeach; ?>
</tbody></table></div></section>

<section class="admin-section"><div class="section-title"><h2>Suggestions</h2><a class="primary-btn" href="suggestion_edit.php">+ Add suggestion</a></div>
<div class="table-wrap"><table><thead><tr><th>Title</th><th>Description</th><th>Minimum level</th><th>Priority</th><th>Actions</th></tr></thead><tbody>
<?php foreach($suggestions as $s): ?><tr><td><b><?= e($s["title"]) ?></b></td><td><?= e($s["description"]) ?></td><td><?= e(ucfirst($s["min_level"])) ?></td><td><?= e($s["priority"]) ?></td><td><a href="suggestion_edit.php?id=<?= $s["id"] ?>">Edit</a> · <a class="danger-link" href="delete.php?type=suggestion&id=<?= $s["id"] ?>" onclick="return confirm('Delete this suggestion?')">Delete</a></td></tr><?php endforeach; ?>
</tbody></table></div></section>
</main></body></html>