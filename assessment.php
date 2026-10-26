<?php require_once "functions.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Assessment — MindCare</title><link rel="stylesheet" href="assets/style.css"></head>
<body>
<nav class="nav"><a class="brand" href="index.php"><span>✦</span> MindCare</a><a class="nav-btn ghost" href="index.php">Exit</a></nav>
<main class="narrow">
<div class="page-head compact"><span class="eyebrow">2 MINUTE CHECK-IN</span><h1>How have you been feeling recently?</h1><p>Select the answer that best describes your experience over the last few weeks.</p></div>
<form class="assessment" action="process.php" method="post">
<?php
$questions = [
["How often have you felt stressed or overwhelmed?", "stress"],
["How would you describe your sleep quality?", "sleep"],
["How often have you felt restless, worried, or unable to relax?", "anxiety"],
["How often have you found it difficult to concentrate on everyday tasks?", "concentration"],
["How often have you felt emotionally tired or drained?", "emotion"],
["How often have you lost interest in activities you normally enjoy?", "interest"]
];
$options = [
"Never / Very good" => 0,
"Rarely" => 1,
"Sometimes" => 2,
"Often" => 3,
"Very often / Very poor" => 4
];
foreach ($questions as $i => $q):
?>
<fieldset class="question">
<legend><span><?= $i+1 ?></span><?= e($q[0]) ?></legend>
<div class="options">
<?php foreach ($options as $label => $value): ?>
<label><input type="radio" name="q<?= $i+1 ?>" value="<?= $value ?>" required><span><?= e($label) ?></span></label>
<?php endforeach; ?>
</div>
</fieldset>
<?php endforeach; ?>
<div class="notice small"><strong>Remember:</strong> This check-in is for awareness only and is not a medical diagnosis.</div>
<button class="primary-btn full" type="submit">See my result <span>→</span></button>
</form>
</main>
<footer>MindCare · Your well-being matters</footer>
</body></html>