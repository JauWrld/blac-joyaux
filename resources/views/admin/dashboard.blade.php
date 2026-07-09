<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Tableau de bord</title>
    <style>
        body {
            font-family: Inter, system-ui, Segoe UI, Arial;
            background: #0b0a09;
            color: #ffffff;
            margin: 0;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: url('../images/sacs/couple.png') center/cover no-repeat;
            opacity: .15;
            filter: blur(2px);
            z-index: -1;
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(5,5,5,0.85);
            z-index: -1;
        }

        .wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 22px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        a {
            color: #c6a75e;
            text-decoration: none;
            font-weight: 800;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-top: 18px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-top: 18px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-top: 18px;
        }

        @media(max-width:900px) {
            .grid, .grid-2, .grid-3 {
                grid-template-columns: 1fr;
            }
        }

        .card {
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .05);
            border-radius: 12px;
            padding: 16px;
        }

        .k {
            opacity: .7;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        .v {
            font-size: 28px;
            font-weight: 900;
            margin-top: 6px;
            color: #fffaf0;
        }

        .nav {
            margin-top: 16px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .nav a {
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .05);
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 13px;
        }

        .nav a.active {
            border-color: rgba(198, 167, 94, .44);
            background: rgba(198, 167, 94, .12);
            color: #c6a75e;
        }

        .chart-container {
            position: relative;
            height: 200px;
            margin-top: 12px;
        }

        .chart-bars {
            display: flex;
            align-items: end;
            gap: 6px;
            height: 180px;
            padding: 0 4px;
        }

        .chart-bar-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            height: 100%;
            justify-content: end;
        }

        .chart-bar {
            width: 100%;
            max-width: 40px;
            border-radius: 4px 4px 0 0;
            min-height: 2px;
            transition: height 0.3s;
        }

        .chart-bar.visits {
            background: rgba(198, 167, 94, .7);
        }

        .chart-bar.orders {
            background: rgba(100, 200, 150, .7);
        }

        .chart-label {
            font-size: 10px;
            opacity: .6;
            text-align: center;
        }

        .chart-legend {
            display: flex;
            gap: 16px;
            margin-top: 8px;
            font-size: 12px;
            opacity: .8;
        }

        .chart-legend span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .chart-legend .dot {
            width: 10px;
            height: 10px;
            border-radius: 2px;
            display: inline-block;
        }

        .dot.gold {
            background: rgba(198, 167, 94, .7);
        }
        .dot.green {
            background: rgba(100, 200, 150, .7);
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-badge.pending {
            background: rgba(255, 200, 50, .2);
            color: #ffd866;
            border: 1px solid rgba(255, 200, 50, .3);
        }

        .status-badge.paid {
            background: rgba(50, 200, 100, .2);
            color: #7ddfa0;
            border: 1px solid rgba(50, 200, 100, .3);
        }

        .status-badge.finalized {
            background: rgba(50, 150, 255, .2);
            color: #7db8ff;
            border: 1px solid rgba(50, 150, 255, .3);
        }

        .status-badge.delivered {
            background: rgba(150, 100, 255, .2);
            color: #c4a8ff;
            border: 1px solid rgba(150, 100, 255, .3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border-top: 1px solid rgba(255, 255, 255, .10);
            padding: 10px 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            opacity: .75;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        td {
            opacity: .95;
            font-size: 13px;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: 10px;
        }

        .status-item {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, .08);
        }

        .status-item .count {
            font-size: 22px;
            font-weight: 900;
        }

        .status-item .label {
            font-size: 11px;
            opacity: .7;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: 4px;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="top">
            <div>
                <div style="font-size:26px;font-weight:900;color:#c6a75e;">Blac-Joyaux</div>
                <div style="opacity:.75">Tableau de bord administrateur</div>
            </div>
            <div>
                <form method="post" action="{{ route('admin.logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" style="background:none;border:0;color:#c6a75e;font-weight:800;cursor:pointer">Déconnexion</button>
                </form>
            </div>
        </div>

        <div class="nav">
            <a class="active" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.stats') }}">Statistiques</a>
            <a href="{{ route('admin.orders') }}">Commandes</a>
        </div>

        <!-- KPIs principaux -->
        <div class="grid">
            <div class="card">
                <div class="k">Visites totales</div>
                <div class="v">{{ $visitsTotal }}</div>
                <div style="font-size:12px;opacity:.6;margin-top:4px;">+{{ $visitsLast7 }} cette semaine</div>
            </div>
            <div class="card">
                <div class="k">Commandes</div>
                <div class="v">{{ $ordersTotal }}</div>
                <div style="font-size:12px;opacity:.6;margin-top:4px;">+{{ $ordersLast7 }} cette semaine</div>
            </div>
            <div class="card">
                <div class="k">Chiffre d'affaires</div>
                <div class="v">{{ number_format($revenueTotal, 0, ',', ' ') }} FCFA</div>
                <div style="font-size:12px;opacity:.6;margin-top:4px;">+{{ number_format($revenueLast7, 0, ',', ' ') }} cette semaine</div>
            </div>
            <div class="card">
                <div class="k">Commandes en attente</div>
                <div class="v">{{ $pendingOrders }}</div>
                <div style="font-size:12px;opacity:.6;margin-top:4px;">{{ $finalizedOrders }} finalisées · {{ $deliveredOrders }} livrées</div>
            </div>
        </div>

        <!-- Graphique -->
        <div class="grid-2">
            <div class="card">
                <div class="k">Activité (7 derniers jours)</div>
                <div class="chart-container">
                    <div class="chart-bars">
                        @php $maxVal = max(max($chartVisits), max($chartOrders), 1); @endphp
                        @foreach ($chartDays as $i => $day)
                        <div class="chart-bar-group">
                            <div class="chart-bar visits" style="height: {{ ($chartVisits[$i] / $maxVal) * 160 + 2 }}px;" title="{{ $chartVisits[$i] }} visites"></div>
                            <div class="chart-bar orders" style="height: {{ ($chartOrders[$i] / $maxVal) * 160 + 2 }}px;" title="{{ $chartOrders[$i] }} commandes"></div>
                            <div class="chart-label">{{ $day }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="chart-legend">
                    <span><span class="dot gold"></span> Visites</span>
                    <span><span class="dot green"></span> Commandes</span>
                </div>
            </div>

            <div class="card">
                <div class="k">Statut des commandes</div>
                <div class="status-grid">
                    <div class="status-item">
                        <div class="count" style="color:#ffd866;">{{ $pendingOrders }}</div>
                        <div class="label">En attente</div>
                    </div>
                    <div class="status-item">
                        <div class="count" style="color:#7ddfa0;">{{ $paidOrders }}</div>
                        <div class="label">Payées</div>
                    </div>
                    <div class="status-item">
                        <div class="count" style="color:#7db8ff;">{{ $finalizedOrders }}</div>
                        <div class="label">Finalisées</div>
                    </div>
                    <div class="status-item">
                        <div class="count" style="color:#c4a8ff;">{{ $deliveredOrders }}</div>
                        <div class="label">Livrées</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes récentes -->
        <div class="card" style="margin-top:18px;">
            <div class="k" style="font-size:14px;font-weight:700;">Commandes récentes</div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Articles</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $o)
                    <tr>
                        <td>#{{ $o->id }}</td>
                        <td>{{ $o->created_at?->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format((int)$o->total_fcfa, 0, ',', ' ') }} FCFA</td>
                        <td>
                            <span class="status-badge {{ $o->status }}">{{ $o->status }}</span>
                        </td>
                        <td>
                            @php $items = is_array($o->items) ? $o->items : []; @endphp
                            @foreach ($items as $item)
                            <div style="font-size:12px;">{{ $item['name'] ?? 'Article' }} × {{ $item['quantity'] ?? 1 }}</div>
                            @endforeach
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="opacity:.75;">Aucune commande récente</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div style="margin-top:12px;">
                <a class="button" href="{{ route('admin.orders') }}" style="display:inline-block;border:1px solid rgba(198,167,94,.44);background:rgba(198,167,94,.12);padding:8px 16px;border-radius:999px;font-size:13px;">Voir toutes les commandes →</a>
            </div>
        </div>

        <!-- Top routes -->
        <div class="grid-3" style="margin-top:18px;">
            <div class="card">
                <div class="k">Pages les plus visitées</div>
                <ul style="padding-left:18px;margin:10px 0 0;">
                    @foreach($topRoutes as $r)
                    <li style="margin:6px 0;opacity:.9;font-size:13px;">{{ $r->route_name ?? 'unknown' }} — {{ $r->c }} visites</li>
                    @endforeach
                </ul>
            </div>
            <div class="card">
                <div class="k">Informations</div>
                <div style="margin-top:10px;font-size:13px;opacity:.8;line-height:1.6;">
                    <div>Site réalisé par <strong style="color:#c6a75e;">Novacom</strong></div>
                    <div style="margin-top:8px;">Blac-Joyaux - Sacs conçus en Côte d'Ivoire</div>
                </div>
            </div>
            <div class="card">
                <div class="k">Actions rapides</div>
                <div style="margin-top:10px;display:flex;flex-direction:column;gap:8px;">
                    <a href="{{ route('admin.orders') }}" style="font-size:13px;">→ Gérer les commandes</a>
                    <a href="{{ route('admin.stats') }}" style="font-size:13px;">→ Voir les statistiques</a>
                    <a href="{{ route('home') }}" style="font-size:13px;">→ Voir le site</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
