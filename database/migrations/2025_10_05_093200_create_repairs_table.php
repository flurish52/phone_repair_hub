<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('client_name')
                ->index();
            $table->string('device')
                ->index();
            $table->string('issue');
            $table->string('client_phone')
                ->nullable();
            $table->text('notes')
                ->nullable();
            $table->string('staff')
                ->nullable()
                ->index();
            $table->string('pickup_pin');
            $table->decimal('cost', 10, 2)
                ->nullable();
            $table->enum('status', ['pending', 'ready', 'picked'])
                ->default('pending');
            $table->json('images')->nullable();
            $table->softDeletes();
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
