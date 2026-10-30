<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create calls table only when missing.
        if (! Schema::hasTable('calls')) {
            Schema::create('calls', function (Blueprint $table) {
                $table->id();
                $table->foreignId('caller_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
                $table->string('room_id')->index();
                $table->enum('status', ['ringing', 'accepted', 'rejected', 'ended'])
                    ->default('ringing');
                $table->timestamp('started_at')->nullable();
                $table->timestamp('ended_at')->nullable();
                $table->timestamps();
            });
        }

        // 2. Add unique index to temp_appointments.
        if (
            Schema::hasTable('temp_appointments') &&
            ! $this->indexExists('temp_appointments', 'temp_appointments_razorpay_order_id_unique')
        ) {
            $duplicates = DB::table('temp_appointments')
                ->select('razorpay_order_id')
                ->groupBy('razorpay_order_id')
                ->havingRaw('COUNT(*) > 1')
                ->exists();

            if ($duplicates) {
                throw new \RuntimeException(
                    'Duplicate razorpay_order_id values found. Migration stopped.'
                );
            }

            DB::statement(
                'ALTER TABLE temp_appointments
                 ADD UNIQUE INDEX temp_appointments_razorpay_order_id_unique (razorpay_order_id)'
            );
        }

        // 3. Add unique index to blogs.slug.
        if (
            Schema::hasTable('blogs') &&
            ! $this->indexExists('blogs', 'blogs_slug_unique')
        ) {
            $duplicates = DB::table('blogs')
                ->select('slug')
                ->whereNotNull('slug')
                ->groupBy('slug')
                ->havingRaw('COUNT(*) > 1')
                ->exists();

            if ($duplicates) {
                throw new \RuntimeException(
                    'Duplicate blog slugs found. Migration stopped.'
                );
            }

            DB::statement(
                'ALTER TABLE blogs ADD UNIQUE INDEX blogs_slug_unique (slug)'
            );
        }

        // 4. Add bank_details foreign key only when safe.
        if (
            Schema::hasTable('bank_details') &&
            ! $this->foreignKeyExists('bank_details', 'bank_details_user_id_foreign')
        ) {
            $orphans = DB::table('bank_details as b')
                ->leftJoin('users as u', 'b.user_id', '=', 'u.id')
                ->whereNull('u.id')
                ->count();

            if ($orphans > 0) {
                throw new \RuntimeException(
                    'Orphan bank_details records found. Migration stopped.'
                );
            }

            DB::statement(
                'ALTER TABLE bank_details
                 ADD CONSTRAINT bank_details_user_id_foreign
                 FOREIGN KEY (user_id) REFERENCES users(id)
                 ON DELETE CASCADE'
            );
        }

        // 5. Make area_prices.id unsigned without changing existing IDs.
        $areaId = DB::selectOne("
            SELECT COLUMN_TYPE
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'area_prices'
              AND COLUMN_NAME = 'id'
        ");

        if (
            $areaId &&
            ! str_contains(strtolower($areaId->COLUMN_TYPE), 'unsigned')
        ) {
            DB::statement(
                'ALTER TABLE area_prices
                 MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT'
            );
        }

        // 6. Add change_requested if missing. Never remove enum values.
        $bankStatus = DB::selectOne("
            SELECT COLUMN_TYPE
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'users'
              AND COLUMN_NAME = 'bank_status'
        ");

        if (
            $bankStatus &&
            ! str_contains($bankStatus->COLUMN_TYPE, 'change_requested')
        ) {
            DB::statement("
                ALTER TABLE users
                MODIFY bank_status
                ENUM(
                    'not_added',
                    'pending',
                    'verified',
                    'rejected',
                    'change_requested'
                )
                CHARACTER SET utf8mb4
                COLLATE utf8mb4_unicode_ci
                NOT NULL DEFAULT 'not_added'
            ");
        }

        // 7. counselor_documents FK intentionally untouched.
        // Live has 4 orphan records. Preserve all records and files.
    }

    private function indexExists(string $table, string $index): bool
    {
        $result = DB::selectOne(
            'SELECT COUNT(*) AS total
             FROM information_schema.STATISTICS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND INDEX_NAME = ?',
            [$table, $index]
        );

        return $result && (int) $result->total > 0;
    }

    private function foreignKeyExists(string $table, string $constraint): bool
    {
        $result = DB::selectOne(
            'SELECT COUNT(*) AS total
             FROM information_schema.TABLE_CONSTRAINTS
             WHERE CONSTRAINT_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND CONSTRAINT_NAME = ?
               AND CONSTRAINT_TYPE = ?',
            [$table, $constraint, 'FOREIGN KEY']
        );

        return $result && (int) $result->total > 0;
    }

    public function down(): void
    {
        throw new \RuntimeException(
            'This migration is intentionally irreversible to protect existing data.'
        );
    }
};
