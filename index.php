<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FeedTrack — Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #628338;
            --brand-dark: #4a6429;
            --brand-light: #a5cba1;
            --ink: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
            --bg: #f4f6f1;
            --danger: #b91c1c;
            --danger-bg: #fef2f2;
            --danger-border: #fecaca;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg);
            color: var(--ink);
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 940px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(31, 41, 55, 0.12);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.05fr 1fr;
        }

        /* Left brand panel */
        .brand {
            position: relative;
            padding: 48px 44px;
            color: #fff;
            background:
                radial-gradient(120% 120% at 0% 0%, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0) 45%),
                linear-gradient(155deg, var(--brand) 0%, var(--brand-dark) 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .brand::after {
            content: "";
            position: absolute;
            right: -80px;
            bottom: -80px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 0.2px;
        }

        .brand-logo img {
            height: 40px;
            width: 40px;
            object-fit: cover;
            border-radius: 10px;
            background: #fff;
            padding: 3px;
        }

        .brand-copy { position: relative; z-index: 1; }
        .brand-copy h2 {
            font-size: 28px;
            line-height: 1.25;
            margin: 0 0 12px;
            font-weight: 800;
        }
        .brand-copy p {
            margin: 0;
            font-size: 15px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.85);
            max-width: 34ch;
        }

        .brand-features {
            list-style: none;
            padding: 0;
            margin: 24px 0 0;
            display: grid;
            gap: 10px;
            position: relative;
            z-index: 1;
        }
        .brand-features li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.92);
        }
        .brand-features svg { flex-shrink: 0; }

        .brand-foot {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            position: relative;
            z-index: 1;
        }

        /* Right form panel */
        .form-panel {
            padding: 52px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-panel h1 {
            margin: 0 0 6px;
            font-size: 26px;
            font-weight: 700;
        }
        .form-panel .subtitle {
            margin: 0 0 28px;
            color: var(--muted);
            font-size: 15px;
        }

        .field { margin-bottom: 18px; }
        .field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
        }

        .input-wrap { position: relative; }
        .input-wrap .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 13px 14px 13px 44px;
            font-size: 15px;
            font-family: inherit;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: #fafafa;
            color: var(--ink);
            transition: border-color .15s, box-shadow .15s, background .15s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--brand);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(98, 131, 56, 0.15);
        }

        .toggle-pass {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            padding: 6px;
            display: flex;
            border-radius: 6px;
        }
        .toggle-pass:hover { color: var(--brand); }

        button[type="submit"] {
            width: 100%;
            margin-top: 8px;
            padding: 14px;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            color: #fff;
            background: var(--brand);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background .2s, transform .05s;
        }
        button[type="submit"]:hover { background: var(--brand-dark); }
        button[type="submit"]:active { transform: translateY(1px); }

        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--danger-bg);
            border: 1px solid var(--danger-border);
            color: var(--danger);
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 22px;
        }
        .alert svg { flex-shrink: 0; }

        .form-foot {
            margin-top: 26px;
            text-align: center;
            font-size: 12px;
            color: var(--muted);
        }

        @media (max-width: 780px) {
            .card { grid-template-columns: 1fr; max-width: 440px; }
            .brand { display: none; }
            .form-panel { padding: 40px 32px; }
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Brand panel -->
        <aside class="brand">
            <div class="brand-logo">
                <img src="frontend/icons/goodwill logo.jfif" alt="Goodwill Farms logo">
                <span>FeedTrack</span>
            </div>

            <div class="brand-copy">
                <h2>Manage your farm inventory with confidence.</h2>
                <p>Track feed stock, production, and orders — all in one place.</p>
                <ul class="brand-features">
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        Real-time inventory tracking
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        Production &amp; order management
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        Detailed reports &amp; activity logs
                    </li>
                </ul>
            </div>

            <div class="brand-foot">© 2024 Goodwill Farms. All rights reserved.</div>
        </aside>

        <!-- Form panel -->
        <main class="form-panel">
            <h1>Welcome back</h1>
            <p class="subtitle">Sign in to your FeedTrack account.</p>

            <?php if (isset($_GET['error'])) { ?>
                <div class="alert" role="alert">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span><?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            <?php } ?>

            <form action="login.php" method="post" autocomplete="on">
                <div class="field">
                    <label for="username">Username or email</label>
                    <div class="input-wrap">
                        <span class="icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <input type="text" id="username" name="name" placeholder="Enter your username" required autofocus>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span class="icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <button type="button" class="toggle-pass" id="togglePass" aria-label="Show password">
                            <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit">Sign In</button>
            </form>

            <p class="form-foot">Need access? Contact your administrator.</p>
        </main>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('togglePass');
            var pass = document.getElementById('password');
            var eye = document.getElementById('eyeIcon');
            var shown = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>';
            var hidden = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-10-7-10-7a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 10 7 10 7a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            btn.addEventListener('click', function () {
                var isPw = pass.type === 'password';
                pass.type = isPw ? 'text' : 'password';
                eye.innerHTML = isPw ? hidden : shown;
                btn.setAttribute('aria-label', isPw ? 'Hide password' : 'Show password');
            });
        })();
    </script>
</body>
</html>
