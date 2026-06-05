<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — UD FALSUD Rental Motor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --yellow:        #f5c800;
            --yellow-dark:   #c9a000;
            --yellow-glow:   rgba(245,200,0,0.35);
            --yellow-light:  rgba(245,200,0,0.13);
            --yellow-border: rgba(245,200,0,0.4);
            --card-bg:       rgba(10,8,0,0.10);
            --input-bg:      rgba(255,255,255,0.07);
            --input-border:  rgba(255,255,255,0.15);
            --text:          #ffffff;
            --text-label:    #e2d89a;
            --text-muted:    #b0a060;
            --font:          'Sora', sans-serif;
            --mono:          'JetBrains Mono', monospace;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font);
            background:
                linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
                url('{{ asset("images/motors/mottor.jpg") }}') center/cover no-repeat fixed;
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* subtle grain overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.4;
        }

        /* Glow orbs */
        .orb { position: fixed; border-radius: 50%; filter: blur(90px); pointer-events: none; z-index: 0; }
        .orb-1 { width: 520px; height: 520px; background: radial-gradient(circle, rgba(245,200,0,0.14), transparent 65%); top: -160px; right: -80px; }
        .orb-2 { width: 380px; height: 380px; background: radial-gradient(circle, rgba(245,200,0,0.09), transparent 65%); bottom: -100px; left: -60px; }

        /* Card */
        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
            padding: 52px 48px 44px;
            background: var(--card-bg);
            backdrop-filter: blur(28px) saturate(1.3);
            -webkit-backdrop-filter: blur(28px) saturate(1.3);
            border: 1px solid rgba(245,200,0,0.25);
            border-radius: 28px;
            box-shadow:
                0 0 0 0.5px rgba(245,200,0,0.12),
                0 32px 80px rgba(0,0,0,0.6),
                inset 0 1px 0 rgba(255,255,255,0.08);
            animation: cardIn 0.55s cubic-bezier(0.16,1,0.3,1) forwards;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Gold top bar */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 10%; right: 10%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--yellow), #ffe980, transparent);
            border-radius: 2px;
        }

        /* Brand */
        .brand-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 36px;
        }

        .logo-wrap {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
            border: 2.5px solid var(--yellow);
            box-shadow: 0 0 0 6px rgba(245,200,0,0.12), 0 6px 24px rgba(245,200,0,0.3);
            margin-bottom: 16px;
            animation: floatLogo 4s ease-in-out infinite;
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-8px); }
        }

        /* Status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 16px;
            background: rgba(245,200,0,0.1);
            border: 1px solid rgba(245,200,0,0.3);
            border-radius: 20px;
            font-size: 10px;
            font-family: var(--mono);
            color: var(--yellow);
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .status-dot {
            width: 6px; height: 6px;
            background: #22c55e;
            border-radius: 50%;
            box-shadow: 0 0 6px #22c55e;
            animation: blink 2s ease-in-out infinite;
        }

        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

        /* Divider */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(245,200,0,0.2), transparent);
            margin-bottom: 28px;
        }

        /* Error */
        .error-box {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px;
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 10px;
            margin-bottom: 22px;
            font-size: 13px;
            color: #fca5a5;
        }

        /* Form groups */
        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-label);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 9px;
            font-family: var(--mono);
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            pointer-events: none;
            color: var(--text-muted);
            transition: color 0.2s;
        }

        .form-input {
            width: 100%;
            padding: 14px 48px 14px 46px;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            color: #ffffff;
            font-family: var(--font);
            font-size: 14.5px;
            outline: none;
            transition: all 0.2s;
        }

        .form-input:focus {
            border-color: var(--yellow);
            background: rgba(255,255,255,0.1);
            box-shadow: 0 0 0 4px rgba(245,200,0,0.12);
        }

        .input-wrap:focus-within .input-icon { color: var(--yellow); }
        .form-input::placeholder { color: rgba(255,255,255,0.3); }

        /* Toggle password */
        .toggle-pw {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; padding: 4px;
            color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
            border-radius: 6px;
            transition: color 0.2s, background 0.2s;
            outline: none;
        }

        .toggle-pw:hover { color: var(--yellow); background: var(--yellow-light); }
        .toggle-pw svg { width: 17px; height: 17px; }

        /* Login button */
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--yellow) 0%, #ffe566 100%);
            border: none;
            border-radius: 13px;
            color: #1a1200;
            font-family: var(--font);
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
            margin-top: 8px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            box-shadow: 0 4px 20px rgba(245,200,0,0.4);
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(245,200,0,0.55);
        }

        .btn-login:hover::after { left: 100%; }
        .btn-login:active { transform: translateY(1px); box-shadow: 0 2px 10px rgba(245,200,0,0.3); }

        /* Footer */
        .card-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.07);
            text-align: center;
        }

        .footer-text {
            font-size: 11px;
            color: var(--text-muted);
            font-family: var(--mono);
        }

        .footer-text b { color: var(--yellow); font-weight: 600; }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="login-card">

    <div class="brand-section">
        <img class="logo-wrap"
             src="{{ asset('images/motors/logofalsud.png') }}"
             alt="UD FALSUD Rental Motor">
        <div class="status-badge">
            <span class="status-dot"></span>sistem aktif
        </div>
    </div>

    <div class="divider"></div>

    @if($errors->any())
    <div class="error-box">⚠️ {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">Email</label>
            <div class="input-wrap">
                <span class="input-icon">✉</span>
                <input type="text" name="email" class="form-input"
                    placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    autocomplete="email" autofocus>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <div class="input-wrap">
                <span class="input-icon">🔒</span>
                <input type="password" id="passwordInput" name="password"
                    class="form-input"
                    placeholder="••••••••"
                    autocomplete="current-password">
                <button type="button" class="toggle-pw" id="togglePw" onclick="togglePassword()">
                    <svg id="iconEye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg id="iconEyeOff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                        <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-login">Login</button>
    </form>

    <div class="card-footer">
        <p class="footer-text">© 2025 <b>UD FALSUD</b> — Rental Motor Malang</p>
    </div>

</div>

<script>
function togglePassword() {
    const input  = document.getElementById('passwordInput');
    const eyeOn  = document.getElementById('iconEye');
    const eyeOff = document.getElementById('iconEyeOff');
    const btn    = document.getElementById('togglePw');
    if (input.type === 'password') {
        input.type = 'text';
        eyeOn.style.display  = 'none';
        eyeOff.style.display = 'block';
        btn.style.color      = '#f5c800';
    } else {
        input.type = 'password';
        eyeOn.style.display  = 'block';
        eyeOff.style.display = 'none';
        btn.style.color      = '';
    }
}
</script>
</body>
</html>