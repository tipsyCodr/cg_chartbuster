<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['movies', 'songs', 'tvshows'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('region_id')->after('trailer_url')->nullable()->constrained('regions')->onDelete('set null');
            });

            // Migrate data
            $rows = DB::table($tableName)->select('id', 'region')->get();
            foreach ($rows as $row) {
                if ($row->region) {
                    $regionName = trim($row->region);
                    $region = DB::table('regions')->where('name', $regionName)->first();
                    
                    if (!$region) {
                         $regionId = DB::table('regions')->insertGetId([
                             'name' => $regionName,
                             'created_at' => now(),
                             'updated_at' => now(),
                         ]);
                    } else {
                        $regionId = $region->id;
                    }
                    
                    DB::table($tableName)->where('id', $row->id)->update(['region_id' => $regionId]);
                }
            }

            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('region');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['movies', 'songs', 'tvshows'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('region')->nullable();
            });

            // Reverse migrate data
            $rows = DB::table($tableName)->select('id', 'region_id')->get();
            foreach ($rows as $row) {
                if ($row->region_id) {
                    $region = DB::table('regions')->find($row->region_id);
                    if ($region) {
                        DB::table($tableName)->where('id', $row->id)->update(['region' => $region->name]);
                    }
                }
            }

            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['region_id']);
                $table->dropColumn('region_id');
            });
        }
    }
};
