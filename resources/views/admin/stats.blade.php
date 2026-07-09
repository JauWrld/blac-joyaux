<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Statistiques</title>
    <style>
        body {
            font-family: Inter, system-ui, Segoe UI, Arial;
            background: #0b0a09;
            color: #fffaf0;
            margin: 0;
        }

        .wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 22px;
        }

        a {
            color: #c6a75e;
            text-decoration: none;
            font-weight: 800;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
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

        .card {
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .05);
            border-radius: 12px;
            padding: 16px;
            margin-top: 14px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-top: 14px;
        }

        @media(max-width:900px) {
            .grid, .grid-2 {
                grid-template-columns: 1fr;
            }
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

        .chart-container {
            margin-top: 12px;
        }

        .chart-bars {
            display: flex;
            align-items: end;
            gap: 3px;
            height: 200px;
            padding: 0 2px;
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
            max-width: 30px;
            border-radius: 3px 3px 0 0;
            min-height: 2px;
            transition: height 0.3s;
        }

        .chart-bar.visits {
            background: rgba(198, 167, 94, .6);
        }

        .chart-bar.revenue {
            background: rgba(100, 200, 150, .6);
        }

        .chart-label {
            font-size: 9px;
            opacity: .5;
            text-align: center;
            transform: rotate(-45deg);
            white-space: nowrap;
            margin-top: 4px;
        }

        .chart-legend {
            display: flex;
            gap: 16px;
            margin-top: 10px;
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

        .dot.gold { background: rgba(198, 167, 94, .6); }
        .dot.green { background: rgba(100, 200, 150, .6); }

        ul {
            padding-left: 18px;
            margin: 10px 0 0;
        }

        li {
            margin: 6px 0;
            opacity: .9;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="top">
            <div>
                <div style="font-size:26px;font-weight:900;color:#c6a75e;">Admin</div>
                <div style="opacity:.75">Statistiques détaillées</div>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span style="opacity:.5"> · </span>
                <form method="post" action="{{ route('admin.logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" style="background:none;border:0;color:#c6a75e;font-weight:800;cursor:pointer">Déconnexion</button>
                </form>
            </div>
        </div>

        <div class="nav">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="active" href="{{ route('admin.stats') }}">Statistiques</a>
            <a href="{{ route('admin.orders') }}">Commandes</a>
        </div>

        <!-- KPIs 7 jours -->
        <div class="grid">
            <div class="card">
                <div class="k">Visites (7 jours)</div>
                <div class="v">{{ $visitsLast7 }}</div>
            </div>
            <div class="card">
                <div class="k">Commandes (7 jours)</div>
                <div class="v">{{ $ordersLast7 }}</div>
            </div>
            <div class="card">
                <div class="k">CA (7 jours)</div>
                <div class="v">{{ number_format($revenueLast7, 0, ',', ' ') }} FCFA</div>
            </div>
        </div>

        <!-- Graphiques 30 jours -->
        <div class="grid-2">
            <div class="card">
                <div class="k">Visites (30 derniers jours)</div>
                <div class="chart-container">
                    <div class="chart-bars">
                        @php $maxVisits = max($chartVisits) ?: 1; @endphp
                        @foreach ($chartDays as $i => $day)
                        <div class="chart-bar-group">
                            <div class="chart-bar visits" style="height: {{ ($chartVisits[$i] / $maxVisits) * 180 + 2 }}px;" title="{{ $chartVisits[$i] }} visites"></div>
                            <div class="chart-label">{{ $day }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="chart-legend">
                    <span><span class="dot gold"></span> Visites</span>
                </div>
            </div>

            <div class="card">
                <div class="k">Revenus (30 derniers jours)</div>
                <div class="chart-container">
                    <div class="chart-bars">
                        @php $maxRev = max($chartRevenue) ?: 1; @endphp
                        @foreach ($chartDays as $i => $day)
                        <div class="chart-bar-group">
                            <div class="chart-bar revenue" style="height: {{ ($chartRevenue[$i] / $maxRev) * 180 + 2 }}px;" title="{{ number_format($chartRevenue[$i], 0, ',', ' ') }} FCFA"></div>
                            <div class="chart-label">{{ $day }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="chart-legend">
                    <span><span class="dot green"></span> Revenus (FCFA)</span>
                </div>
            </div>
        </div>

        <!-- Top routes -->
        <div class="card">
            <div class="k">Pages les plus visitées</div>
            <ul>
                @foreach($topRoutes as $r)
                <li><strong>{{ $r->route_name ?? 'unknown' }}</strong> — {{ $r->c }} visites</li>
                @endforeach
            </ul>
        </div>
    </div>
</body>

</html>
