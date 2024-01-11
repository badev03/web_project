<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // them status cho bang user
        Schema::table('users', function (Blueprint $table) {
            
            $table->tinyInteger('status')->default(1)->after('password');
            $table->string('email')->nullable()->change();
            $table->string('phone')->nullable()->after('email');
            $table->string('address')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('address');
            $table->string('role')->nullable()->after('avatar')->default(1);
        });
       

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
