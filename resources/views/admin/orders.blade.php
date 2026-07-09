<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Commandes</title>
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

        .card {
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .05);
            border-radius: 12px;
            padding: 16px;
            margin-top: 14px;
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

        .status-summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 14px;
        }

        @media(max-width:700px) {
            .status-summary {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-box {
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 8px;
            padding: 12px;
            text-align: center;
        }

        .stat-box .num {
            font-size: 24px;
            font-weight: 900;
        }

        .stat-box .desc {
            font-size: 11px;
            opacity: .7;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: 4px;
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
            vertical-align: middle;
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

        .btn-action {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, .15);
            background: rgba(255, 255, 255, .05);
            color: #fffaf0;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-action:hover {
            background: rgba(255, 255, 255, .12);
        }

        .btn-action.finalize {
            border-color: rgba(50, 150, 255, .4);
            color: #7db8ff;
        }

        .btn-action.finalize:hover {
            background: rgba(50, 150, 255, .15);
        }

        .btn-action.deliver {
            border-color: rgba(100, 200, 150, .4);
            color: #7ddfa0;
        }

        .btn-action.deliver:hover {
            background: rgba(100, 200, 150, .15);
        }

        .btn-action.delivered {
            border-color: rgba(150, 100, 255, .4);
            color: #c4a8ff;
            opacity: .6;
            cursor: default;
        }

        .btn-action.pending {
            border-color: rgba(255, 200, 50, .4);
            color: #ffd866;
            opacity: .6;
            cursor: default;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            opacity: .6;
        }

        .btn-danger {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid rgba(255, 80, 80, .3);
            background: rgba(255, 80, 80, .08);
            color: #ff8080;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }

        .items-list {
            font-size: 12px;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="top">
            <div>
                <div style="font-size:26px;font-weight:900;color:#c6a75e;">Admin</div>
                <div style="opacity:.75">Gestion des commandes</div>
            </div>
            <div>
                <form method="post" action="{{ route('admin.logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" style="background:none;border:0;color:#c6a75e;font-weight:800;cursor:pointer">Déconnexion</button>
                </form>
            </div>
        </div>

        <div class="nav">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.stats') }}">Statistiques</a>
            <a class="active" href="{{ route('admin.orders') }}">Commandes</a>
        </div>

        @if (session('status'))
        <div class="card" style="border-color:rgba(110,180,115,.45);background:rgba(70,120,75,.18);color:#d7f4d9;">
            {{ session('status') }}
        </div>
        @endif

        <!-- Status summary cards -->
        <div class="status-summary">
            <div class="stat-box">
                <div class="num" style="color:#ffd866;">{{ $pendingOrders }}</div>
                <div class="desc">En attente</div>
            </div>
            <div class="stat-box">
                <div class="num" style="color:#7ddfa0;">{{ $paidOrders }}</div>
                <div class="desc">Payées</div>
            </div>
            <div class="stat-box">
                <div class="num" style="color:#7db8ff;">{{ $finalizedOrders }}</div>
                <div class="desc">Finalisées</div>
            </div>
            <div class="stat-box">
                <div class="num" style="color:#c4a8ff;">{{ $deliveredOrders }}</div>
                <div class="desc">Livrées</div>
            </div>
        </div>

        <div class="card">
            <div style="opacity:.85;font-weight:900;font-size:14px;">Toutes les commandes</div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Articles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                    <tr>
                        <td>#{{ $o->id }}</td>
                        <td>{{ $o->created_at?->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format((int)$o->total_fcfa, 0, ',', ' ') }} FCFA</td>
                        <td>
                            <span class="status-badge {{ $o->status }}">{{ $o->status }}</span>
                        </td>
                        <td>
                            <div class="items-list">
                                @php $items = is_array($o->items) ? $o->items : []; @endphp
                                @foreach ($items as $item)
                                <div>{{ $item['name'] ?? 'Article' }} × {{ $item['quantity'] ?? 1 }}</div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                @if ($o->status === 'pending' || $o->status === 'paid')
                                <form method="post" action="{{ route('admin.orders.finalize', $o->id) }}" style="display:inline;">
                                    @csrf
                                    <button class="btn-action finalize" type="submit">Finaliser</button>
                                </form>
                                @elseif ($o->status === 'finalized')
                                <form method="post" action="{{ route('admin.orders.deliver', $o->id) }}" style="display:inline;">
                                    @csrf
                                    <button class="btn-action deliver" type="submit">Livrer</button>
                                </form>
                                @elseif ($o->status === 'delivered')
                                <span class="btn-action delivered">Livrée ✓</span>
                                @else
                                <span class="btn-action pending">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div style="font-size:40px;margin-bottom:10px;">📦</div>
                                <div>Aucune commande pour le moment.</div>
                                <div style="margin-top:6px;font-size:12px;">Les commandes apparaîtront ici après validation par les clients.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
