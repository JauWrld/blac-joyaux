@php
$brand = 'Blac Joyaux';
$nav = [
'home' => 'Maison',
'collection' => 'Collection',
'savoir-faire' => 'Savoir-faire',
'histoire' => "L'histoire",
'faq' => 'FAQ',
'contact' => 'Contact',
];
$title = $page === 'product' ? $product['name'] : ($pages[$page]['title'] ?? 'Page');
$cart = session('cart', []);
$cartItems = collect($cart)
->map(fn ($quantity, $slug) => isset($bags[$slug]) ? ['bag' => $bags[$slug], 'quantity' => $quantity] : null)
->filter();
$cartCount = $cartItems->sum('quantity');
$cartTotal = $cartItems->sum(fn ($item) => $item['bag']['price'] * $item['quantity']);
$favorites = session('favorites', []);
$faqs = [
['q' => 'Quels sont les délais de livraison ?', 'a' => "La livraison prend 24 à 72 heures à Abidjan, 3 à 5 jours ouvrés dans les autres villes de Côte d'Ivoire, et 7 à 12 jours ouvrés à l'international."],
['q' => 'Quels sont les moyens de paiement ?', 'a' => 'Vous pouvez payer par Mobile Money, Wave, carte bancaire ou virement. Un acompte peut être demandé pour les commandes personnalisées.'],
['q' => 'Comment entretenir un sac Blac Joyaux ?', 'a' => "Rangez votre sac dans sa housse, évitez l'eau et le soleil prolongé, puis nettoyez-le avec un chiffon doux. Pour le cuir, utilisez un soin adapté une à deux fois par an."],
['q' => "Les sacs sont-ils fabriqués en Côte d'Ivoire ?", 'a' => "Oui. Les sacs Blac Joyaux sont imaginés et assemblés en Côte d'Ivoire avec une attention particulière portée aux matières et aux finitions."],
['q' => 'Comment passer une commande ?', 'a' => 'Choisissez un modèle, ajoutez-le au panier, puis contactez notre équipe pour confirmer la disponibilité, le paiement et la livraison.'],
];
@endphp
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - {{ $brand }}</title>
    <meta name="description" content="{{ $brand }} - Maison ivoirienne de maroquinerie de luxe.">

    <style>
        :root {
            --ink: #0b0b0b;
            --line: rgba(255, 255, 255, .14);
            --text: #ffffff;
            --muted: #ffffff;
            --gold: #d4a843;
            --orange: #c97830;
            --gold-light: #e8c45a;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            min-height: 100vh;
            background: #0a0908;
            color: #ffffff;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            overflow-x: hidden;
        }

        a { color: inherit; text-decoration: none; }
        button, input, textarea { font: inherit; }

        .page-shell {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 75% 10%, rgba(212, 168, 67, .08), transparent 35%),
                radial-gradient(circle at 20% 30%, rgba(255, 215, 100, .04), transparent 40%),
                linear-gradient(180deg, #050505 0%, #0c0a08 58%, #050505 100%);
        }

        .bg-layer {
            position: absolute; inset: -40px;
            background-position: center; background-size: cover;
            opacity: .40; filter: saturate(0.9) contrast(0.9) blur(1px);
            transform: translate3d(0,0,0); will-change: transform;
            pointer-events: none;
        }

        .bg-overlay {
            position: absolute; inset: 0;
            background:
                radial-gradient(circle at 70% 18%, rgba(212,168,67,.04), transparent 40%),
                linear-gradient(180deg, rgba(5,5,5,0.18) 0%, rgba(10,10,10,0.06) 50%, rgba(5,5,5,0.12) 100%);
            pointer-events: none;
        }

        .bg-soft-light {
            position: absolute; inset: 0;
            background:
                radial-gradient(circle at 50% 0%, rgba(255,215,100,.35), transparent 50%),
                radial-gradient(circle at 15% 65%, rgba(212,168,67,.20), transparent 50%);
            mix-blend-mode: screen; opacity: .90;
            pointer-events: none;
        }

        .container { width: min(1180px, calc(100% - 32px)); margin: 0 auto; }
        .container-wide { width: min(1400px, calc(100% - 32px)); margin: 0 auto; }

        .site-header {
            position: sticky; top: 0; z-index: 20;
            border-bottom: 1px solid var(--line);
            background: rgba(5,5,5,0.70);
            backdrop-filter: blur(12px);
        }

        .header-inner {
            min-height: 78px; display: flex; align-items: center;
            justify-content: space-between; gap: 18px;
        }

        .brand {
            display: inline-flex; align-items: center; gap: 12px;
            color: var(--gold); font-weight: 800;
            text-transform: uppercase; letter-spacing: .2em;
            font-size: 16px;
        }

        .brand-mark {
            width: 36px; height: 36px;
            border: 1px solid rgba(212,168,67,.58);
            border-radius: 8px; display: grid; place-items: center;
            background: rgba(212,168,67,.08);
        }

        .nav { display: flex; align-items: center; gap: 6px; }
        .nav a, .icon-link, .menu-toggle, .button {
            border: 1px solid transparent; border-radius: 999px; transition: .2s ease;
        }

        .nav a {
            padding: 10px 14px; color: var(--muted);
            font-size: 13px; text-transform: uppercase; letter-spacing: .12em;
        }

        .nav a:hover, .nav a.active {
            color: var(--gold);
            border-color: rgba(212,168,67,.32);
            background: rgba(212,168,67,.08);
        }

        .header-actions { display: flex; gap: 10px; align-items: center; }

        .icon-link, .menu-toggle {
            position: relative; width: 42px; height: 42px;
            display: grid; place-items: center; color: var(--text);
            background: rgba(255,255,255,.05); border-color: var(--line); cursor: pointer;
        }

        .cart-badge, .fav-badge {
            position: absolute; right: -5px; top: -5px;
            min-width: 20px; height: 20px; border-radius: 999px;
            display: grid; place-items: center;
            background: var(--gold); color: #080706; font-size: 11px; font-weight: 900;
        }

        .icon-link:hover, .menu-toggle:hover, .button:hover {
            border-color: rgba(212,168,67,.6); transform: translateY(-1px);
        }

        .menu-toggle { display: none; }
        .mobile-nav { display: none; padding: 0 0 18px; }

        .mobile-nav a {
            display: block; padding: 14px 0; border-top: 1px solid var(--line);
            color: var(--muted); text-transform: uppercase;
            letter-spacing: .14em; font-size: 13px;
        }

        h1, h2, h3 {
            margin: 0; font-family: Georgia, "Times New Roman", serif;
            font-weight: 700; color: #ffffff;
            text-shadow: 0 2px 15px rgba(0,0,0,0.9);
        }

        h1 { max-width: 790px; margin-top: 20px; font-size: clamp(43px,7vw,86px); line-height: .96; }
        h2 { font-size: clamp(30px,4vw,52px); line-height: 1; }
        h3 { font-size: 25px; line-height: 1.12; }

        p {
            color: #ffffff; line-height: 1.75;
            text-shadow: 0 2px 10px rgba(0,0,0,0.8); font-size: 16px;
        }

        .lead { max-width: 670px; font-size: 18px; color: #ffffff; }

        .eyebrow {
            display: inline-flex; align-items: center; gap: 12px;
            color: var(--gold); text-transform: uppercase;
            letter-spacing: .22em; font-size: 12px; font-weight: 800;
        }

        .eyebrow:before {
            content: ""; width: 34px; height: 1px;
            background: currentColor; opacity: .68;
        }

        .hero {
            display: grid; grid-template-columns: .98fr 1.02fr;
            gap: 48px; align-items: center; padding: 72px 0 56px;
        }

        .glass-backplate {
            position: relative; padding: 22px;
            border-radius: 14px;
            border: 1px solid rgba(212,168,67,.25);
            background: rgba(5,5,5,.35);
            backdrop-filter: blur(14px);
            box-shadow: 0 18px 60px rgba(0,0,0,.45);
        }

        .button-row { display: flex; flex-wrap: wrap; gap: 14px; margin-top: 30px; }

        .button {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 10px; min-height: 48px; padding: 0 20px;
            background: rgba(212,168,67,.12);
            border-color: rgba(212,168,67,.44);
            color: var(--gold); text-transform: uppercase;
            letter-spacing: .13em; font-size: 12px; font-weight: 900; cursor: pointer;
        }

        .button.secondary {
            color: var(--text); background: rgba(255,255,255,.05);
            border-color: var(--line);
        }

        .section { padding: 58px 0; border-top: 1px solid rgba(255,255,255,.08); }

        .section-collection {
            padding: 40px 0;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .section-head {
            display: flex; align-items: end; justify-content: space-between;
            gap: 24px; margin-bottom: 28px;
        }

        .section-head p { max-width: 620px; margin: 10px 0 0; }

        .collection-header {
            text-align: center;
            padding: 20px 20px;
            margin-bottom: 24px;
            border-radius: 12px;
            background: rgba(255,255,255,.02);
            border: 1px solid rgba(255,255,255,.06);
        }

        .collection-header h2 {
            color: #ffffff;
            font-size: clamp(24px, 3vw, 36px);
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0,0,0,0.8);
        }

        .grid { display: grid; gap: 18px; }
        .grid.three { grid-template-columns: repeat(3, 1fr); }
        .grid.two { grid-template-columns: repeat(2, 1fr); }
        .grid.four { grid-template-columns: repeat(4, 1fr); }

        .split { display: grid; grid-template-columns: .92fr 1.08fr; gap: 30px; align-items: start; }

        .card {
            border: 1px solid var(--line); border-radius: 8px;
            background: rgba(0,0,0,.25); padding: 24px; min-width: 0;
        }

        .product-card { overflow: hidden; position: relative; }
        .product-card:hover {
            border-color: rgba(212,168,67,.38);
            background: rgba(255,255,255,.075);
        }

        .product-top-link { display: block; color: inherit; }

        .product-visual {
            position: relative; display: grid; place-items: center;
            min-height: 220px; padding: 16px; margin-bottom: 16px;
            border-radius: 24px; border: 1px solid rgba(255,255,255,.08);
            background: linear-gradient(145deg, rgba(255,255,255,.08), rgba(255,255,255,.03));
            box-shadow: inset 0 1px 0 rgba(255,255,255,.05), 0 18px 40px rgba(0,0,0,.24);
            overflow: hidden; perspective: 900px;
        }

        .product-visual img {
            width: 100%; max-height: 220px; object-fit: cover;
            object-position: center; border-radius: 18px;
            transform: rotateX(-8deg) rotateY(12deg) scale(1.02);
            transform-style: preserve-3d;
            box-shadow: 0 24px 45px rgba(0,0,0,.38);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .product-visual.large img { max-height: 400px; width: auto; max-width: 100%; object-fit: contain; }

        #product-frames-img {
            object-fit: contain !important; max-height: 400px !important;
            width: auto !important; max-width: 100% !important; height: auto !important;
        }

        .product-visual.small { min-height: 190px; }
        .product-visual.small img { max-height: 180px; }
        .product-visual.large { min-height: 320px; }

        .product-card:hover .product-visual img, .stage:hover .product-visual img {
            transform: rotateX(-4deg) rotateY(-10deg) scale(1.04);
            box-shadow: 0 30px 55px rgba(0,0,0,.46);
        }

        .price { color: var(--gold); font-weight: 900; letter-spacing: .06em; }

        .success {
            border-color: rgba(110,180,115,.45);
            background: rgba(70,120,75,.18); color: #d7f4d9;
        }

        .stage {
            min-height: 520px; display: grid; place-items: center;
            border: 1px solid var(--line); border-radius: 8px;
            background:
                linear-gradient(145deg, rgba(255,255,255,.08), rgba(255,255,255,.02)),
                radial-gradient(circle at 50% 85%, rgba(210,196,166,.12), transparent 36%),
                #0c0c0b;
            box-shadow: 0 38px 100px rgba(0,0,0,.38);
            perspective: 980px; position: relative;
        }

        .stage-label {
            position: absolute; left: 24px; top: 22px;
            color: var(--muted); font-size: 12px;
            text-transform: uppercase; letter-spacing: .16em;
        }

        .studio-grid { display: grid; grid-template-columns: 1.15fr .85fr; gap: 18px; }

        .studio-panel {
            min-height: 310px; display: grid; place-items: center;
            border: 1px solid var(--line); border-radius: 8px;
            background: rgba(255,255,255,.045);
            perspective: 980px; position: relative; overflow: hidden;
        }

        .studio-panel:after {
            content: attr(data-label); position: absolute;
            left: 18px; bottom: 16px; color: var(--muted);
            font-size: 12px; text-transform: uppercase; letter-spacing: .16em;
        }

        .muted { color: #ffffff; text-shadow: 0 2px 10px rgba(0,0,0,0.8); }

        .readable-text {
            color: #ffffff !important; font-weight: 500;
            text-shadow: 0 2px 12px rgba(0,0,0,0.9);
            font-size: 17px; line-height: 1.8;
        }

        details.faq-item { background: rgba(0,0,0,0.4); border-color: rgba(255,255,255,0.2); }

        details.faq-item summary {
            color: #ffffff; font-weight: 700; font-size: 17px;
            cursor: pointer; padding: 10px 0;
            text-shadow: 0 2px 10px rgba(0,0,0,0.8);
        }

        details.faq-item p { color: #ffffff; font-size: 16px; margin-top: 10px; line-height: 1.7; }

        .spec { background: rgba(0,0,0,0.4); color: #ffffff; border-color: rgba(255,255,255,0.15); }
        .detail-list li { color: #ffffff; font-size: 15px; }
        .card p { color: #ffffff; }
        .card h3 { color: #ffffff; }
        .nav a { color: #ffffff; }
        .site-header { background: rgba(5,5,5,0.70); }
        .glass-backplate p { color: #ffffff; }
        .button.secondary { color: #ffffff; }

        .specs { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin: 16px 0; }
        .spec { padding: 8px 12px; border: 1px solid rgba(255,255,255,.08); border-radius: 8px; }
        .spec span { display: block; font-size: 11px; opacity: .6; text-transform: uppercase; letter-spacing: .12em; margin-bottom: 2px; }
        .detail-list { padding-left: 18px; margin: 12px 0; }
        .detail-list li { margin: 6px 0; color: var(--muted); }

        .field {
            min-height: 44px; border-radius: 10px;
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(0,0,0,.25); color: #fffaf0;
            padding: 0 12px; width: 100%;
        }

        .like-btn {
            position: absolute; top: 12px; right: 12px; z-index: 5;
            width: 36px; height: 36px; border-radius: 50%;
            border: 1px solid rgba(255,255,255,.2);
            background: rgba(0,0,0,.4); display: grid; place-items: center;
            cursor: pointer; transition: all .2s; color: rgba(255,255,255,.6);
        }
        .like-btn:hover { border-color: rgba(212,168,67,.5); background: rgba(0,0,0,.6); }
        .like-btn.liked { color: #ff4d6a; border-color: rgba(255,77,106,.4); background: rgba(255,77,106,.1); }
        .like-btn svg { width: 18px; height: 18px; }

        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,.7); backdrop-filter: blur(8px);
            display: flex; align-items: center; justify-content: center;
            z-index: 100; opacity: 0; pointer-events: none; transition: opacity .3s ease;
        }
        .modal-overlay.open { opacity: 1; pointer-events: all; }

        .modal-box {
            width: min(480px, calc(100% - 32px));
            border: 1px solid rgba(212,168,67,.3);
            background: rgba(10,10,10,.95); border-radius: 16px; padding: 28px;
            box-shadow: 0 30px 80px rgba(0,0,0,.6);
            transform: scale(.95); transition: transform .3s ease;
        }
        .modal-overlay.open .modal-box { transform: scale(1); }

        .modal-title { font-family: Georgia, "Times New Roman", serif; font-size: 24px; color: var(--gold); margin-bottom: 8px; }
        .modal-actions { display: flex; gap: 12px; margin-top: 20px; }
        .modal-actions .button { flex: 1; }

        .cart-row { display: flex; gap: 16px; align-items: center; }
        .cart-total { margin-top: 14px; display: flex; justify-content: space-between; align-items: center; }
        .form { display: flex; flex-direction: column; gap: 12px; }

        .site-footer { border-top: 1px solid var(--line); padding: 24px 0; margin-top: 20px; }
        .footer-inner { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; font-size: 13px; opacity: .8; }
        .footer-links { display: flex; gap: 16px; flex-wrap: wrap; }
        .footer-links a { color: rgba(255,255,255,.7); transition: color .2s; }
        .footer-links a:hover { color: var(--gold); }
        .footer-brand { color: var(--gold); font-weight: 600; }

        .status-toast {
            position: fixed; top: 20px; right: 20px; z-index: 200;
            padding: 14px 20px; border-radius: 10px;
            background: rgba(70,120,75,.9); color: #d7f4d9;
            border: 1px solid rgba(110,180,115,.5);
            backdrop-filter: blur(10px);
            font-size: 14px; font-weight: 500;
            transform: translateX(120%); opacity: 0;
            transition: all .4s ease;
        }
        .status-toast.show { transform: translateX(0); opacity: 1; }

        @media (max-width: 980px) {
            .nav, .header-actions .desktop-only { display: none; }
            .menu-toggle { display: grid; }
            .mobile-nav.open { display: block; }
            .hero, .split, .grid.two, .grid.three, .grid.four, .studio-grid { grid-template-columns: 1fr; }
            .hero { padding-top: 44px; }
            .stage { min-height: 430px; }
            .section-head { display: block; }
        }

        @media (max-width: 560px) {
            .brand { letter-spacing: .1em; font-size: 14px; }
            .container { width: min(100% - 22px, 1180px); }
            .card { padding: 18px; }
            .button { width: 100%; }
            .specs { grid-template-columns: 1fr; }
            .footer-inner { flex-direction: column; text-align: center; }
        }
    </style>
</head>

<body>
    <div class="page-shell">
        @php
        $bgByPage = [
        'home' => 'images/sacs/top-model femme1.png',
        'collection' => 'images/sacs/image pour banniere ou background.jpeg',
        'product' => 'images/sacs/image pour banniere ou background.jpeg',
        'savoir-faire' => 'images/sacs/top-model homme 1.png',
        'histoire' => 'images/sacs/top-model homme 2.png',
        'panier' => 'images/sacs/top-model femme 2.png',
        'favoris' => 'images/sacs/couple.png',
        'faq' => 'images/sacs/image pour background faq.jpg',
        'contact' => 'images/sacs/top-model homme 1.png',
        'commande' => 'images/sacs/image pour background faq.jpg',
        ];
        $bg = $bgByPage[$page] ?? $bgByPage['home'];
        @endphp

        <div class="bg-layer" id="bg" style="background-image:url('{{ asset($bg) }}');"></div>
        <div class="bg-overlay"></div>
        <div class="bg-soft-light"></div>

        <!-- Toast notification -->
        @if (session('status'))
        <div class="status-toast show" id="status-toast">{{ session('status') }}</div>
        @endif

        <header class="site-header">
            <div class="container header-inner">
                <a class="brand" href="{{ route('home') }}" aria-label="Accueil {{ $brand }}">
                    <span class="brand-mark">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M6 8h12l-1 12H7L6 8Z" />
                            <path d="M9 8a3 3 0 0 1 6 0" />
                        </svg>
                    </span>
                    {{ $brand }}
                </a>

                <nav class="nav" aria-label="Navigation principale">
                    @foreach ($nav as $slug => $label)
                    <a class="{{ ($page === $slug || ($page === 'product' && $slug === 'collection')) ? 'active' : '' }}" href="{{ route($slug) }}">{{ $label }}</a>
                    @endforeach
                </nav>

                <div class="header-actions">
                    <a class="icon-link desktop-only" href="{{ route('admin.login') }}" aria-label="Admin">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 21c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                    </a>
                    <a class="icon-link desktop-only" href="{{ route('collection') }}" aria-label="Voir la collection">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7" />
                            <path d="m20 20-4-4" />
                        </svg>
                    </a>
                    <a class="icon-link desktop-only" href="{{ route('favoris') }}" aria-label="Favoris">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 21s-7-4.2-9-8.4C1.8 8.8 4.3 5.5 8 5.5c1.7 0 3.1.7 4 2 1-1.3 2.3-2 4-2 3.7 0 6.2 3.3 5 7.1C19 16.8 12 21 12 21Z" />
                        </svg>
                        @if (count($favorites) > 0)
                        <span class="fav-badge">{{ count($favorites) }}</span>
                        @endif
                    </a>
                    <a class="icon-link desktop-only" href="{{ route('panier') }}" aria-label="Consulter le panier">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M6 6h15l-2 9H8L6 6Z" />
                            <path d="M6 6 5 3H2" />
                            <circle cx="9" cy="20" r="1.5" />
                            <circle cx="18" cy="20" r="1.5" />
                        </svg>
                        @if ($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <button class="menu-toggle" id="mobile-menu-toggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="container mobile-nav" id="mobile-menu">
                @foreach ($nav as $slug => $label)
                <a href="{{ route($slug) }}">{{ $label }}</a>
                @endforeach
                <a href="{{ route('admin.login') }}">Admin</a>
                <a href="{{ route('favoris') }}">Favoris @if (count($favorites) > 0)({{ count($favorites) }})@endif</a>
                <a href="{{ route('panier') }}">Panier @if ($cartCount > 0)({{ $cartCount }})@endif</a>
            </div>
        </header>

        <main>
            @if ($page === 'home')
            <section class="container hero">
                <div class="glass-backplate">
                    <span class="eyebrow">Blac Joyaux</span>
                    <h1>L'élégance ivoirienne, en détail.</h1>
                    <p class="lead">Découvrez nos collections de sacs en cuir et vegan, imaginés et assemblés en Côte d'Ivoire avec passion et savoir-faire.</p>
                    <div class="button-row">
                        <a class="button" href="{{ route('collection') }}">Voir la collection</a>
                        <a class="button secondary" href="{{ route('panier') }}">Consulter le panier</a>
                    </div>
                </div>
                <div class="stage" aria-label="Blac Joyaux">
                    <span class="stage-label">Marque ivoirienne</span>
                    <div class="product-visual large" style="background:transparent;border:0;box-shadow:none;">
                        <img src="{{ asset('images/sacs/logo statuette dorée.jpeg') }}" alt="Blac Joyaux" loading="eager" />
                    </div>
                </div>
            </section>

            @php
            $homeBureau = array_values(array_filter($bags, fn($b) => ($b['collection'] ?? '') === 'bureau'))[0] ?? null;
            $homeDo = array_values(array_filter($bags, fn($b) => ($b['collection'] ?? '') === 'do'))[0] ?? null;
            $homeVegan = array_values(array_filter($bags, fn($b) => ($b['collection'] ?? '') === 'vegan'))[0] ?? null;
            $homeProducts = array_filter([$homeBureau, $homeDo, $homeVegan]);
            @endphp

            <section class="container section-collection">
                <div class="collection-header">
                    <h2>Nos Collections</h2>
                </div>
                <div class="grid three">
                    @foreach ($homeProducts as $bag)
                    <article class="card product-card">
                        <button class="like-btn {{ in_array($bag['slug'], $favorites) ? 'liked' : '' }}" data-slug="{{ $bag['slug'] }}" onclick="toggleFav(this)" aria-label="Ajouter aux favoris">
                            <svg viewBox="0 0 24 24" fill="{{ in_array($bag['slug'], $favorites) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2">
                                <path d="M12 21s-7-4.2-9-8.4C1.8 8.8 4.3 5.5 8 5.5c1.7 0 3.1.7 4 2 1-1.3 2.3-2 4-2 3.7 0 6.2 3.3 5 7.1C19 16.8 12 21 12 21Z" />
                            </svg>
                        </button>
                        <a class="product-top-link" href="{{ route('sacs.show', $bag['slug']) }}">
                            <div class="product-visual small">
                                <img src="{{ asset($bag['image']) }}" alt="{{ $bag['name'] }}" loading="lazy" />
                            </div>
                            <h3>{{ $bag['name'] }}</h3>
                            <p>{{ $bag['copy'] }}</p>
                            <p class="price">{{ $bag['price_label'] }}</p>
                        </a>
                        <div class="button-row">
                            <a class="button secondary" href="{{ route('sacs.show', $bag['slug']) }}">Détails</a>
                            <form action="{{ route('cart.add', $bag['slug']) }}" method="post">
                                @csrf
                                <button class="button" type="submit">Ajouter</button>
                            </form>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>

            <!-- Section Savoir-faire -->
            <section class="container section-collection" style="text-align:center;">
                <div class="card" style="max-width:700px;margin:0 auto;">
                    <h2 style="color:var(--gold);margin-bottom:12px;">Notre Savoir-faire</h2>
                    <p class="readable-text">Chaque sac Blac Joyaux est le fruit d'un savoir-faire artisanal ivoirien. Du choix des matières à la finition, chaque étape est réalisée avec passion et précision pour vous offrir un accessoire unique et durable.</p>
                    <div class="button-row" style="justify-content:center;">
                        <a class="button" href="{{ route('savoir-faire') }}">Découvrir notre savoir-faire</a>
                    </div>
                </div>
            </section>

            @elseif ($page === 'collection')
            <section class="container-wide section">
                <div class="section-head">
                    <div>
                        <span class="eyebrow">Collection</span>
                        <h1>Toutes nos collections.</h1>
                        <p>Des sacs élégants pour chaque style, conçus en Côte d'Ivoire.</p>
                    </div>
                </div>

                <div class="collection-header"><h2>Sac de Bureau Unisex Kora Duffel</h2></div>
                <div class="grid three">
                    @php $bureauBags = array_filter($bags, fn($b) => ($b['collection'] ?? '') === 'bureau'); @endphp
                    @foreach ($bureauBags as $bag)
                    <article class="card product-card">
                        <button class="like-btn {{ in_array($bag['slug'], $favorites) ? 'liked' : '' }}" data-slug="{{ $bag['slug'] }}" onclick="toggleFav(this)"><svg viewBox="0 0 24 24" fill="{{ in_array($bag['slug'], $favorites) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-4.2-9-8.4C1.8 8.8 4.3 5.5 8 5.5c1.7 0 3.1.7 4 2 1-1.3 2.3-2 4-2 3.7 0 6.2 3.3 5 7.1C19 16.8 12 21 12 21Z"/></svg></button>
                        <a class="product-top-link" href="{{ route('sacs.show', $bag['slug']) }}">
                            <div class="product-visual small"><img src="{{ asset($bag['image']) }}" alt="{{ $bag['name'] }}" loading="lazy" /></div>
                            <h3>{{ $bag['name'] }}</h3>
                            <p>{{ $bag['copy'] }}</p>
                            <p class="price">{{ $bag['price_label'] }}</p>
                        </a>
                        <div class="button-row">
                            <a class="button secondary" href="{{ route('sacs.show', $bag['slug']) }}">Détails</a>
                            <form action="{{ route('cart.add', $bag['slug']) }}" method="post">@csrf<button class="button" type="submit">Ajouter</button></form>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div class="collection-header" style="margin-top:40px;"><h2>Collection Sac DO</h2></div>
                <div class="grid three">
                    @php $doBags = array_filter($bags, fn($b) => ($b['collection'] ?? '') === 'do'); @endphp
                    @foreach ($doBags as $bag)
                    <article class="card product-card">
                        <button class="like-btn {{ in_array($bag['slug'], $favorites) ? 'liked' : '' }}" data-slug="{{ $bag['slug'] }}" onclick="toggleFav(this)"><svg viewBox="0 0 24 24" fill="{{ in_array($bag['slug'], $favorites) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-4.2-9-8.4C1.8 8.8 4.3 5.5 8 5.5c1.7 0 3.1.7 4 2 1-1.3 2.3-2 4-2 3.7 0 6.2 3.3 5 7.1C19 16.8 12 21 12 21Z"/></svg></button>
                        <a class="product-top-link" href="{{ route('sacs.show', $bag['slug']) }}">
                            <div class="product-visual small"><img src="{{ asset($bag['image']) }}" alt="{{ $bag['name'] }}" loading="lazy" /></div>
                            <h3>{{ $bag['name'] }}</h3>
                            <p>{{ $bag['copy'] }}</p>
                            <p class="price">{{ $bag['price_label'] }}</p>
                        </a>
                        <div class="button-row">
                            <a class="button secondary" href="{{ route('sacs.show', $bag['slug']) }}">Détails</a>
                            <form action="{{ route('cart.add', $bag['slug']) }}" method="post">@csrf<button class="button" type="submit">Ajouter</button></form>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div class="collection-header" style="margin-top:40px;"><h2>Collection Sac Vegan</h2></div>
                <div class="grid three">
                    @php $veganBags = array_filter($bags, fn($b) => ($b['collection'] ?? '') === 'vegan'); @endphp
                    @foreach ($veganBags as $bag)
                    <article class="card product-card">
                        <button class="like-btn {{ in_array($bag['slug'], $favorites) ? 'liked' : '' }}" data-slug="{{ $bag['slug'] }}" onclick="toggleFav(this)"><svg viewBox="0 0 24 24" fill="{{ in_array($bag['slug'], $favorites) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-4.2-9-8.4C1.8 8.8 4.3 5.5 8 5.5c1.7 0 3.1.7 4 2 1-1.3 2.3-2 4-2 3.7 0 6.2 3.3 5 7.1C19 16.8 12 21 12 21Z"/></svg></button>
                        <a class="product-top-link" href="{{ route('sacs.show', $bag['slug']) }}">
                            <div class="product-visual small"><img src="{{ asset($bag['image']) }}" alt="{{ $bag['name'] }}" loading="lazy" /></div>
                            <h3>{{ $bag['name'] }}</h3>
                            <p>{{ $bag['copy'] }}</p>
                            <p class="price">{{ $bag['price_label'] }}</p>
                        </a>
                        <div class="button-row">
                            <a class="button secondary" href="{{ route('sacs.show', $bag['slug']) }}">Détails</a>
                            <form action="{{ route('cart.add', $bag['slug']) }}" method="post">@csrf<button class="button" type="submit">Ajouter</button></form>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div class="collection-header" style="margin-top:40px;"><h2>Trousses pour Hommes</h2></div>
                <div class="grid three">
                    @php $trousseBags = array_filter($bags, fn($b) => ($b['collection'] ?? '') === 'trousse'); @endphp
                    @foreach ($trousseBags as $bag)
                    <article class="card product-card">
                        <button class="like-btn {{ in_array($bag['slug'], $favorites) ? 'liked' : '' }}" data-slug="{{ $bag['slug'] }}" onclick="toggleFav(this)"><svg viewBox="0 0 24 24" fill="{{ in_array($bag['slug'], $favorites) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-4.2-9-8.4C1.8 8.8 4.3 5.5 8 5.5c1.7 0 3.1.7 4 2 1-1.3 2.3-2 4-2 3.7 0 6.2 3.3 5 7.1C19 16.8 12 21 12 21Z"/></svg></button>
                        <a class="product-top-link" href="{{ route('sacs.show', $bag['slug']) }}">
                            <div class="product-visual small"><img src="{{ asset($bag['image']) }}" alt="{{ $bag['name'] }}" loading="lazy" /></div>
                            <h3>{{ $bag['name'] }}</h3>
                            <p>{{ $bag['copy'] }}</p>
                            <p class="price">{{ $bag['price_label'] }}</p>
                        </a>
                        <div class="button-row">
                            <a class="button secondary" href="{{ route('sacs.show', $bag['slug']) }}">Détails</a>
                            <form action="{{ route('cart.add', $bag['slug']) }}" method="post">@csrf<button class="button" type="submit">Ajouter</button></form>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>

            @elseif ($page === 'product')
            <section class="container section split">
                @php $frames = $product['frames'] ?? []; @endphp
                <div class="stage" aria-label="Vue produit {{ $product['name'] }}">
                    <span class="stage-label">{{ $product['name'] }}</span>
                    <div class="product-visual large">
                        @if (is_array($frames) && !empty($frames))
                        <img id="product-frames-img" src="{{ asset($frames[0]) }}" alt="{{ $product['name'] }}" loading="eager" draggable="false" data-frames='@json($frames)'>
                        @else
                        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" loading="eager" />
                        @endif
                    </div>
                    @if (is_array($frames) && count($frames) > 1)
                    <div class="button-row" style="margin-top:16px;">
                        <button class="button secondary" type="button" id="frame-prev">←</button>
                        <button class="button secondary" type="button" id="frame-next">→</button>
                    </div>
                    <p class="muted" style="margin-top:10px;font-size:13px;">Faites glisser ou utilisez les flèches.</p>
                    @endif
                </div>
                <div>
                    <span class="eyebrow">{{ $product['collection_label'] ?? 'Fiche produit' }}</span>
                    <h1>{{ $product['name'] }}</h1>
                    <p class="lead">{{ $product['copy'] }}</p>
                    <p class="price">{{ $product['price_label'] }}</p>
                    <div class="specs">
                        <div class="spec"><span>Couleur</span>{{ $product['color'] }}</div>
                        <div class="spec"><span>Dimensions</span>{{ $product['dimensions'] }}</div>
                        <div class="spec"><span>Matière</span>{{ $product['material'] }}</div>
                        <div class="spec"><span>Origine</span>Conçu et assemblé en Côte d'Ivoire</div>
                    </div>
                    <ul class="detail-list">
                        @foreach ($product['features'] as $feature)
                        <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    <form class="button-row" action="{{ route('cart.add', $product['slug']) }}" method="post">
                        @csrf
                        <input class="field" style="max-width:110px;" type="number" name="quantity" value="1" min="1" max="9" aria-label="Quantité">
                        <button class="button" type="submit">Ajouter au panier</button>
                        <a class="button secondary" href="{{ route('panier') }}">Voir panier</a>
                    </form>
                </div>
            </section>
            <section class="container section">
                <div class="section-head">
                    <div><span class="eyebrow">Vues studio</span><h2>Face, profil et ouverture</h2></div>
                </div>
                <div class="studio-grid">
                    <div class="studio-panel" data-label="Front view"><div class="product-visual"><img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" loading="lazy" /></div></div>
                    <div class="grid">
                        <div class="studio-panel" data-label="Side profile"><div class="product-visual small"><img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" loading="lazy" /></div></div>
                        <div class="studio-panel" data-label="Top open view"><div class="product-visual small"><img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" loading="lazy" /></div></div>
                    </div>
                </div>
            </section>

            @elseif ($page === 'panier')
            <section class="container section">
                <div class="section-head">
                    <div><span class="eyebrow">Panier</span><h1>Votre panier {{ $brand }}</h1><p>Consultez les articles ajoutés avant de confirmer votre commande.</p></div>
                </div>
                @if ($cartItems->isEmpty())
                <div class="card"><h3>Votre panier est vide.</h3><p>Choisissez un modèle dans la collection pour l'ajouter ici.</p><a class="button" href="{{ route('collection') }}">Voir la collection</a></div>
                @else
                <div class="grid">
                    @foreach ($cartItems as $item)
                    <article class="card cart-row">
                        <a href="{{ route('sacs.show', $item['bag']['slug']) }}"><div class="product-visual small" style="width:130px;min-height:110px;margin:0;"><img src="{{ asset($item['bag']['image']) }}" alt="{{ $item['bag']['name'] }}" loading="lazy" /></div></a>
                        <div><h3>{{ $item['bag']['name'] }}</h3><p>Qté: {{ $item['quantity'] }} · {{ $item['bag']['price_label'] }} / pièce</p><p class="price">Sous-total: {{ number_format($item['bag']['price'] * $item['quantity'], 0, ',', ' ') }} FCFA</p></div>
                        <form action="{{ route('cart.remove', $item['bag']['slug']) }}" method="post">@csrf<button class="button secondary" type="submit">Retirer</button></form>
                    </article>
                    @endforeach
                </div>
                <div class="card cart-total"><h3>Total</h3><p class="price" style="font-size:24px;">{{ number_format($cartTotal, 0, ',', ' ') }} FCFA</p></div>
                <div class="button-row">
                    <button class="button" type="button" id="checkout-confirm-btn">Finaliser la commande</button>
                    <a class="button secondary" href="{{ route('collection') }}">Continuer mes achats</a>
                </div>
                @endif
            </section>

            @elseif ($page === 'savoir-faire')
            <section class="container section split">
                <div>
                    <span class="eyebrow">Savoir-faire</span>
                    <h1>Une fabrication attentive, du patron au dernier point.</h1>
                    <p class="lead readable-text">Nos sacs sont dessinés pour garder une belle tenue au quotidien: choix des matières, renforts internes, poignées confortables, zip robuste et contrôle minutieux avant livraison.</p>
                </div>
                <div class="grid">
                    <article class="card"><h3>Matières choisies</h3><p class="readable-text">Cuirs, textiles et doublures sont sélectionnés pour leur résistance, leur toucher et leur rendu visuel.</p></article>
                    <article class="card"><h3>Finitions nettes</h3><p class="readable-text">Les coutures, bords, fermoirs, tirettes et détails dorés sont vérifiés pour offrir une finition propre et durable.</p></article>
                    <article class="card"><h3>Usage réel</h3><p class="readable-text">Le Kora Duffel garde un format pratique: ordinateur fin, carnet, portefeuille, lunettes et essentiels de journée.</p></article>
                </div>
            </section>

            @elseif ($page === 'histoire')
            <section class="container section split">
                <div>
                    <span class="eyebrow">L'histoire</span>
                    <h1>Blac Joyaux, une maison ivoirienne.</h1>
                    <p class="lead readable-text">" Blac Joyaux, c'est … Un savoir créatif féminin de la région centrale de la Côte d'Ivoire, en Afrique. Son but est de participer à la valorisation du savoir créatif en Côte d'Ivoire et au-delà en proposant des sacs à main made in Côte d'Ivoire, accessibles et qui répondent aux besoins du marché actuel. Au quotidien, adoptez Blac Joyaux et donnez une fière allure à votre style. "</p>
                    <div style="margin-top:24px;">
                        <span class="eyebrow">Qui sommes-nous ?</span>
                        <p class="readable-text" style="margin-top:10px;">Nous sommes Blac Joyaux, une marque ivoirienne de maroquinerie qui incarne une histoire, celle de la fécondité, de l'héritage et de la résilience des traditions africaines. Nous croyons qu'il est possible de combiner luxe, authenticité et durabilité tout en célébrant notre riche culture.</p>
                    </div>
                </div>
                <div class="stage" style="min-height:450px;">
                    <span class="stage-label">Notre histoire</span>
                    <div style="padding:20px;display:grid;place-items:center;width:100%;height:100%;">
                        <img src="{{ asset('images/sacs/top-model femme1.png') }}" alt="Blac Joyaux" style="max-width:100%;max-height:400px;object-fit:contain;border-radius:8px;" />
                    </div>
                </div>
            </section>

            @elseif ($page === 'faq')
            <section class="container section">
                <div class="section-head">
                    <div><span class="eyebrow">FAQ</span><h1>Questions fréquentes</h1></div>
                </div>
                <div class="grid">
                    @foreach ($faqs as $item)
                    <details class="card faq-item" @if ($loop->first) open @endif>
                        <summary>{{ $item['q'] }}</summary>
                        <p>{{ $item['a'] }}</p>
                    </details>
                    @endforeach
                </div>
            </section>

            @elseif ($page === 'contact' || $page === 'commande')
            <section class="container section split">
                <div>
                    <span class="eyebrow">{{ $page === 'commande' ? 'Commande' : 'Contact' }}</span>
                    <h1>{{ $page === 'commande' ? 'Finaliser votre commande.' : 'Parlons de votre prochain sac.' }}</h1>
                    @if ($page === 'contact')
                    <div class="card" style="margin-bottom:16px;">
                        <h3>Showroom Blac Joyaux</h3>
                        <p style="margin-top:8px;line-height:1.6;">Côte d'Ivoire - Commune de Cocody<br>Rond-point de la Riviera Palmeraie</p>
                        <p style="margin-top:8px;line-height:1.6;"><strong style="color:var(--gold);">Horaire d'ouverture</strong><br>Lundi au samedi, de 09h00 à 18h00</p>
                        <p style="margin-top:8px;line-height:1.6;"><strong style="color:var(--gold);">Contact / SAV</strong><br><a href="tel:+2250708771557">+225 07 08 77 15 57</a><br><a href="tel:+2250545452215">+225 05 45 45 22 15</a></p>
                    </div>
                    @endif
                    @if ($cartCount > 0)
                    <div class="card"><h3>Panier actuel</h3><p>{{ $cartCount }} article(s), total {{ number_format($cartTotal, 0, ',', ' ') }} FCFA.</p><a class="button secondary" href="{{ route('panier') }}">Consulter le panier</a></div>
                    @endif
                    <div class="grid two">
                        <article class="card"><h3>WhatsApp</h3><p><a href="https://wa.me/2250708771557">+225 07 08 77 15 57</a></p></article>
                        <article class="card"><h3>E-mail</h3><p><a href="mailto:contact@blac-joyaux.com">contact@blac-joyaux.com</a></p></article>
                    </div>
                </div>
                @if ($page === 'commande')
                <form class="card" method="post" action="{{ route('commande.complete') }}">@csrf<h3>Finaliser</h3><p style="margin-top:8px;">En validant, votre commande est confirmée.</p><button class="button" type="submit">Confirmer la commande</button></form>
                @else
                <form class="card form" action="{{ route('contact') }}" method="get">
                    <input class="field" name="nom" placeholder="Votre nom">
                    <input class="field" name="email" type="email" placeholder="Votre e-mail">
                    <input class="field" name="modele" placeholder="Modèle souhaité">
                    <textarea class="field" name="message" placeholder="Votre message"></textarea>
                    <button class="button" type="submit">Envoyer la demande</button>
                </form>
                @endif
            </section>

            @elseif ($page === 'favoris')
            <section class="container section">
                <span class="eyebrow">Favoris</span>
                <h1>Vos articles favoris.</h1>
                @if (empty($favorites))
                <p class="lead">Vous n'avez pas encore ajouté d'articles à vos favoris. Cliquez sur le cœur ❤️ sur un produit pour l'ajouter ici.</p>
                <div class="button-row"><a class="button" href="{{ route('collection') }}">Découvrir la collection</a></div>
                @else
                <p class="lead">{{ count($favorites) }} article(s) dans vos favoris.</p>
                <div class="grid three">
                    @foreach ($favorites as $slug)
                    @php $bag = $bags[$slug] ?? null; @endphp
                    @if ($bag)
                    <article class="card product-card">
                        <button class="like-btn liked" data-slug="{{ $bag['slug'] }}" onclick="toggleFav(this)"><svg viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-4.2-9-8.4C1.8 8.8 4.3 5.5 8 5.5c1.7 0 3.1.7 4 2 1-1.3 2.3-2 4-2 3.7 0 6.2 3.3 5 7.1C19 16.8 12 21 12 21Z"/></svg></button>
                        <a class="product-top-link" href="{{ route('sacs.show', $bag['slug']) }}">
                            <div class="product-visual small"><img src="{{ asset($bag['image']) }}" alt="{{ $bag['name'] }}" loading="lazy" /></div>
                            <h3>{{ $bag['name'] }}</h3>
                            <p>{{ $bag['copy'] }}</p>
                            <p class="price">{{ $bag['price_label'] }}</p>
                        </a>
                        <div class="button-row">
                            <a class="button secondary" href="{{ route('sacs.show', $bag['slug']) }}">Détails</a>
                            <form action="{{ route('cart.add', $bag['slug']) }}" method="post">@csrf<button class="button" type="submit">Ajouter</button></form>
                        </div>
                    </article>
                    @endif
                    @endforeach
                </div>
                @endif
            </section>
            @else
            <section class="container section">
                <span class="eyebrow">{{ $pages[$page]['title'] }}</span>
                <h1>{{ $pages[$page]['title'] }} {{ $brand }}</h1>
                <p class="lead">Informations administratives de {{ $brand }}. Pour toute question, contactez-nous directement.</p>
                <a class="button" href="{{ route('contact') }}">Contact</a>
            </section>
            @endif
        </main>

        <footer class="site-footer">
            <div class="container footer-inner">
                <span>© {{ date('Y') }} <span class="footer-brand">{{ $brand }}</span>. Maroquinerie ivoirienne.</span>
                <div class="footer-links">
                    <a href="{{ route('mentions-legales') }}">Mentions légales</a>
                    <a href="{{ route('confidentialite') }}">Confidentialité</a>
                    <a href="{{ route('faq') }}">FAQ</a>
                    <a href="{{ route('panier') }}">Panier @if ($cartCount > 0)({{ $cartCount }})@endif</a>
                </div>
            </div>
            <div class="container" style="text-align:center;padding-top:12px;border-top:1px solid rgba(255,255,255,.06);margin-top:12px;font-size:13px;opacity:.7;">
                by <strong style="color:#d4a843;">BLACOM</strong>
            </div>
        </footer>
    </div>

    <!-- Modal de confirmation -->
    <div class="modal-overlay" id="checkout-modal">
        <div class="modal-box">
            <div class="modal-title">Confirmer votre commande</div>
            <p style="margin:12px 0;color:rgba(255,255,255,0.85);">Vous êtes sur le point de finaliser votre commande.</p>
            <div style="margin:12px 0;padding:12px;border:1px solid rgba(255,255,255,.08);border-radius:8px;">
                <div style="display:flex;justify-content:space-between;font-size:14px;opacity:.8;"><span>Articles:</span><span>{{ $cartCount }}</span></div>
                <div style="display:flex;justify-content:space-between;font-size:18px;font-weight:700;color:var(--gold);margin-top:8px;"><span>Total:</span><span>{{ number_format($cartTotal, 0, ',', ' ') }} FCFA</span></div>
            </div>
            <p style="font-size:13px;opacity:.7;">En confirmant, vous acceptez les conditions générales de vente.</p>
            <div class="modal-actions">
                <button class="button secondary" type="button" id="modal-cancel">Annuler</button>
                <form method="post" action="{{ route('commande.complete') }}" style="flex:1;">@csrf<button class="button" type="submit" style="width:100%;">Confirmer la commande</button></form>
            </div>
        </div>
    </div>

    <script>
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu');
        if (toggle && menu) {
            toggle.addEventListener('click', () => {
                const open = menu.classList.toggle('open');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        }

        // Parallax
        (function() {
            const bg = document.getElementById('bg');
            if (!bg) return;
            let raf = null;
            const onScroll = () => {
                if (raf) return;
                raf = requestAnimationFrame(() => { raf = null; const y = window.scrollY || 0; bg.style.transform = `translate3d(0, ${y * 0.07}px, 0)`; });
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        })();

        // Viewer frames
        (function() {
            const img = document.getElementById('product-frames-img');
            if (!img) return;
            let frames = [];
            try { frames = JSON.parse(img.getAttribute('data-frames') || '[]'); } catch(e) { frames = []; }
            if (!frames.length) return;
            let idx = 0;
            const resolve = (path) => String(path).startsWith('http') ? path : new URL(path, window.location.origin).toString();
            const setFrame = (newIdx) => { idx = (newIdx + frames.length) % frames.length; img.src = resolve(frames[idx]); };
            const prev = document.getElementById('frame-prev');
            const next = document.getElementById('frame-next');
            if (prev) prev.addEventListener('click', () => setFrame(idx - 1));
            if (next) next.addEventListener('click', () => setFrame(idx + 1));
            let startX = null;
            img.addEventListener('pointerdown', (e) => { startX = e.clientX; img.setPointerCapture(e.pointerId); });
            img.addEventListener('pointerup', (e) => {
                if (startX === null) return;
                const dx = e.clientX - startX; startX = null;
                if (Math.abs(dx) < 25) return;
                if (dx > 0) setFrame(idx - 1); else setFrame(idx + 1);
            });
        })();

        // Favoris toggle
        function toggleFav(btn) {
            const slug = btn.getAttribute('data-slug');
            fetch('/favoris/toggle/' + slug, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(r => r.json())
                .then(data => {
                    if (data.liked) { btn.classList.add('liked'); btn.querySelector('svg').setAttribute('fill', 'currentColor'); }
                    else { btn.classList.remove('liked'); btn.querySelector('svg').setAttribute('fill', 'none'); }
                    const badge = document.querySelector('.fav-badge');
                    if (badge) { if (data.count > 0) badge.textContent = data.count; else badge.remove(); }
                    else if (data.count > 0) {
                        const favLink = document.querySelector('a[href*="favoris"]');
                        if (favLink) { const nb = document.createElement('span'); nb.className = 'fav-badge'; nb.textContent = data.count; favLink.appendChild(nb); }
                    }
                });
        }

        // Modal
        (function() {
            const modal = document.getElementById('checkout-modal');
            const confirmBtn = document.getElementById('checkout-confirm-btn');
            const cancelBtn = document.getElementById('modal-cancel');
            if (!modal || !confirmBtn) return;
            confirmBtn.addEventListener('click', () => modal.classList.add('open'));
            if (cancelBtn) cancelBtn.addEventListener('click', () => modal.classList.remove('open'));
            modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('open'); });
        })();

        // Auto-dismiss toast after 3 seconds
        (function() {
            const toast = document.getElementById('status-toast');
            if (toast) {
                setTimeout(() => { toast.classList.remove('show'); }, 3000);
            }
        })();
    </script>
</body>

</html>