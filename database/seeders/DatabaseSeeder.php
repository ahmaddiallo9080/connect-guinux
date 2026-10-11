<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Compte administrateur (identifiants dans le fichier .env)
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@guinuxconnect.com')],
            ['name' => 'Administrateur', 'password' => env('ADMIN_PASSWORD', 'ChangezMoi123!')]
        );

        // Catégories et produits d'exemple (prix indicatifs, à modifier dans l'admin)
        $catalogue = [
            'Routeurs hotspot' => [
                ['Routeur MikroTik hAP ac²', 'Routeur double bande idéal pour un hotspot de quartier ou un petit commerce.', 650000, 750000, 12, true],
                ['Routeur MikroTik RB4011', 'Routeur haute performance pour les réseaux hotspot de grande capacité.', 2900000, null, 4, true],
            ],
            'Points d\'accès WiFi' => [
                ['Point d\'accès Ubiquiti UniFi U6 Lite', 'WiFi 6 plafonnier, parfait pour couvrir boutiques, bureaux et hôtels.', 1250000, null, 8, true],
                ['Point d\'accès extérieur 5 GHz', 'Borne étanche pour couvrir une cour, un marché ou une place publique.', 1450000, 1600000, 5, false],
            ],
            'Antennes & liaisons' => [
                ['Antenne sectorielle 120°', 'Diffusion large pour couvrir tout un quartier depuis un point haut.', 980000, null, 6, false],
                ['Kit liaison point à point 5 km', 'Paire d\'antennes pour relier deux sites distants sans câble.', 2400000, null, 3, true],
            ],
            'Câblage & accessoires' => [
                ['Câble réseau Cat6 – rouleau 305 m', 'Câble cuivre pour installations intérieures et extérieures.', 1100000, null, 20, false],
                ['Switch PoE 8 ports', 'Alimente et connecte jusqu\'à 8 points d\'accès sur un seul appareil.', 850000, 950000, 10, false],
                ['Injecteur PoE 24 V', 'Alimentation par câble réseau pour antennes et points d\'accès.', 120000, null, 30, false],
            ],
            'Énergie & tickets' => [
                ['Onduleur 1500 VA', 'Garde votre hotspot en ligne pendant les coupures de courant.', 1350000, null, 7, false],
                ['Imprimante thermique de tickets', 'Imprimez vos codes WiFi (vouchers) directement au comptoir.', 750000, null, 9, true],
            ],
        ];

        foreach ($catalogue as $categoryName => $products) {
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($products as [$name, $short, $price, $old, $stock, $featured]) {
                Product::firstOrCreate(['name' => $name], [
                    'category_id' => $category->id,
                    'short_description' => $short,
                    'description' => $short."\n\nInstallation et configuration possibles par nos techniciens à Conakry et à l'intérieur du pays. Contactez-nous pour un devis complet.",
                    'price' => $price,
                    'old_price' => $old,
                    'stock' => $stock,
                    'is_featured' => $featured,
                    'is_active' => true,
                ]);
            }
        }
    }
}
