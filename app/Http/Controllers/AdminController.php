<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    private function requireAuth(Request $request): void
    {
        if (! $request->session()->get('admin_logged_in')) {
            abort(403);
        }
    }

    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Admin simple (à changer si tu veux)
        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === 'admin@blac-joyaux.com' && $password === 'admin123') {
            $request->session()->put('admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login')->with('status', 'Identifiants invalides.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        // Rediriger vers la page d'accueil après déconnexion
        return redirect()->route('home')->with('status', 'Déconnecté.');
    }

    public function dashboard(Request $request)
    {
        $this->requireAuth($request);

        $visitsTotal = PageView::count();
        $ordersTotal = Order::count();
        $revenueTotal = Order::sum('total_fcfa');

        // Statistiques pour le dashboard
        $visitsLast7 = PageView::where('created_at', '>=', now()->subDays(7))->count();
        $ordersLast7 = Order::where('created_at', '>=', now()->subDays(7))->count();
        $revenueLast7 = Order::where('created_at', '>=', now()->subDays(7))->sum('total_fcfa');

        // Commandes récentes (5 dernières)
        $recentOrders = Order::orderByDesc('created_at')->take(5)->get();

        // Visites par jour pour le graphique (7 derniers jours)
        $visitsByDay = PageView::where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Commandes par jour pour le graphique (7 derniers jours)
        $ordersByDay = Order::where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Générer les 7 derniers jours pour les labels
        $chartDays = [];
        $chartVisits = [];
        $chartOrders = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d/m');
            $chartDays[] = $label;
            $chartVisits[] = $visitsByDay->get($date)?->count ?? 0;
            $chartOrders[] = $ordersByDay->get($date)?->count ?? 0;
        }

        // Statuts des commandes
        $pendingOrders = Order::where('status', 'pending')->count();
        $paidOrders = Order::where('status', 'paid')->count();
        $finalizedOrders = Order::where('status', 'finalized')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();

        // Top routes
        $topRoutes = PageView::query()
            ->selectRaw('route_name, COUNT(*) as c')
            ->groupBy('route_name')
            ->orderByDesc('c')
            ->limit(6)
            ->get();

        return view('admin.dashboard', compact(
            'visitsTotal', 'ordersTotal', 'revenueTotal',
            'visitsLast7', 'ordersLast7', 'revenueLast7',
            'recentOrders', 'chartDays', 'chartVisits', 'chartOrders',
            'pendingOrders', 'paidOrders', 'finalizedOrders', 'deliveredOrders',
            'topRoutes'
        ));
    }

    public function stats(Request $request)
    {
        $this->requireAuth($request);

        $visitsLast7 = PageView::where('created_at', '>=', now()->subDays(7))->count();
        $ordersLast7 = Order::where('created_at', '>=', now()->subDays(7))->count();
        $revenueLast7 = Order::where('created_at', '>=', now()->subDays(7))->sum('total_fcfa');

        $topRoutes = PageView::query()
            ->selectRaw('route_name, COUNT(*) as c')
            ->groupBy('route_name')
            ->orderByDesc('c')
            ->limit(6)
            ->get();

        // Visites par jour pour le graphique (30 derniers jours)
        $visitsByDay = PageView::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $chartDays = [];
        $chartVisits = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d/m');
            $chartDays[] = $label;
            $chartVisits[] = $visitsByDay->get($date)?->count ?? 0;
        }

        // Revenus par jour (30 derniers jours)
        $revenueByDay = Order::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total_fcfa) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $chartRevenue = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartRevenue[] = $revenueByDay->get($date)?->total ?? 0;
        }

        return view('admin.stats', compact(
            'visitsLast7', 'ordersLast7', 'revenueLast7',
            'topRoutes', 'chartDays', 'chartVisits', 'chartRevenue'
        ));
    }

    public function orders(Request $request)
    {
        $this->requireAuth($request);

        $orders = Order::orderByDesc('created_at')->get();
        $pendingOrders = Order::where('status', 'pending')->count();
        $paidOrders = Order::where('status', 'paid')->count();
        $finalizedOrders = Order::where('status', 'finalized')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();

        return view('admin.orders', compact(
            'orders', 'pendingOrders', 'paidOrders', 'finalizedOrders', 'deliveredOrders'
        ));
    }

    public function finalizeOrder(Request $request, $id)
    {
        $this->requireAuth($request);

        $order = Order::findOrFail($id);
        $order->update(['status' => 'finalized']);

        return redirect()->route('admin.orders')->with('status', 'Commande #' . $id . ' finalisée.');
    }

    public function deliverOrder(Request $request, $id)
    {
        $this->requireAuth($request);

        $order = Order::findOrFail($id);
        $order->update(['status' => 'delivered']);

        return redirect()->route('admin.orders')->with('status', 'Commande #' . $id . ' marquée comme livrée.');
    }
}
