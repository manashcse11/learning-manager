<?php

use Illuminate\Database\Seeder;

class advanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->truncate();
        DB::table('items')->insert([
            [
                'type_id' => 3
                , 'category_id' => 1
                , 'item_parent_id' => 0
                , 'item_title' => 'Language/Framework/Technology'
                , 'item_description' => 'Language/Framework/Technology desc'
                , 'item_outcome' => 'https://gist.github.com/manashcse11/35d3c523075e107d914613c6f19ecc48'
                , 'item_priority' => 1
                , 'item_point' => 0
                , 'item_due_date' => '2017-09-20'
                , 'status_id' => 0
                , 'color_id' => 1
            ]
            , [
                'type_id' => 3
                , 'category_id' => 1
                , 'item_parent_id' => 0
                , 'item_title' => 'Tool'
                , 'item_description' => 'Tool desc'
                , 'item_outcome' => 'https://gist.github.com/manashcse11/35d3c523075e107d914613c6f19ecc48'
                , 'item_priority' => 5
                , 'item_point' => 0
                , 'item_due_date' => '2017-09-20'
                , 'status_id' => 0
                , 'color_id' => 1
            ]
            , [
                'type_id' => 4
                , 'category_id' => 1
                , 'item_parent_id' => 1
                , 'item_title' => 'Angularjs'
                , 'item_description' => 'Angularjs desc'
                , 'item_outcome' => 'https://gist.github.com/manashcse11/35d3c523075e107d914613c6f19ecc48'
                , 'item_priority' => 1
                , 'item_point' => 0
                , 'item_due_date' => '2017-09-20'
                , 'status_id' => 0
                , 'color_id' => 4
            ]
            , [
                'type_id' => 4
                , 'category_id' => 1
                , 'item_parent_id' => 1
                , 'item_title' => 'Reactjs'
                , 'item_description' => 'Reactjs desc'
                , 'item_outcome' => 'https://gist.github.com/manashcse11/35d3c523075e107d914613c6f19ecc48'
                , 'item_priority' => 1
                , 'item_point' => 0
                , 'item_due_date' => '2017-09-20'
                , 'status_id' => 0
                , 'color_id' => 3
            ]
            , [
                'type_id' => 5
                , 'category_id' => 1
                , 'item_parent_id' => 3
                , 'item_title' => 'Read full doc & keep a summarize gist'
                , 'item_description' => 'Read full doc & keep a summarize gist desc'
                , 'item_outcome' => 'https://gist.github.com/manashcse11/35d3c523075e107d914613c6f19ecc48'
                , 'item_priority' => 1
                , 'item_point' => 4
                , 'item_due_date' => '2017-09-20'
                , 'status_id' => 2
                , 'color_id' => 1
            ]
            , [
                'type_id' => 5
                , 'category_id' => 1
                , 'item_parent_id' => 3
                , 'item_title' => 'Create a boilerplate & push into git'
                , 'item_description' => 'Create a boilerplate & push into git desc'
                , 'item_outcome' => 'https://gist.github.com/manashcse11/35d3c523075e107d914613c6f19ecc48'
                , 'item_priority' => 1
                , 'item_point' => 5
                , 'item_due_date' => '2017-09-25'
                , 'status_id' => 1
                , 'color_id' => 1
            ]
            , [
                'type_id' => 5
                , 'category_id' => 1
                , 'item_parent_id' => 4
                , 'item_title' => 'Read React'
                , 'item_description' => 'Create a boilerplate & push into git desc'
                , 'item_outcome' => 'https://gist.github.com/manashcse11/35d3c523075e107d914613c6f19ecc48'
                , 'item_priority' => 1
                , 'item_point' => 3
                , 'item_due_date' => '2017-09-25'
                , 'status_id' => 1
                , 'color_id' => 1
            ]
            , [
                'type_id' => 4
                , 'category_id' => 1
                , 'item_parent_id' => 2
                , 'item_title' => 'Gulp'
                , 'item_description' => 'Gulp desc'
                , 'item_outcome' => 'https://gist.github.com/manashcse11/35d3c523075e107d914613c6f19ecc48'
                , 'item_priority' => 1
                , 'item_point' => 0
                , 'item_due_date' => '2017-09-20'
                , 'status_id' => 0
                , 'color_id' => 1
            ]
            , [
                'type_id' => 5
                , 'category_id' => 1
                , 'item_parent_id' => 8
                , 'item_title' => 'Create gulp file to inject'
                , 'item_description' => 'Gulp desc'
                , 'item_outcome' => 'https://gist.github.com/manashcse11/35d3c523075e107d914613c6f19ecc48'
                , 'item_priority' => 1
                , 'item_point' => 7
                , 'item_due_date' => '2017-09-20'
                , 'status_id' => 3
                , 'color_id' => 1
            ]
            ]);
    }
}
