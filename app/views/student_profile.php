<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information — <?= htmlspecialchars($name); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #3b82f6;
            --primary-dim: #2563eb;
            --primary-glow: rgba(59,130,246,0.15);
            --primary-glow-strong: rgba(59,130,246,0.25);
            --bg: #0a0a0b;
            --bg2: #111113;
            --bg3: #18181b;
            --card-bg: #131315;
            --border: rgba(255,255,255,0.06);
            --border-hot: rgba(59,130,246,0.25);
            --text: #f4f4f5;
            --text-muted: #71717a;
            --text-dim: #3f3f46;
            --radius: 16px;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Background effects */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: 
                linear-gradient(var(--border) 1px, transparent 1px),
                linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
            z-index: 0;
            mask-image: radial-gradient(ellipse 80% 60% at 50% 30%, black 30%, transparent 100%);
        }

        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }
        .orb-1 {
            width: 500px; height: 500px;
            top: -200px; right: -100px;
            background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%);
        }
        .orb-2 {
            width: 400px; height: 400px;
            bottom: -150px; left: -100px;
            background: radial-gradient(circle, rgba(59,130,246,0.05) 0%, transparent 70%);
        }

        /* Nav */
        nav {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2.5rem;
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 0.5rem;
            backdrop-filter: blur(12px);
            width: 100%;
            max-width: 480px;
            justify-content: center;
        }

        nav a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.85rem;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            transition: all 0.2s;
        }

        nav a:hover { 
            color: var(--text); 
            background: var(--bg3);
        }

        nav a.active {
            color: #fff;
            background: var(--primary);
            box-shadow: 0 0 20px var(--primary-glow-strong);
        }

        /* ID Card */
        .id-card {
            position: relative;
            z-index: 1;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            max-width: 480px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }

        .id-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            opacity: 0.5;
            z-index: 2;
        }

        /* Header */
        .id-header {
            background: linear-gradient(135deg, rgba(59,130,246,0.1), rgba(59,130,246,0.02));
            padding: 1.75rem 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .id-header h1 {
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .id-header h1 span {
            color: var(--primary);
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(59,130,246,0.2), rgba(59,130,246,0.05));
            border: 2px solid var(--border-hot);
            color: var(--primary);
            font-weight: 700;
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0.75rem auto 0;
            box-shadow: 0 0 40px var(--primary-glow);
        }

        .avatar-status {
            position: relative;
        }
        .avatar-status::after {
            content: '';
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #22c55e;
            border: 2px solid var(--card-bg);
            box-shadow: 0 0 10px rgba(34,197,94,0.3);
        }

        /* Body */
        .id-body {
            padding: 1.75rem 2rem 2rem;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.7rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            font-size: 0.88rem;
        }

        .row:last-child {
            border-bottom: none;
        }

        .row .label {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .row .value {
            text-align: right;
            max-width: 60%;
            font-weight: 500;
            color: var(--text);
            word-break: break-word;
        }

        .row .value .tag {
            display: inline-block;
            background: rgba(59,130,246,0.1);
            border: 1px solid var(--border-hot);
            padding: 0.15rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
            color: var(--primary);
            margin: 0.1rem 0.15rem;
        }

        /* Bio */
        .bio {
            margin-top: 1.25rem;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.05);
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.7;
            font-style: italic;
            text-align: center;
            background: rgba(59,130,246,0.03);
            border-radius: 10px;
            padding: 1rem;
        }

        .bio .quote-mark {
            color: var(--primary);
            font-size: 1.2rem;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .id-header { padding: 1.5rem 1.25rem; }
            .id-body { padding: 1.25rem; }
            .row { font-size: 0.82rem; }
            nav { flex-wrap: wrap; gap: 0.25rem; }
            nav a { font-size: 0.8rem; padding: 0.4rem 0.8rem; }
        }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<nav>
    <a href="<?= site_url('student'); ?>">🏠 Home</a>
    <a href="<?= site_url('student/profile'); ?>" class="active">👤 Profile</a>
</nav>

<div class="id-card">
    <div class="id-header">
        <h1>Student <span>Information</span></h1>
        <div class="avatar avatar-status">
            <?= htmlspecialchars(strtoupper(substr($name, 0, 1))); ?>
        </div>
    </div>
    <div class="id-body">
        <div class="row">
            <span class="label">Student ID</span>
            <span class="value"><?= htmlspecialchars($student_id); ?></span>
        </div>
        <div class="row">
            <span class="label">Name</span>
            <span class="value"><?= htmlspecialchars($name); ?></span>
        </div>
        <div class="row">
            <span class="label">Course</span>
            <span class="value"><?= htmlspecialchars($course); ?></span>
        </div>
        <div class="row">
            <span class="label">Year Level</span>
            <span class="value"><?= htmlspecialchars($year); ?></span>
        </div>
        <div class="row">
            <span class="label">Section</span>
            <span class="value"><?= htmlspecialchars($section); ?></span>
        </div>
        <div class="row">
            <span class="label">Email</span>
            <span class="value" style="font-size:0.8rem;"><?= htmlspecialchars($email); ?></span>
        </div>
        <div class="row">
            <span class="label">Address</span>
            <span class="value"><?= htmlspecialchars($address); ?></span>
        </div>
        <div class="row">
            <span class="label">Contact</span>
            <span class="value"><?= htmlspecialchars($contact); ?></span>
        </div>
        <div class="row">
            <span class="label">Skills</span>
            <span class="value">
                <?php 
                $skills_array = explode(', ', $skills);
                foreach ($skills_array as $skill): 
                ?>
                    <span class="tag"><?= htmlspecialchars($skill); ?></span>
                <?php endforeach; ?>
            </span>
        </div>
        <p class="bio">
            <span class="quote-mark">"</span> 
            <?= htmlspecialchars($bio); ?> 
            <span class="quote-mark">"</span>
        </p>
    </div>
</div>

</body>
</html>