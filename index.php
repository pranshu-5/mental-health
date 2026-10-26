<?php require_once "functions.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MindCare — Mental Well-being Check</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="nav">
  <a class="brand" href="index.php"><span>✦</span> MindCare</a>
  <a href="about.php">About</a>
  <a class="nav-btn" href="assessment.php">Start Check</a>
  <a class="admin-link" href="admin/login.php">Admin Login</a>
</nav>

<main>
<section class="hero">
  <div class="hero-copy">
    <span class="eyebrow">MENTAL WELL-BEING • SELF REFLECTION</span>
    <h1>A small check-in can be a good place to start.</h1>
    <p>Answer a few simple questions about stress, sleep and emotional well-being. Get a supportive result and practical suggestions.</p>
    <a class="primary-btn" href="assessment.php">Start my check-in <span>→</span></a>
    <p class="micro">Takes about 2 minutes · No diagnosis · Your choices are used only for this assessment.</p>
  </div>
  <div class="hero-card">
    <div class="orb">✦</div>
    <h3>How are you doing lately?</h3>
    <p>There is no “perfect” answer. Choose what feels closest to your recent experience.</p>
    <div class="mini-line"><span></span><span></span><span></span><span></span></div>
  </div>
</section>

<section class="three">
  <div class="info-card"><b>01</b><h3>Reflect</h3><p>Answer 6 short questions about how you have been feeling recently.</p></div>
  <div class="info-card"><b>02</b><h3>Understand</h3><p>Receive a simple support-level result based on your answers.</p></div>
  <div class="info-card"><b>03</b><h3>Take a step</h3><p>Explore self-care suggestions and professional support when appropriate.</p></div>
</section>

<section class="notice">
  <strong>Important:</strong> This website is an awareness and self-reflection tool. It does not diagnose mental-health conditions or replace a qualified professional.
</section>
</main>
<footer>MindCare · Student Project · Awareness, not diagnosis</footer>
</body>
</html>