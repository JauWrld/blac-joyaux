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
    // === Collection Sac de Bureau Unisex Kora Duffel ===
    'kora-duffel-cacao' => [
        'slug' => 'kora-duffel-cacao',
        'name' => 'Sac de Bureau Kora Duffel Cacao',
        'collection' => 'bureau',
        'collection_label' => 'Sac de Bureau Unisex Kora Duffel',
        'tone' => 'cacao',
        'price' => 95000,
        'price_label' => '95 000 FCFA',
        'image' => 'images/sacs/sac kora duffel brun.png',
        'copy' => 'Sac de bureau unisex en cuir marron chocolat, élégant et professionnel avec zip doré.',
        'dimensions' => '34 x 22 x 16 cm',
        'material' => 'Cuir graine marron, doublure textile monogrammée',
        'color' => 'Marron cacao',
        'features' => ['Double anse rigide', 'Zip métallique doré', 'Poche latérale ouverte', 'Poche intérieure zippée', 'Breloque signature Kora'],
        'frames' => ['images/sacs/all view koral red.jpeg', 'images/sacs/all view korel black.jpeg'],
    ],
    'kora-duffel-nuit' => [
        'slug' => 'kora-duffel-nuit',
        'name' => 'Sac de Bureau Kora Duffel Nuit',
        'collection' => 'bureau',
        'collection_label' => 'Sac de Bureau Unisex Kora Duffel',
        'tone' => 'nuit',
        'price' => 95000,
        'price_label' => '95 000 FCFA',
        'image' => 'images/sacs/sac kora duffel bleu.png',
        'copy' => 'Sac de bureau unisex bleu nuit texturé, sobre et facile à porter au quotidien.',
        'dimensions' => '34 x 22 x 16 cm',
        'material' => 'Cuir graine bleu nuit, doublure textile cacao',
        'color' => 'Bleu nuit',
        'features' => ['Double anse ton sur ton', 'Zip métallique doré', 'Poche latérale ouverte', 'Fond renforcé', 'Breloque signature Kora'],
        'frames' => ['images/sacs/all view korel black.jpeg', 'images/sacs/all view koral red.jpeg'],
    ],
    'kora-duffel-sable' => [
        'slug' => 'kora-duffel-sable',
        'name' => 'Sac de Bureau Kora Duffel Sable',
        'collection' => 'bureau',
        'collection_label' => 'Sac de Bureau Unisex Kora Duffel',
        'tone' => 'sable',
        'price' => 95000,
        'price_label' => '95 000 FCFA',
        'image' => 'images/sacs/sac kora duffel sable.png',
        'copy' => 'Sac de bureau unisex camel lumineux, doux et raffiné au style intemporel.',
        'dimensions' => '34 x 22 x 16 cm',
        'material' => 'Cuir graine camel, doublure textile ton chaud',
        'color' => 'Camel sable',
        'features' => ['Double anse camel', 'Zip métallique doré', 'Poche latérale ouverte', 'Pieds de protection', 'Breloque signature Kora'],
        'frames' => ['images/sacs/all view koral red.jpeg', 'images/sacs/all view korel black.jpeg'],
    ],
    'kora-duffel-noir' => [
        'slug' => 'kora-duffel-noir',
        'name' => 'Sac de Bureau Kora Duffel Noir',
        'collection' => 'bureau',
        'collection_label' => 'Sac de Bureau Unisex Kora Duffel',
        'tone' => 'noir',
        'price' => 95000,
        'price_label' => '95 000 FCFA',
        'image' => 'images/sacs/sac kora duffel noir.png',
        'copy' => 'Sac de bureau unisex noir, intemporel et sophistiqué pour un look professionnel.',
        'dimensions' => '34 x 22 x 16 cm',
        'material' => 'Cuir graine noir, doublure textile',
        'color' => 'Noir',
        'features' => ['Double anse rigide', 'Zip métallique doré', 'Poche latérale ouverte', 'Poche intérieure zippée', 'Breloque signature Kora'],
        'frames' => ['images/sacs/all view koral red.jpeg', 'images/sacs/all view korel black.jpeg'],
    ],
    'kora-duffel-rouge' => [
        'slug' => 'kora-duffel-rouge',
        'name' => 'Sac de Bureau Kora Duffel Rouge',
        'collection' => 'bureau',
        'collection_label' => 'Sac de Bureau Unisex Kora Duffel',
        'tone' => 'rouge',
        'price' => 95000,
        'price_label' => '95 000 FCFA',
        'image' => 'images/sacs/sac kora dufel rouge.png',
        'copy' => 'Sac de bureau unisex rouge, audacieux et élégant pour se démarquer.',
        'dimensions' => '34 x 22 x 16 cm',
        'material' => 'Cuir graine rouge, doublure textile',
        'color' => 'Rouge',
        'features' => ['Double anse rigide', 'Zip métallique doré', 'Poche latérale ouverte', 'Poche intérieure zippée', 'Breloque signature Kora'],
        'frames' => ['images/sacs/all view koral red.jpeg', 'images/sacs/all view korel black.jpeg'],
    ],

    // === Collection Sac DO ===
    'sac-do-marron' => [
        'slug' => 'sac-do-marron',
        'name' => 'Sac à main en cuir DO Marron',
        'collection' => 'do',
        'collection_label' => 'Collection Sac DO',
        'tone' => 'marron',
        'price' => 50000,
        'price_label' => '50 000 FCFA',
        'image' => 'images/sacs/sac-à-main DO cuir marron.png',
        'copy' => 'Sac à main en cuir marron, élégant et pratique pour votre quotidien.',
        'dimensions' => '28 x 18 x 10 cm',
        'material' => 'Cuir de qualité, finition soignée',
        'color' => 'Marron',
        'features' => ['Anse ajustable', 'Fermeture zip', 'Poche intérieure', 'Style Blac Joyaux'],
        'frames' => ['images/sacs/sac-à-main DO cuir marron.png'],
    ],
    'sac-do-marron-boucle' => [
        'slug' => 'sac-do-marron-boucle',
        'name' => 'Sac à main en cuir DO Boucle',
        'collection' => 'do',
        'collection_label' => 'Collection Sac DO',
        'tone' => 'marron',
        'price' => 50000,
        'price_label' => '50 000 FCFA',
        'image' => 'images/sacs/sac-à-main DO cuir marron boucle.png',
        'copy' => 'Sac à main en cuir avec boucle, un choix chic et raffiné.',
        'dimensions' => '28 x 18 x 10 cm',
        'material' => 'Cuir de qualité, boucle métallique',
        'color' => 'Marron avec boucle',
        'features' => ['Anse ajustable', 'Fermeture à boucle', 'Poche intérieure', 'Style Blac Joyaux'],
        'frames' => ['images/sacs/sac-à-main DO cuir marron boucle.png'],
    ],
    'sac-do-noir' => [
        'slug' => 'sac-do-noir',
        'name' => 'Sac à main en cuir DO Noir',
        'collection' => 'do',
        'collection_label' => 'Collection Sac DO',
        'tone' => 'noir',
        'price' => 70000,
        'price_label' => '70 000 FCFA',
        'image' => 'images/sacs/sac-à-main DO cuir noir.png',
        'copy' => 'Sac à main en cuir noir, intemporel et sophistiqué.',
        'dimensions' => '28 x 18 x 10 cm',
        'material' => 'Cuir de qualité noir, finition luxe',
        'color' => 'Noir',
        'features' => ['Anse ajustable', 'Fermeture zip', 'Poche intérieure', 'Style Blac Joyaux'],
        'frames' => ['images/sacs/sac-à-main DO cuir noir.png'],
    ],

    // === Collection Sac Vegan ===
    'sac-vegan-noir' => [
        'slug' => 'sac-vegan-noir',
        'name' => 'Sac à main Vegan Noir',
        'collection' => 'vegan',
        'collection_label' => 'Collection Sac Vegan',
        'tone' => 'noir',
        'price' => 50000,
        'price_label' => '50 000 FCFA',
        'image' => 'images/sacs/sac à main vegan noir.png',
        'copy' => 'Sac à main vegan noir, éthique et élégant pour un look responsable.',
        'dimensions' => '30 x 20 x 10 cm',
        'material' => 'Matériau vegan premium',
        'color' => 'Noir',
        'features' => ['Matière vegan', 'Design moderne', 'Fermeture zip', 'Style Blac Joyaux'],
        'frames' => ['images/sacs/sac à main vegan noir.png'],
    ],
    'sac-vegan-rouge' => [
        'slug' => 'sac-vegan-rouge',
        'name' => 'Sac à main Vegan Rouge',
        'collection' => 'vegan',
        'collection_label' => 'Collection Sac Vegan',
        'tone' => 'rouge',
        'price' => 50000,
        'price_label' => '50 000 FCFA',
        'image' => 'images/sacs/sac à main vegan rouge.png',
        'copy' => 'Sac à main vegan rouge audacieux pour celles et ceux qui osent.',
        'dimensions' => '30 x 20 x 10 cm',
        'material' => 'Matériau vegan premium',
        'color' => 'Rouge',
        'features' => ['Matière vegan', 'Design moderne', 'Fermeture zip', 'Style Blac Joyaux'],
        'frames' => ['images/sacs/sac à main vegan rouge.png'],
    ],
    'sac-vegan-vert' => [
        'slug' => 'sac-vegan-vert',
        'name' => 'Sac à main Vegan Vert',
        'collection' => 'vegan',
        'collection_label' => 'Collection Sac Vegan',
        'tone' => 'vert',
        'price' => 50000,
        'price_label' => '50 000 FCFA',
        'image' => 'images/sacs/sac à main vegan vert.png',
        'copy' => 'Sac à main vegan vert, frais et naturel pour un style unique.',
        'dimensions' => '30 x 20 x 10 cm',
        'material' => 'Matériau vegan premium',
        'color' => 'Vert',
        'features' => ['Matière vegan', 'Design moderne', 'Fermeture zip', 'Style Blac Joyaux'],
        'frames' => ['images/sacs/sac à main vegan vert.png'],
    ],

    // === Collection Trousse Homme ===
    'trousse-homme-brun' => [
        'slug' => 'trousse-homme-brun',
        'name' => 'Trousse pour Homme Brun',
        'collection' => 'trousse',
        'collection_label' => 'Trousses pour Hommes',
        'tone' => 'brun',
        'price' => 55000,
        'price_label' => '55 000 FCFA',
        'image' => 'images/sacs/trousse homme brun.png',
        'copy' => 'Trousse pour homme brun, élégante et fonctionnelle pour vos essentiels.',
        'dimensions' => '24 x 12 x 8 cm',
        'material' => 'Textile durable, finition élégante',
        'color' => 'Brun',
        'features' => ['Fermeture zip solide', 'Intérieur soigné', 'Style Blac Joyaux'],
        'frames' => ['images/sacs/trousse homme brun.png'],
    ],
    'trousse-homme-noire' => [
        'slug' => 'trousse-homme-noire',
        'name' => 'Trousse pour Homme Noire',
        'collection' => 'trousse',
        'collection_label' => 'Trousses pour Hommes',
        'tone' => 'noire',
        'price' => 55000,
        'price_label' => '55 000 FCFA',
        'image' => 'images/sacs/trousse homme noire.png',
        'copy' => 'Trousse pour homme noire, sobre et chic pour le quotidien.',
        'dimensions' => '24 x 12 x 8 cm',
        'material' => 'Textile durable, finition élégante',
        'color' => 'Noire',
        'features' => ['Fermeture zip solide', 'Intérieur soigné', 'Style Blac Joyaux'],
        'frames' => ['images/sacs/trousse homme noire.png'],
    ],
    'trousse-homme-vert' => [
        'slug' => 'trousse-homme-vert',
        'name' => 'Trousse pour Homme Vert',
        'collection' => 'trousse',
        'collection_label' => 'Trousses pour Hommes',
        'tone' => 'vert',
        'price' => 55000,
        'price_label' => '55 000 FCFA',
        'image' => 'images/sacs/trousse homme vert.png',
        'copy' => 'Trousse pour homme vert, tendance et pratique au quotidien.',
        'dimensions' => '24 x 12 x 8 cm',
        'material' => 'Textile durable, finition élégante',
        'color' => 'Vert',
        'features' => ['Fermeture zip solide', 'Intérieur soigné', 'Style Blac Joyaux'],
        'frames' => ['images/sacs/trousse homme vert.png'],
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
        PageView::create(['route_name' => 'home', 'path' => request()->path(), 'user_agent' => request()->userAgent()]);
    } catch (\Throwable $e) {}
    return view('home', $viewData('home'));
})->name('home');

Route::get('/sacs/{slug}', function (string $slug) use ($bags, $viewData) {
    abort_unless(isset($bags[$slug]), 404);
    try {
        PageView::create(['route_name' => 'sacs.show', 'path' => request()->path(), 'user_agent' => request()->userAgent()]);
    } catch (\Throwable $e) {}
    return view('home', $viewData('product', ['product' => $bags[$slug]]));
})->name('sacs.show');

Route::post('/panier/ajouter/{slug}', function (Request $request, string $slug) use ($bags) {
    abort_unless(isset($bags[$slug]), 404);
    $quantity = max(1, min(9, (int) $request->input('quantity', 1)));
    $cart = session('cart', []);
    $cart[$slug] = ($cart[$slug] ?? 0) + $quantity;
    session(['cart' => $cart]);
    return redirect()->route('panier')->with('status', $bags[$slug]['name'] . ' a été ajouté au panier.');
})->name('cart.add');

Route::post('/panier/retirer/{slug}', function (string $slug) {
    $cart = session('cart', []);
    unset($cart[$slug]);
    session(['cart' => $cart]);
    return redirect()->route('panier')->with('status', 'Le sac a été retiré du panier.');
})->name('cart.remove');

// Favoris toggle (AJAX)
Route::post('/favoris/toggle/{slug}', function (string $slug) use ($bags) {
    abort_unless(isset($bags[$slug]), 404);
    $favorites = session('favorites', []);
    if (in_array($slug, $favorites)) {
        $favorites = array_values(array_filter($favorites, fn($s) => $s !== $slug));
    } else {
        $favorites[] = $slug;
    }
    session(['favorites' => $favorites]);
    return response()->json(['liked' => in_array($slug, $favorites), 'count' => count($favorites)]);
})->name('favoris.toggle');

foreach ($pages as $slug => $page) {
    if ($slug === 'home') continue;
    Route::get('/' . $slug, fn() => view('home', $viewData($slug)))->name($slug);
}

Route::post('/commande/complete', function () use ($bags) {
    $cart = session('cart', []);
    $items = [];
    $total = 0;
    foreach ($cart as $slug => $quantity) {
        if (!isset($bags[$slug])) continue;
        $bag = $bags[$slug];
        $items[] = ['slug' => $slug, 'name' => $bag['name'], 'quantity' => $quantity, 'unit_fcfa' => $bag['price'], 'line_total_fcfa' => $bag['price'] * $quantity];
        $total += $bag['price'] * $quantity;
    }
    if (!empty($items)) {
        Order::create(['items' => $items, 'total_fcfa' => $total, 'status' => 'pending']);
    }
    session()->forget('cart');
    return redirect()->route('collection')->with('status', 'Commande confirmée. Merci !');
})->name('commande.complete');

use App\Http\Controllers\AdminController;

Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/stats', [AdminController::class, 'stats'])->name('admin.stats');
Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
Route::post('/admin/orders/{id}/finalize', [AdminController::class, 'finalizeOrder'])->name('admin.orders.finalize');
Route::post('/admin/orders/{id}/deliver', [AdminController::class, 'deliverOrder'])->name('admin.orders.deliver');
