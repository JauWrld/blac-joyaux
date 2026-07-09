<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Connexion</title>
    <style>
        body {
            font-family: Inter, system-ui, Segoe UI, Arial;
            background: #0b0a09;
            color: #fffaf0;
            margin: 0;
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .box {
            width: min(520px, calc(100% - 32px));
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .05);
            padding: 32px;
            border-radius: 12px;
        }

        .admin-icon {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .admin-icon svg {
            width: 48px;
            height: 48px;
            color: #c6a75e;
            opacity: 0.8;
        }

        h1 {
            margin: 0 0 14px;
            font-size: 22px;
            text-align: center;
            color: #c6a75e;
        }

        .status {
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(198, 167, 94, .12);
            border: 1px solid rgba(198, 167, 94, .35);
            margin-bottom: 12px;
            color: #fffaf0;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #fffaf0;
            margin: 14px 0 6px;
            letter-spacing: 0.02em;
        }

        input {
            width: 100%;
            min-height: 44px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(0, 0, 0, .25);
            color: #fffaf0;
            padding: 0 12px;
            font-size: 15px;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: rgba(198, 167, 94, .5);
        }

        button {
            margin-top: 18px;
            min-height: 46px;
            padding: 0 16px;
            border-radius: 999px;
            border: 1px solid rgba(198, 167, 94, .44);
            background: rgba(198, 167, 94, .12);
            color: #c6a75e;
            font-weight: 800;
            cursor: pointer;
            width: 100%;
            font-size: 14px;
            letter-spacing: 0.05em;
            transition: background 0.2s;
        }

        button:hover {
            background: rgba(198, 167, 94, .22);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 16px;
            color: rgba(255, 255, 255, .5);
            font-size: 13px;
            text-decoration: none;
        }

        .back-link:hover {
            color: #c6a75e;
        }
    </style>
</head>

<body>
    <div class="box">
        <div class="admin-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="8" r="4" />
                <path d="M4 21c0-4 3.6-7 8-7s8 3 8 7" />
            </svg>
        </div>
        <h1>Connexion Admin</h1>
        @if (session('status'))
        <div class="status">{{ session('status') }}</div>
        @endif
        <form method="post" action="{{ route('admin.login.post') }}">
            @csrf
            <label for="email">Adresse email</label>
            <input id="email" type="email" name="email" required placeholder="admin@blac-joyaux.com" />
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required placeholder="••••••••" />
            <button type="submit">Se connecter</button>
        </form>
        <a class="back-link" href="{{ route('home') }}">← Retour à l'accueil</a>
    </div>
</body>

</html>
