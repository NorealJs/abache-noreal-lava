<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Product Manager</title>
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700;800&family=Unbounded:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --lava: #3b82f6;
            --lava-dim: #2563eb;
            --lava-glow: rgba(59,130,246,0.15);
            --lava-glow-strong: rgba(59,130,246,0.25);
            --bg: #0a0a0b;
            --bg2: #111113;
            --bg3: #18181b;
            --border: rgba(234, 32, 32, 0.07);
            --border-hot: rgba(59,130,246,0.35);
            --text: #f4f4f5;
            --text-muted: #71717a;
            --text-dim: #3f3f46;
            --mono: 'Fira Code', monospace;
            --sans: 'Unbounded', sans-serif;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--sans);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            overflow-x: hidden;
            position: relative;
        }

        /* ── NOISE TEXTURE ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
        }

        /* ── GRID BACKGROUND ── */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(var(--border) 1px, transparent 1px),
                linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
            z-index: 0;
            mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, black 30%, transparent 100%);
        }

        /* ── GLOW ORBS ── */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }
        .orb-1 {
            width: 600px; height: 600px;
            top: -200px; left: -100px;
            background: radial-gradient(circle, rgba(59,130,246,0.12) 0%, transparent 70%);
        }
        .orb-2 {
            width: 400px; height: 400px;
            bottom: -100px; right: -100px;
            background: radial-gradient(circle, rgba(59,130,246,0.07) 0%, transparent 70%);
        }

        /* ── CARD ── */
        .card {
            position: relative;
            z-index: 1;
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 16px;
            width: 100%;
            max-width: 400px;
            padding: 2.5rem 2rem;
            backdrop-filter: blur(12px);
            background: rgba(17,17,19,0.85);
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }

        .card::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--lava-glow-strong), transparent);
            opacity: 0.6;
        }

        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .card-logo {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text);
            text-decoration: none;
            margin-bottom: 0.5rem;
        }

        .card-logo .flame {
            width: 32px;
            height: 32px;
            background: var(--lava);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 0 20px var(--lava-glow-strong);
        }

        .card h1 {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }

        .card .subtitle {
            color: var(--text-muted);
            font-size: 0.88rem;
            font-weight: 400;
        }

        /* ── MESSAGES ── */
        .msg {
            padding: 0.7rem 0.9rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 1rem;
            border: 1px solid transparent;
        }
        .msg.error {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }
        .msg.info {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
        }
        .msg.success {
            background: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.2);
            color: #4ade80;
        }

        /* ── FORM ── */
        form {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 0.35rem;
            margin-top: 0.5rem;
        }

        label:first-of-type {
            margin-top: 0;
        }

        input {
            width: 100%;
            padding: 0.7rem 0.9rem;
            background: var(--bg3);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.92rem;
            font-family: var(--sans);
            color: var(--text);
            transition: all 0.2s;
            outline: none;
        }

        input::placeholder {
            color: var(--text-dim);
        }

        input:focus {
            border-color: var(--lava);
            box-shadow: 0 0 0 3px var(--lava-glow);
        }

        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px var(--bg3) inset !important;
            -webkit-text-fill-color: var(--text) !important;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            margin-top: 1rem;
            background: var(--lava);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: var(--sans);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 0 0 0 var(--lava-glow);
        }

        button:hover {
            background: var(--lava-dim);
            box-shadow: 0 0 30px var(--lava-glow-strong), 0 4px 15px rgba(0,0,0,0.3);
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        /* ── FOOTER LINK ── */
        .footer-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.82rem;
            color: var(--text-muted);
            padding-top: 1.25rem;
            border-top: 1px solid var(--border);
        }

        .footer-link a {
            color: var(--lava);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .footer-link a:hover {
            color: #60a5fa;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 480px) {
            .card {
                padding: 1.75rem 1.25rem;
            }
            .card h1 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="card">
    <div class="card-header">
        <a class="card-logo" href="#">
            <div class="flame">🔥</div>
            LavaLust
        </a>
        <h1>Welcome back</h1>
        <p class="subtitle">Sign in to manage your products.</p>
    </div>

    <?php if (!empty($denied)): ?>
        <div class="msg info">Please log in to continue.</div>
    <?php endif; ?>
    <?php if (!empty($registered)): ?>
        <div class="msg success">Account created. You can now log in.</div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="msg error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('login'); ?>">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" autocomplete="username" required autofocus>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>

        <button type="submit">Log In</button>
    </form>

    <div class="footer-link">
        Don't have an account? <a href="<?= base_url('register'); ?>">Register</a>
    </div>
</div>

</body>
</html>