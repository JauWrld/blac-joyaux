<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$pages = [
    'home' => ['title' => 'Maison'],
    'collection' => ['title' => 'Collection'],
    'savoir-faire' => ['title' => 'Savoir-faire'],
    'histoire' => ['title' => 'L\'histoire'],
    'contact' => ['title' => 'Contact'],
    'faq' => ['title' => 'FAQ'],
    'commande' => ['title' => 'Commander'],
    'favoris' => ['title' => 'Favoris'],
    'panier' => ['title' => 'Panier'],
    'mentions-legales' => ['title' => 'Mentions legales'],
    'confidentialite' => ['title' => 'Confidentialite'],
];

$bags = [
    'kora-duffel-cacao' => [
        'slug' => 'kora-duffel-cacao',
        'name' => 'Kora Duffel Cacao',
        'tone' => 'cacao',
        'price' => 95000,
        'price_label' => '95 000 FCFA',
        'image' => 'images/sacs/kora-duffel-cacao.jpg',
        'copy' => 'La version marron chocolat, elegante et profonde, avec zip dore et breloque signature.',
        'dimensions' => '34 x 22 x 16 cm',
        'material' => 'Cuir graine marron, doublure textile monogrammee',
        'color' => 'Marron cacao',
        'features' => ['Double anse rigide', 'Zip metallique dore', 'Poche laterale ouverte', 'Poche interieure zippee', 'Breloque signature Kora'],
        'frames' => ['images/sacs/all view koral red.jpeg', 'images/sacs/all view korel black.jpeg'],
    ],
    'kora-duffel-nuit' => [
        'slug' => 'kora-duffel-nuit',
        'name' => 'Kora Duffel Nuit',
        'tone' => 'nuit',
        'price' => 92000,
        'price_label' => '92 000 FCFA',
        'image' => 'images/sacs/kora-duffel-nuit.jpg',
        'copy' => 'Un bleu nuit texture pour un sac sobre, professionnel et facile a porter.',
        'dimensions' => '34 x 22 x 16 cm',
        'material' => 'Cuir graine bleu nuit, doublure textile cacao',
        'color' => 'Bleu nuit',
        'features' => ['Double anse ton sur ton', 'Zip metallique dore', 'Poche laterale ouverte', 'Fond renforce', 'Breloque signature Kora'],
        'frames' => ['images/sacs/all view korel black.jpeg', 'images/sacs/all view koral red.jpeg'],
    ],
    'kora-duffel-sable' => [
        'slug' => 'kora-duffel-sable',
        'name' => 'Kora Duffel Sable',
        'tone' => 'sable',
        'price' => 90000,
        'price_label' => '90 000 FCFA',
        'image' => 'images/sacs/kora-duffel-sable.jpg',
        'copy' => 'Un camel lumineux, doux et raffine, avec une structure identique au modele Kora Duffel.',
        'dimensions' => '34 x 22 x 16 cm',
        'material' => 'Cuir graine camel, doublure textile ton chaud',
        'color' => 'Camel sable',
        'features' => ['Double anse camel', 'Zip metallique dore', 'Poche laterale ouverte', 'Pieds de protection', 'Breloque signature Kora'],
        'frames' => ['images/sacs/all view koral red.jpeg', 'images/sacs/all view korel black.jpeg'],
    ],

    // Trousse (prix fixe 50 000 FCFA)
    'trousse-noire' => [
        'slug' => 'trousse-noire',
        'name' => 'Trousse Noire',
        'tone' => 'noire',
        'price' => 50000,
        'price_label' => '50 000 FCFA',
        'image' => 'images/sacs/trousse noire all view.jpeg',
        'copy' => 'Une trousse au style sobre, fermée avec une fermeture résistante et une finition luxe.',
        'dimensions' => '24 x 12 x 8 cm',
        'material' => 'Textile durable, finition élégante',
        'color' => 'Noire',
        'features' => ['Fermeture zip solide', 'Intérieur soigné', 'Style Blac-Joyaux'],
        'frames' => ['images/sacs/trousse noire all view.jpeg'],
    ],
    'trousse-green' => [
        'slug' => 'trousse-green',
        'name' => 'Trousse Verte',
        'tone' => 'green',
        'price' => 50000,
        'price_label' => '50 000 FCFA',
        'image' => 'images/sacs/trousse green all view.jpeg',
        'copy' => 'Une trousse verte chic pour organiser vos essentiels avec raffinement.',
        'dimensions' => '24 x 12 x 8 cm',
        'material' => 'Textile durable, finition élégante',
        'color' => 'Verte',
        'features' => ['Fermeture zip solide', 'Intérieur soigné', 'Style Blac-Joyaux'],
        'frames' => ['images/sacs/trousse green all view.jpeg'],
    ],
    'trousse-brune' => [
        'slug' => 'trousse-brune',
        'name' => 'Trousse Brune',
        'tone' => 'brune',
        'price' => 50000,
        'price_label' => '50 000 FCFA',
        'image' => 'images/sacs/trousse brune all view.jpeg',
        'copy' => 'Une trousse brune élégante pensée pour un rangement pratique et chic.',
        'dimensions' => '24 x 12 x 8 cm',
        'material' => 'Textile durable, finition élégante',
        'color' => 'Brune',
        'features' => ['Fermeture zip solide', 'Intérieur soigné', 'Style Blac-Joyaux'],
        'frames' => ['images/sacs/trousse brune all view.jpeg'],
    ],
];


$viewData = fn(string $page, array $extra = []) => array_merge([
    'page' => $page,
    'pages' => $pages,
    'bags' => $bags,
], $extra);

use App\Models\PageView;
use App\Models\Order;

Route::middleware([])->get('/', function () use ($viewData) {
    try {
        PageView::create([
            'route_name' => 'home',
            'path' => request()->path(),
            'user_agent' => request()->userAgent(),
        ]);
    } catch (\Throwable $e) {
        // ignore when DB/migrations not available (tests or fresh env)
    }

    return view('home', $viewData('home'));
})->name('home');


Route::get('/sacs/{slug}', function (string $slug) use ($bags, $viewData) {
    abort_unless(isset($bags[$slug]), 404);

    try {
        PageView::create([
            'route_name' => 'sacs.show',
            'path' => request()->path(),
            'user_agent' => request()->userAgent(),
        ]);
    } catch (\Throwable $e) {
        // ignore when DB/migrations not available (tests or fresh env)
    }

    return view('home', $viewData('product', ['product' => $bags[$slug]]));
})->name('sacs.show');


Route::post('/panier/ajouter/{slug}', function (Request $request, string $slug) use ($bags) {
    abort_unless(isset($bags[$slug]), 404);

    $quantity = max(1, min(9, (int) $request->input('quantity', 1)));
    $cart = session('cart', []);
    $cart[$slug] = ($cart[$slug] ?? 0) + $quantity;

    session(['cart' => $cart]);

    return redirect()->route('panier')->with('status', $bags[$slug]['name'] . ' a ete ajoute au panier.');
})->name('cart.add');

Route::post('/panier/retirer/{slug}', function (string $slug) {
    $cart = session('cart', []);
    unset($cart[$slug]);

    session(['cart' => $cart]);

    return redirect()->route('panier')->with('status', 'Le sac a ete retire du panier.');
})->name('cart.remove');

foreach ($pages as $slug => $page) {
    if ($slug === 'home') {
        continue;
    }

    Route::get('/' . $slug, fn() => view('home', $viewData($slug)))->name($slug);
}

// Cart count/checkout completion
Route::post('/commande/complete', function () use ($bags) {
    $cart = session('cart', []);

    $items = [];
    $total = 0;

    foreach ($cart as $slug => $quantity) {
        if (!isset($bags[$slug])) {
            continue;
        }
        $bag = $bags[$slug];
        $items[] = [
            'slug' => $slug,
            'name' => $bag['name'],
            'quantity' => $quantity,
            'unit_fcfa' => $bag['price'],
            'line_total_fcfa' => $bag['price'] * $quantity,
        ];
        $total += $bag['price'] * $quantity;
    }

    if (!empty($items)) {
        Order::create([
            'items' => $items,
            'total_fcfa' => $total,
            'status' => 'pending',
        ]);
    }

    session()->forget('cart');

    // retour automatique vers collection
    return redirect()->route('collection')->with('status', 'Commande confirmée. Merci !');
})->name('commande.complete');


// Admin routes (session-based)
use App\Http\Controllers\AdminController;

Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/stats', [AdminController::class, 'stats'])->name('admin.stats');
Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
Route::post('/admin/orders/{id}/finalize', [AdminController::class, 'finalizeOrder'])->name('admin.orders.finalize');
Route::post('/admin/orders/{id}/deliver', [AdminController::class, 'deliverOrder'])->name('admin.orders.deliver');
