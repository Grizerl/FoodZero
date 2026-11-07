<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * Demo menu and blog content that uses images already shipped in public/assets/images.
 *
 * Idempotent (updateOrCreate) and creates no users. Run on purpose:
 *   php artisan db:seed --class=DemoContentSeeder
 */
class DemoContentSeeder extends Seeder
{
    private const IMG = '/assets/images';

    public function run(): void
    {
        $this->seedMenu();
        $this->seedPosts();
    }

    private function seedMenu(): void
    {
        // Ids 1-3 are fixed because HomeController@menu picks categories by id.
        $categories = [
            1 => ['Starters', self::IMG.'/menu/starters/cheese.png', [
                ['Caprese Salad', 'Tomatoes, buffalo mozzarella, basil and cold-pressed olive oil.', 12],
                ['Burrata with Roasted Tomatoes', 'Creamy burrata, slow-roasted cherry tomatoes and toasted sourdough.', 14],
                ['Cucumber Salad', 'Crisp cucumber, dill, lemon and a spoon of thick yoghurt.', 9],
                ['Smoked Salmon Toast', 'Rye toast, whipped cream cheese, smoked salmon and capers.', 13],
            ]],
            2 => ['Mains', self::IMG.'/menu/Main/Beef.png', [
                ['Steak With Rosemary Butter', 'Grilled ribeye, rosemary butter, charred onions and mushrooms.', 22],
                ['Deep Sea Snow White Cod Fillet', 'Pan-seared cod, lemon beurre blanc and seasonal greens.', 20],
                ['Herb-Roasted Chicken', 'Free-range chicken, thyme jus and roasted root vegetables.', 18],
                ['Wild Mushroom Risotto', 'Arborio rice, forest mushrooms, parmesan and fresh parsley.', 17],
            ]],
            3 => ['Pastries & Drinks', self::IMG.'/menu/Pastries&Drinks/cups.png', [
                ['Avocado Toast', 'Smashed avocado, chilli flakes, lime and a soft-boiled egg.', 11],
                ['Lemon Tart', 'Buttery shortcrust, lemon curd and a light meringue.', 8],
                ['Fresh Berry Smoothie', 'Blueberries, raspberries, banana and almond milk.', 7],
                ['Flat White', 'Double ristretto with silky steamed milk.', 4],
            ]],
        ];

        foreach ($categories as $id => [$name, $image, $dishes]) {
            $category = Category::updateOrCreate(['id' => $id], ['name' => $name, 'images_category' => $image]);

            foreach ($dishes as [$dish, $description, $price]) {
                Menu::updateOrCreate(
                    ['category_id' => $category->id, 'name' => $dish],
                    ['images' => $image, 'description' => $description, 'price' => $price],
                );
            }
        }
    }

    private function seedPosts(): void
    {
        $authors = [
            'Julie Christie' => self::IMG.'/blog/people/Julie Christie.png',
            'Dianne Russell' => self::IMG.'/blog/people/Dianne Russell.png',
            'Cody Fisher' => self::IMG.'/blog/people/Cody Fisher.png',
            'Leslie Alexander' => self::IMG.'/blog/people/Leslie Alexander.png',
            'Theresa Webb' => self::IMG.'/blog/people/Theresa Webb.png',
            'Jenifier Lopez' => self::IMG.'/blog/people/Jenifier Lopez.png',
        ];

        $posts = [
            ['Fruit and vegetables and protection against diseases', 'Julie Christie', '/fashion blog/Feature Image.png',
                'Colourful fruit and vegetables bring fibre, vitamins and antioxidants to the table. Learn how to build a plate that keeps you energised all day.'],
            ['Asparagus Spring Salad with Rocket, Goat\'s Cheese', 'Dianne Russell', '/fashion blog/Feature Image (1).png',
                'Tender asparagus, peppery rocket and tangy goat\'s cheese make a spring salad that comes together in ten minutes.'],
            ['Why seasonal eating simply tastes better', 'Cody Fisher', '/blog/dish/Feature Image (2).png',
                'Produce picked at its peak needs less seasoning and less transport. Here is how our kitchen plans a menu around the market calendar.'],
            ['Five spices every healthy kitchen needs', 'Leslie Alexander', '/blog/dish/Feature Image (3).png',
                'Turmeric, coriander, star anise, black pepper and cumin turn simple ingredients into something memorable without adding salt.'],
            ['Slow-cooked beef: patience on a plate', 'Theresa Webb', '/blog/dish/Feature Image (4).png',
                'Low heat, good stock and time. Our chef explains how a humble cut becomes the most tender dish on the menu.'],
            ['Breakfast bowls that keep you going', 'Jenifier Lopez', '/blog/dish/Feature Image (5).png',
                'Oats, yoghurt, seeds and fresh fruit: five bowls you can prepare the night before and enjoy in minutes.'],
            ['A chef\'s guide to buying fresh fish', 'Julie Christie', '/blog/dish/Feature Image (6).png',
                'Clear eyes, bright gills and a clean sea smell. What to look for at the counter and how to store fish at home.'],
            ['Sweet endings: desserts with less sugar', 'Dianne Russell', '/blog/detail/Granules.png',
                'Ripe fruit, spices and good dairy let a dessert shine without a mountain of sugar. Three recipes from our pastry team.'],
        ];

        foreach ($posts as [$title, $author, $image, $description]) {
            Post::updateOrCreate(
                ['title' => $title],
                [
                    'images' => self::IMG.$image,
                    'description' => $description,
                    'clients' => $author,
                    'clients_img' => $authors[$author],
                ],
            );
        }
    }
}
