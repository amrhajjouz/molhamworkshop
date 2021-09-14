<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Sponsorships' => [' كفالة يتيم', 'طبية', ' كفالة عائلة'],
            'Cases' => ['طبية', 'انسانية'],
            'Campaigns' => ['طبية', 'اغاثية', 'تعليم', 'مأوى'],
            'faqs' => ['أسئلة أخرى', 'أسئلة متعلقة بالتبرع' , 'أسئلة متعلقة بثسم الكفالات'],
        ];
        foreach ($categories as $created_for => $category) {
            foreach ($category as $item) {
                Category::create(['name' => $item,'created_for' => $created_for]);
            }
        }

    }
}
