<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'work_tables', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'auth_id' )->nullable();
            $table->string( 'title' );
            $table->unsignedInteger( 'daily_working_hours' );
            $table->text( 'remarks' )->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign( 'auth_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'work_tables' );
    }
};
