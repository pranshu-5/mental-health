<?php
require_once "../functions.php";
if (is_admin()) { header("Location: index.php"); exit; }
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([trim($_POST["username"] ?? "")]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($_POST["password"] ?? "", $admin["password_hash"])) {
        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["admin_name"] = $admin["username"];
        header("Location: index.php"); exit;
    }
    $error = "Invalid username or password.";
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login</title><link rel="stylesheet" href="../assets/style.css"></head>
<body class="admin-body"><main class="login-card"><div class="brand">✦ MindCare Admin</div><h1>Sign in</h1><?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?><form method="post"><label>Username<input name="username" required autocomplete="username"></label><label>Password<input type="password" name="password" required autocomplete="current-password"></label><button class="primary-btn full">Login</button></form><a href="../index.php">← Back to website</a></main></body></html>