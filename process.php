<?php
require_once "functions.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: assessment.php");
    exit;
}

$answers = [];
for ($i=1; $i<=6; $i++) {
    if (!isset($_POST["q".$i]) || !is_numeric($_POST["q".$i]) || (int)$_POST["q".$i] < 0 || (int)$_POST["q".$i] > 4) {
        flash("error", "Please answer all questions.");
        header("Location: assessment.php");
        exit;
    }
    $answers[] = (int)$_POST["q".$i];
}

$result = calculate_assessment($answers);

$stmt = $pdo->prepare("INSERT INTO assessments (q1,q2,q3,q4,q5,q6,total_score,result_level) VALUES (?,?,?,?,?,?,?,?)");
$stmt->execute([...$answers, array_sum($answers), $result["threshold"]]);

$suggestions = get_suggestions($pdo, $result["threshold"]);
$static = suggestions_for($result["threshold"]);
$doctors = in_array($result["threshold"], ["moderate","high"], true) ? get_doctors($pdo, $result["threshold"]) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Your Result — MindCare</title><link rel="stylesheet" href="assets/style.css"></head>
<body>
<nav class="nav"><a class="brand" href="index.php"><span>✦</span> MindCare</a><a class="nav-btn" href="assessment.php">Retake</a></nav>
<main class="narrow">
<div class="result-banner <?= e($result["class"]) ?>">
  <span class="eyebrow">YOUR CHECK-IN RESULT</span>
  <h1><?= e($result["level"]) ?></h1>
  <p><?= e($result["summary"]) ?></p>
  <div class="score">Score: <?= array_sum($answers) ?> / 24</div>
</div>

<section class="content-card">
<h2>Suggestions for you</h2>
<div class="suggestions">
<?php
$shown = [];
foreach ($suggestions as $s) {
    $shown[] = $s["title"];
    echo '<div class="suggestion"><div class="check">✓</div><div><h3>'.e($s["title"]).'</h3><p>'.e($s["description"]).'</p></div></div>';
}
if (!$shown) foreach ($static as $s) echo '<div class="suggestion"><div class="check">✓</div><div><p>'.e($s).'</p></div></div>';
?>
</div>
</section>

<?php if ($doctors): ?>
<section class="content-card">
<h2>Professional support</h2>
<p>If you would like additional support, these professionals are listed by the site administrator.</p>
<div class="doctor-grid">
<?php foreach ($doctors as $d): ?>
<article class="doctor">
<div class="doctor-avatar"><?= e(strtoupper(substr($d["name"],0,1))) ?></div>
<div><h3><?= e($d["name"]) ?></h3><p><?= e($d["qualification"]) ?></p><p><b><?= e($d["specialization"]) ?></b></p><p><?= e($d["location"]) ?></p><?php if ($d["phone"]): ?><p>☎ <?= e($d["phone"]) ?></p><?php endif; ?><?php if ($d["website"]): ?><a href="<?= e($d["website"]) ?>" target="_blank" rel="noopener">View profile / website →</a><?php endif; ?></div>
</article>
<?php endforeach; ?>
</div>
</section>
<?php elseif (in_array($result["threshold"], ["moderate","high"], true)): ?>
<section class="content-card">
<h2>Professional support</h2>
<p>No professionals are currently listed for this support level. Please consider contacting a qualified mental-health professional through a trusted local provider or healthcare service.</p>
</section>
<?php endif; ?>

<div class="notice"><strong>Important:</strong> This result is not a diagnosis. If you feel unsafe or think you may hurt yourself or someone else, seek immediate local emergency/crisis support rather than relying on this website.</div>
<a class="secondary-btn" href="assessment.php">Take the assessment again</a>
</main>
<footer>MindCare · Awareness, not diagnosis</footer>
</body></html>