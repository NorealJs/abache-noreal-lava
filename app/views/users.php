<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users · Academic Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@400;600&display=swap');

        :root {
            --clay: #D9C9B4;
            --clay-light: #EDE4D8;
            --clay-dark: #B8A48C;
            --ink: #211F1C;
            --ink-faded: #5B5347;
            --accent: #A73F2E;
            --accent-soft: #CF7B6A;
            --pine: #2B4A3F;
            --pine-light: #3F6354;
            --card-bg: #F7F1E9;
            --border: rgba(33, 31, 28, 0.10);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--clay-dark);
            color: var(--ink);
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* ---- paper texture ---- */
        .paper-surface {
            background-color: var(--card-bg);
            background-image: 
                linear-gradient(rgba(200, 180, 160, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(200, 180, 160, 0.08) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* ---- header tabs (minimalist) ---- */
        .tab-btn {
            position: relative;
            font-weight: 500;
            letter-spacing: 0.01em;
            border-radius: 12px 12px 0 0;
            transition: all 0.15s ease;
            padding: 0.65rem 1.5rem;
            font-size: 0.85rem;
            background: transparent;
            color: var(--ink-faded);
            border-bottom: 2px solid transparent;
        }

        .tab-btn.active {
            background: var(--card-bg);
            color: var(--ink);
            border-bottom: 2px solid var(--accent);
            box-shadow: 0 -2px 8px rgba(0,0,0,0.02);
        }

        .tab-btn:not(.active):hover {
            background: rgba(255, 255, 255, 0.15);
            color: var(--ink);
            border-bottom: 2px solid var(--clay);
        }

        /* ---- card ---- */
        .entry-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 24px -12px rgba(0,0,0,0.20), 0 2px 0 0 rgba(255,255,255,0.6) inset;
            transition: transform 0.1s ease, box-shadow 0.2s ease;
            border: 1px solid rgba(33,31,28,0.04);
            padding: 1.5rem 1.5rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .entry-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 32px -20px rgba(0,0,0,0.35);
        }

        .entry-card .avatar {
            width: 48px;
            height: 48px;
            border-radius: 100px;
            background: var(--clay-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--pine);
            flex-shrink: 0;
            border: 1px solid rgba(33,31,28,0.06);
        }

        .entry-card .name {
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: -0.01em;
        }

        .entry-card .role-badge {
            background: var(--clay-light);
            padding: 0.2rem 0.9rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: var(--ink-faded);
            display: inline-block;
            border: 1px solid rgba(0,0,0,0.02);
        }

        .entry-card .email {
            font-size: 0.8rem;
            color: var(--ink-faded);
            font-family: 'JetBrains Mono', monospace;
            background: var(--clay-light);
            padding: 0.2rem 0.7rem;
            border-radius: 40px;
            display: inline-block;
            border: 1px solid rgba(0,0,0,0.02);
        }

        .entry-card .meta-line {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 0.25rem;
        }

        .entry-card .divider {
            border-top: 1px solid var(--border);
            margin: 0.25rem 0 0.5rem;
            opacity: 0.6;
        }

        /* ---- stamp / indicator ---- */
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 100px;
            background: var(--pine-light);
            display: inline-block;
            margin-right: 0.3rem;
        }
        .status-dot.active { background: #2B7A4B; }
        .status-dot.pending { background: #D4A24C; }
        .status-dot.inactive { background: var(--accent-soft); }

        /* ---- scroll ----- */
        .scrollable {
            scrollbar-width: thin;
            scrollbar-color: var(--clay) transparent;
        }
        .scrollable::-webkit-scrollbar {
            width: 6px;
        }
        .scrollable::-webkit-scrollbar-track {
            background: transparent;
        }
        .scrollable::-webkit-scrollbar-thumb {
            background: var(--clay);
            border-radius: 20px;
        }

        /* ---- small helpers ---- */
        .font-serif { font-family: 'Instrument Serif', serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        .badge-pine {
            background: var(--pine);
            color: white;
            padding: 0.15rem 0.9rem;
            border-radius: 40px;
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }
    </style>
</head>
<body>

    <!-- header -->
    <header class="flex-shrink-0 pt-4 px-6" style="background: var(--clay-light); border-bottom: 1px solid rgba(0,0,0,0.04);">
        <div class="flex items-end justify-between">
            <div class="flex items-end gap-2">
                <div class="tab-btn active">
                    <i class="fa-regular fa-address-book mr-2"></i>Registry
                </div>
                <div class="tab-btn active">
                    <i class="fa-regular fa-user mr-2"></i>Users
                </div>
                <a href="#" class="tab-btn hidden md:inline-flex">
                    <i class="fa-regular fa-chart-bar mr-2"></i>Reports
                </a>
                <a href="#" class="tab-btn hidden lg:inline-flex">
                    <i class="fa-regular fa-gear mr-2"></i>Settings
                </a>
            </div>
            <div class="text-xs font-mono opacity-60 pb-2">
                <i class="fa-regular fa-clock mr-1"></i> v.2.4
            </div>
        </div>
    </header>

    <!-- main -->
    <main class="flex-1 overflow-y-auto scrollable paper-surface px-6 py-8">
        <div class="max-w-7xl mx-auto">

            <!-- top bar -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-8">
                <div>
                    <span class="inline-block text-xs font-mono tracking-widest uppercase" style="color: var(--accent); letter-spacing: 0.12em;">
                        <i class="fa-regular fa-file-lines mr-1"></i> Registrar file
                    </span>
                    <h2 class="text-2xl font-semibold tracking-tight mt-0.5 flex items-center gap-2">
                        <span>User directory</span>
                        <span class="text-sm font-normal text-ink-faded/60 font-mono">·</span>
                        <span class="text-sm font-normal text-ink-faded/70 font-mono">
                            <?= isset($users) ? count($users) : 0 ?> record<?= (isset($users) && count($users) === 1) ? '' : 's' ?>
                        </span>
                    </h2>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-mono text-ink-faded/60 bg-white/70 px-4 py-1.5 rounded-full border border-black/5 shadow-sm">
                        <i class="fa-regular fa-magnifying-glass mr-2"></i>filter · active
                    </span>
                </div>
            </div>

            <!-- grid -->
            <?php if (!empty($users)) : ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($users as $user) : ?>
                        <div class="entry-card">
                            <div class="flex items-start gap-4">
                                <div class="avatar">
                                    <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="name truncate">
                                        <?= htmlspecialchars($user['name'] ?? 'Unnamed') ?>
                                    </div>
                                    <div class="meta-line">
                                        <span class="role-badge">
                                            <i class="fa-regular fa-user-tie mr-1 text-[0.6rem]"></i>
                                            <?= htmlspecialchars($user['role'] ?? 'member') ?>
                                        </span>
                                        <span class="text-xs text-ink-faded/70 font-mono">
                                            #<?= htmlspecialchars($user['id'] ?? '000') ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="divider"></div>

                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span class="email">
                                    <i class="fa-regular fa-envelope mr-1.5 opacity-50"></i>
                                    <?= htmlspecialchars($user['email'] ?? '—') ?>
                                </span>
                                <span class="flex items-center text-xs font-medium">
                                    <span class="status-dot <?= ($user['status'] ?? 'active') === 'active' ? 'active' : (($user['status'] ?? '') === 'pending' ? 'pending' : 'inactive') ?>"></span>
                                    <?= ucfirst($user['status'] ?? 'active') ?>
                                </span>
                            </div>

                            <div class="flex items-center justify-between text-[0.65rem] text-ink-faded/60 font-mono mt-0.5">
                                <span>
                                    <i class="fa-regular fa-calendar mr-1"></i>
                                    <?= $user['joined'] ?? 'joined recently' ?>
                                </span>
                                <span class="bg-black/5 px-2 py-0.5 rounded-full">
                                    <i class="fa-regular fa-fingerprint mr-1"></i>
                                    <?= substr(md5($user['id'] ?? '0'), 0, 6) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="text-center py-24 bg-white/40 rounded-3xl border border-black/5 backdrop-blur-sm">
                    <div class="text-5xl opacity-20 mb-4"><i class="fa-regular fa-folder-open"></i></div>
                    <p class="text-ink-faded/70 font-medium">No user records found</p>
                    <p class="text-sm text-ink-faded/50 font-mono mt-1">The directory is empty</p>
                </div>
            <?php endif; ?>

            <!-- footer note -->
            <div class="mt-12 text-[0.65rem] font-mono text-ink-faded/40 flex items-center gap-4 border-t border-black/5 pt-4">
                <span><i class="fa-regular fa-shield mr-1"></i> restricted access</span>
                <span>·</span>
                <span>academic registry · <?= date('Y') ?></span>
            </div>

        </div>
    </main>

</body>
</html>