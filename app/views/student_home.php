<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal — Home</title>
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

        /* Card */
        .card {
            position: relative;
            z-index: 1;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2.5rem 2.5rem 2.8rem;
            max-width: 480px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            opacity: 0.5;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        /* Badge */
        .badge-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(59,130,246,0.05));
            border: 1px solid var(--border-hot);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.25rem;
            box-shadow: 0 0 40px var(--primary-glow);
        }

        .badge-icon .flame {
            filter: drop-shadow(0 0 10px var(--primary-glow-strong));
        }

        /* Typography */
        h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 0.4rem;
        }

        h1 .highlight {
            color: var(--primary);
        }

        p.sub {
            color: var(--text-muted);
            font-size: 0.92rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-weight: 400;
        }

        /* Notice */
        .notice {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.15);
            border-radius: 10px;
            padding: 0.8rem 1rem;
            font-size: 0.85rem;
            color: #f87171;
            margin-bottom: 1.5rem;
            line-height: 1.5;
            text-align: left;
        }

        .notice strong {
            color: #fca5a5;
        }

        /* Button */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            padding: 0.75rem 1.8rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: var(--primary-dim);
            box-shadow: 0 0 30px var(--primary-glow-strong), 0 4px 20px rgba(0,0,0,0.3);
            transform: translateY(-1px);
        }

        .btn .arrow {
            transition: transform 0.2s;
        }
        .btn:hover .arrow {
            transform: translateX(3px);
        }

        /* Status dot */
        .status-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            margin-right: 0.3rem;
            box-shadow: 0 0 10px rgba(34,197,94,0.3);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .card { padding: 2rem 1.5rem; }
            nav { flex-wrap: wrap; gap: 0.25rem; }
            nav a { font-size: 0.8rem; padding: 0.4rem 0.8rem; }
        }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<nav>
    <a href="<?= site_url('student'); ?>" class="active">🏠 Home</a>
    <a href="<?= site_url('student/profile'); ?>">👤 Profile</a>
</nav>

<div class="card">
    <div class="badge-icon">
        <span class="flame">🔥</span>
    </div>
    <h1>Welcome! <span class="highlight"><?= htmlspecialchars($name); ?></span></h1>
    <p class="sub">
        <span class="status-dot"></span> 
       Welcome to your student portal. Viewing this page automatically grants you a temporary access badge.
    </p>

    <?php if ($denied): ?>
        <div class="notice">
            <strong>⛔ Access Denied:</strong> You need an active badge before viewing the profile page.<br>
            <span style="color: #86efac;">✓ It's been granted now — try the link below.</span>
        </div>
    <?php endif; ?>

    <a class="btn" href="<?= site_url('student/profile'); ?>">
        View My Profile <span class="arrow">→</span>
    </a>
</div>

</body>
</html>