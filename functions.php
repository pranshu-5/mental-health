<?php
require_once __DIR__ . "/config.php";

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

function is_admin() {
    return !empty($_SESSION["admin_id"]);
}

function require_admin() {
    if (!is_admin()) {
        header("Location: login.php");
        exit;
    }
}

function flash($type, $message) {
    $_SESSION["flash"] = ["type" => $type, "message" => $message];
}

function get_flash() {
    $f = $_SESSION["flash"] ?? null;
    unset($_SESSION["flash"]);
    return $f;
}

function calculate_assessment($answers) {
    // Simple project-level awareness scoring. This is NOT a clinical diagnostic scale.
    $score = 0;
    foreach ($answers as $answer) {
        $score += (int)$answer;
    }

    if ($score <= 6) {
        return [
            "level" => "Low Support Need",
            "class" => "low",
            "summary" => "Your answers suggest relatively low current concern. Continue supporting your well-being and keep checking in with yourself.",
            "threshold" => "low"
        ];
    } elseif ($score <= 12) {
        return [
            "level" => "Mild Support Need",
            "class" => "mild",
            "summary" => "Some areas may be affecting your well-being. A few healthy routines and self-care practices may be helpful.",
            "threshold" => "mild"
        ];
    } elseif ($score <= 18) {
        return [
            "level" => "Moderate Support Need",
            "class" => "moderate",
            "summary" => "Your answers suggest that additional support may be useful. Consider talking to someone you trust or a qualified professional.",
            "threshold" => "moderate"
        ];
    } else {
        return [
            "level" => "Higher Support Need",
            "class" => "high",
            "summary" => "Your answers suggest that professional support may be especially useful. Consider contacting a qualified mental-health professional.",
            "threshold" => "high"
        ];
    }
}

function suggestions_for($threshold) {
    $common = [
        "Take short breaks during study or work.",
        "Maintain a consistent sleep and wake schedule.",
        "Spend some time each day away from screens.",
        "Talk to someone you trust when you feel overwhelmed."
    ];

    $specific = [
        "low" => [
            "Continue activities that make you feel calm and connected.",
            "Try a few minutes of mindful breathing each day.",
            "Keep a simple journal of things that went well."
        ],
        "mild" => [
            "Try slow breathing: inhale gently for 4 seconds and exhale for 6 seconds for a few minutes.",
            "Write down worries or tasks before bedtime to clear your mind.",
            "Add light physical activity or a short walk to your routine."
        ],
        "moderate" => [
            "Consider speaking with a trusted friend, family member, counselor, or psychologist.",
            "Break large tasks into smaller achievable steps.",
            "Use journaling to identify situations that increase stress."
        ],
        "high" => [
            "Consider arranging a conversation with a qualified mental-health professional.",
            "Tell a trusted person that you are having a difficult time so you do not have to handle it alone.",
            "If you feel unsafe or think you may hurt yourself or someone else, seek immediate local emergency or crisis support."
        ]
    ];

    return array_merge($common, $specific[$threshold] ?? []);
}

function get_suggestions($pdo, $threshold) {
    $stmt = $pdo->prepare("SELECT * FROM suggestions WHERE min_level <= :lvl ORDER BY priority DESC, id ASC");
    $levels = ["low"=>1, "mild"=>2, "moderate"=>3, "high"=>4];
    $stmt->execute([":lvl" => $levels[$threshold] ?? 1]);
    return $stmt->fetchAll();
}

function get_doctors($pdo, $threshold = null) {
    if ($threshold) {
        $levels = ["low"=>1, "mild"=>2, "moderate"=>3, "high"=>4];
        $stmt = $pdo->prepare("SELECT * FROM doctors WHERE min_level <= :lvl AND active = 1 ORDER BY featured DESC, name ASC");
        $stmt->execute([":lvl" => $levels[$threshold] ?? 1]);
        return $stmt->fetchAll();
    }
    return $pdo->query("SELECT * FROM doctors ORDER BY featured DESC, name ASC")->fetchAll();
}
?>