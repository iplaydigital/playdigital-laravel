<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('legacy_cid')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('legacy_id')->nullable()->unique();
            $table->foreignId('work_category_id')->constrained('work_categories')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('client_name')->nullable();
            $table->string('product_name')->nullable();
            $table->string('campaign_name')->nullable();
            $table->string('media_type')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail');
            $table->json('gallery_images')->nullable();
            $table->string('youtube_id')->nullable();
            $table->string('external_url')->nullable();
            $table->boolean('is_featured_home')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('icon_path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('about_rules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('icon_path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('number')->unique();
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('logo_path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category')->default('Digital Insights');
            $table->text('excerpt');
            $table->longText('body');
            $table->string('cover_image')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('contact_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 50)->nullable();
            $table->string('company')->nullable();
            $table->string('service_interest')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('status', 30)->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_inquiries');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('about_rules');
        Schema::dropIfExists('services');
        Schema::dropIfExists('works');
        Schema::dropIfExists('work_categories');
    }
};
