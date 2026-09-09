<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$is_admin = (($_SESSION['role'] ?? null) === 'admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | Product Manager</title>
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
            padding: 2.5rem 1.5rem;
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

        /* ── WRAPPER ── */
        .wrap {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
        }

        /* ── TOPBAR ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            padding: 1.5rem 2rem;
            background: rgba(17,17,19,0.85);
            border: 1px solid var(--border);
            border-radius: 12px;
            backdrop-filter: blur(12px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar-logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text);
            text-decoration: none;
        }

        .topbar-logo .flame {
            width: 28px;
            height: 28px;
            background: var(--lava);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            box-shadow: 0 0 20px var(--lava-glow-strong);
        }

        .topbar h1 {
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .topbar-divider {
            width: 1px;
            height: 28px;
            background: var(--border);
        }

        .actions {
            display: flex;
            gap: 0.6rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .user-badge {
            font-size: 0.8rem;
            color: var(--text-muted);
            padding: 0.4rem 0.8rem;
            background: var(--bg3);
            border-radius: 6px;
            border: 1px solid var(--border);
        }

        .user-badge strong {
            color: var(--text);
        }

        .role-badge {
            background: var(--bg3);
            color: var(--text-muted);
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            margin-left: 0.3rem;
            border: 1px solid var(--border);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .role-badge.admin {
            color: var(--lava);
            border-color: var(--border-hot);
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.55rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            font-family: var(--sans);
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--lava);
            color: #fff;
            box-shadow: 0 0 0 0 var(--lava-glow);
        }

        .btn-primary:hover {
            background: var(--lava-dim);
            box-shadow: 0 0 20px var(--lava-glow-strong);
            transform: translateY(-1px);
        }

        .btn-muted {
            background: var(--bg3);
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        .btn-muted:hover {
            color: var(--text);
            border-color: rgba(255,255,255,0.2);
            background: var(--bg);
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.25);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .btn-sm {
            padding: 0.35rem 0.7rem;
            font-size: 0.72rem;
        }

        /* ── MESSAGES ── */
        .msg {
            padding: 0.7rem 0.9rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            border: 1px solid transparent;
        }
        .msg.success {
            background: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.2);
            color: #4ade80;
        }
        .msg.error {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }

        /* ── PANEL ── */
        .panel {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            backdrop-filter: blur(12px);
            background: rgba(17,17,19,0.85);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.85rem 1.1rem;
            text-align: left;
            font-size: 0.85rem;
        }

        th {
            background: var(--bg3);
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.06em;
            border-bottom: 1px solid var(--border);
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: rgba(59, 130, 246, 0.04);
        }

        td.desc {
            max-width: 260px;
            color: var(--text-muted);
            font-size: 0.82rem;
        }

        td.numeric {
            text-align: right;
            white-space: nowrap;
            font-family: var(--mono);
            font-size: 0.82rem;
        }

        td .id {
            color: var(--text-dim);
            font-family: var(--mono);
            font-size: 0.75rem;
        }

        td .price {
            color: var(--text);
        }

        .row-actions {
            display: flex;
            gap: 0.4rem;
        }

        .empty {
            padding: 3rem 2rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .empty .empty-icon {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 0.75rem;
            opacity: 0.3;
        }

        form.inline {
            display: inline;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            body {
                padding: 1.5rem 0.75rem;
            }
            .topbar {
                padding: 1rem 1.25rem;
                flex-direction: column;
                align-items: stretch;
            }
            .topbar-left {
                flex-wrap: wrap;
            }
            .actions {
                justify-content: flex-start;
            }
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            th, td {
                padding: 0.6rem 0.8rem;
                font-size: 0.78rem;
            }
            td.desc {
                max-width: 120px;
                white-space: normal;
            }
        }

        @media (max-width: 480px) {
            .topbar {
                padding: 0.75rem 1rem;
            }
            .topbar h1 {
                font-size: 1rem;
            }
            .actions {
                flex-wrap: wrap;
                gap: 0.4rem;
            }
            .btn {
                font-size: 0.7rem;
                padding: 0.4rem 0.7rem;
            }
            .user-badge {
                font-size: 0.7rem;
                padding: 0.3rem 0.6rem;
            }
            th, td {
                padding: 0.4rem 0.6rem;
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="wrap">
    <div class="topbar">
        <div class="topbar-left">
            <a class="topbar-logo" href="#">
                <div class="flame">🔥</div>
                LavaLust
            </a>
            <div class="topbar-divider"></div>
            <h1>Products</h1>
        </div>
        <div class="actions">
            <span class="user-badge">
                Signed in as <strong><?= htmlspecialchars($_SESSION['username'] ?? ''); ?></strong>
                <?php if (!$is_admin): ?>
                    <span class="role-badge">view only</span>
                <?php else: ?>
                    <span class="role-badge admin">admin</span>
                <?php endif; ?>
            </span>
            <?php if ($is_admin): ?>
                <a class="btn btn-primary" href="<?= base_url('products/create'); ?>">+ Add Product</a>
            <?php endif; ?>
            <a class="btn btn-muted" href="<?= base_url('logout'); ?>">Logout</a>
        </div>
    </div>

    <?php if (!empty($success)): ?>
        <div class="msg success"><?= htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="msg error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="panel">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Created</th>
                    <?php if ($is_admin): ?><th>Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><span class="id">#<?= htmlspecialchars($product['id']); ?></span></td>
                            <td><?= htmlspecialchars($product['product_name']); ?></td>
                            <td class="desc"><?= htmlspecialchars($product['description']); ?></td>
                            <td class="numeric"><span class="price">₱<?= number_format((float) $product['price'], 2); ?></span></td>
                            <td class="numeric"><?= htmlspecialchars($product['quantity']); ?></td>
                            <td><?= htmlspecialchars($product['created_at'] ?? ''); ?></td>
                            <?php if ($is_admin): ?>
                            <td>
                                <div class="row-actions">
                                    <a class="btn btn-muted btn-sm" href="<?= base_url('products/edit/' . $product['id']); ?>">Edit</a>
                                    <form class="inline" method="post" action="<?= base_url('products/delete/' . $product['id']); ?>" onsubmit="return confirm('Delete this product?');">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="<?= $is_admin ? 7 : 6; ?>" class="empty">
                        <span class="empty-icon">📦</span>
                        <?= $is_admin ? 'No products yet. Click "Add Product" to create one.' : 'No products yet.'; ?>
                    </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>