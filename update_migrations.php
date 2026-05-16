<?php
$dir = __DIR__ . '/database/migrations/';

// 1. Localities
$f1 = $dir . '2026_05_14_224209_create_localities_table.php';
$c1 = file_get_contents($f1);
$c1 = str_replace(
    '$table->id();',
    '$table->id();
            $table->string(\'name\');
            $table->foreignId(\'zone_id\')->nullable()->constrained(\'zones\')->nullOnDelete();
            $table->string(\'city\')->default(\'Jalandhar\');
            $table->string(\'state\')->default(\'Punjab\');
            $table->string(\'pincode\')->nullable();
            $table->decimal(\'lat\', 10, 8)->nullable();
            $table->decimal(\'lng\', 11, 8)->nullable();',
    $c1
);
file_put_contents($f1, $c1);

// 2. Societies
$f2 = $dir . '2026_05_14_224210_create_societies_table.php';
$c2 = file_get_contents($f2);
$c2 = str_replace(
    '$table->id();',
    '$table->id();
            $table->string(\'name\');
            $table->foreignId(\'locality_id\')->constrained(\'localities\')->cascadeOnDelete();
            $table->enum(\'type\', [\'colony\', \'sector\', \'block\', \'enclave\', \'nagar\', \'avenue\', \'phase\', \'road\', \'other\'])->default(\'colony\');
            $table->string(\'landmark\')->nullable();
            $table->decimal(\'lat\', 10, 8)->nullable();
            $table->decimal(\'lng\', 11, 8)->nullable();',
    $c2
);
file_put_contents($f2, $c2);

// 3. Add location to users
$f3 = $dir . '2026_05_14_224211_add_location_to_users_table.php';
$c3 = file_get_contents($f3);
$c3 = preg_replace('/Schema::table\(\'users\', function \(Blueprint \$table\) \{.*?\}\);/s', "Schema::table('users', function (Blueprint \$table) {
            \$table->foreignId('locality_id')->nullable()->constrained('localities')->nullOnDelete();
            \$table->foreignId('society_id')->nullable()->constrained('societies')->nullOnDelete();
            \$table->string('house_no')->nullable();
            \$table->string('full_address')->nullable();
        });", $c3);
$c3 = preg_replace('/public function down\(\): void\s+\{\s+Schema::table\(\'users\', function \(Blueprint \$table\) \{\s+\/\/.*?\}\);\s+\}/s', "public function down(): void
    {
        Schema::table('users', function (Blueprint \$table) {
            \$table->dropForeign(['locality_id']);
            \$table->dropForeign(['society_id']);
            \$table->dropColumn(['locality_id', 'society_id', 'house_no', 'full_address']);
        });
    }", $c3);
file_put_contents($f3, $c3);

// 4. Add location to incidents
$f4 = $dir . '2026_05_14_224212_add_location_to_incidents_table.php';
$c4 = file_get_contents($f4);
$c4 = preg_replace('/Schema::table\(\'incidents\', function \(Blueprint \$table\) \{.*?\}\);/s', "Schema::table('incidents', function (Blueprint \$table) {
            \$table->foreignId('locality_id')->nullable()->constrained('localities')->nullOnDelete();
            \$table->foreignId('society_id')->nullable()->constrained('societies')->nullOnDelete();
        });", $c4);
$c4 = preg_replace('/public function down\(\): void\s+\{\s+Schema::table\(\'incidents\', function \(Blueprint \$table\) \{\s+\/\/.*?\}\);\s+\}/s', "public function down(): void
    {
        Schema::table('incidents', function (Blueprint \$table) {
            \$table->dropForeign(['locality_id']);
            \$table->dropForeign(['society_id']);
            \$table->dropColumn(['locality_id', 'society_id']);
        });
    }", $c4);
file_put_contents($f4, $c4);

// 5. Polls
$f5 = $dir . '2026_05_14_224212_create_polls_table.php';
$c5 = file_get_contents($f5);
$c5 = str_replace(
    '$table->id();',
    '$table->id();
            $table->foreignId(\'zone_id\')->constrained(\'zones\')->cascadeOnDelete();
            $table->foreignId(\'user_id\')->constrained(\'users\')->cascadeOnDelete();
            $table->string(\'question\');
            $table->dateTime(\'expires_at\')->nullable();
            $table->boolean(\'is_active\')->default(true);',
    $c5
);
file_put_contents($f5, $c5);

// 6. Poll Options
$f6 = $dir . '2026_05_14_224213_create_poll_options_table.php';
$c6 = file_get_contents($f6);
$c6 = str_replace(
    '$table->id();',
    '$table->id();
            $table->foreignId(\'poll_id\')->constrained(\'polls\')->cascadeOnDelete();
            $table->string(\'option_text\');',
    $c6
);
file_put_contents($f6, $c6);

// 7. Poll Votes
$f7 = $dir . '2026_05_14_224214_create_poll_votes_table.php';
$c7 = file_get_contents($f7);
$c7 = str_replace(
    '$table->id();',
    '$table->id();
            $table->foreignId(\'poll_id\')->constrained(\'polls\')->cascadeOnDelete();
            $table->foreignId(\'poll_option_id\')->constrained(\'poll_options\')->cascadeOnDelete();
            $table->foreignId(\'user_id\')->constrained(\'users\')->cascadeOnDelete();
            $table->unique([\'poll_id\', \'user_id\']);',
    $c7
);
file_put_contents($f7, $c7);

// 8. Kudos
$f8 = $dir . '2026_05_14_224215_create_kudos_table.php';
$c8 = file_get_contents($f8);
$c8 = str_replace(
    '$table->id();',
    '$table->id();
            $table->foreignId(\'giver_id\')->constrained(\'users\')->cascadeOnDelete();
            $table->foreignId(\'receiver_id\')->constrained(\'users\')->cascadeOnDelete();
            $table->foreignId(\'incident_id\')->nullable()->constrained(\'incidents\')->nullOnDelete();
            $table->string(\'message\', 200)->nullable();
            $table->unique([\'giver_id\', \'incident_id\']);',
    $c8
);
file_put_contents($f8, $c8);

echo "Migrations updated!\n";
