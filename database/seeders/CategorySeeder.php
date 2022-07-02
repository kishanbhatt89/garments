<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Category::create([
            'parent_id' => 0,
            'name' => 'Category 1',
            'slug' => 'category-1'
        ]);

        Category::create([
            'parent_id' => 0,
            'name' => 'Category 2',
            'slug' => 'category-2'
        ]);

        Category::create([
            'parent_id' => 1,
            'name' => 'Sub Category 1',
            'slug' => 'sub-category-1'
        ]);

        Category::create([
            'parent_id' => 2,
            'name' => 'Sub Category 2',
            'slug' => 'sub-category-2'
        ]);

        Category::create([
            'parent_id' => 2,
            'name' => 'Sub Category 3',
            'slug' => 'sub-category-3'
        ]);
    }
}
