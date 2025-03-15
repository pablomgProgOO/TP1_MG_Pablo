<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
//https://laravel.com/docs/9.x/database#running-raw-queries
//https://laravel.com/docs/10.x/filesystem#retrieving-files
//https://laravel.com/docs/10.x/helpers#method-database-path
class LanguageSeeder extends Seeder
{
    public function run()
    {
        $sql = File::get(database_path('seeds/languages.sql'));
        DB::unprepared($sql);
    }
}

