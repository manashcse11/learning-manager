<?php

use Illuminate\Database\Seeder;

class basicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Manash'
            , 'email' => 'manash.pstu@gmail.com'
            , 'password' => bcrypt('123456')
        ]);

        DB::table('levels')->insert([
            'level_title' => 'Level 1'
        ]);

        DB::table('category')->insert([
            [
                'category_title' => 'Frontend'
            ]
            , [
                'category_title' => 'Backend'
            ]
        ]);

        DB::table('status')->insert([
            [
                'status_title' => 'To Do'
                , 'status_class' => 'todo'
            ]
            , [
                'status_title' => 'In Progress'
                , 'status_class' => 'inprogress'
            ]
            , [
                'status_title' => 'Done'
                , 'status_class' => 'done'
            ]
        ]);

        DB::table('type')->insert([
            [
                'type_parent_id' => 0
                , 'type_title' => 'Level'
            ]
            , [
                'type_parent_id' => 1
                , 'type_title' => 'Category'
            ]
            , [
                'type_parent_id' => 2
                , 'type_title' => 'Sub Category'
            ]
            , [
                'type_parent_id' => 3
                , 'type_title' => 'Item'
            ]
            , [
                'type_parent_id' => 4
                , 'type_title' => 'Milestone'
            ]
        ]);

        DB::table('colors')->insert([
            [
                'color_code' => '#777'
            ]
            , [
                'color_code' => '#1f618d'
            ]
            , [
                'color_code' => '#5bc0de'
            ]
            , [
                'color_code' => '#05c439'
            ]
            , [
                'color_code' => '#fd5e13'
            ]
            , [
                'color_code' => '#bf5329'
            ]
        ]);
    }
}
