<?php
// Simple CLI/browser demo using Src\LangClass
require __DIR__ . '/../src/LangClass.php';

$dsn = 'mysql:host=127.0.0.1;dbname=your_database;charset=utf8mb4';
$user = 'db_user';
$pass = 'db_password';

$lang = $argv[1] ?? 'en';
$lc = new \App\Src\LangClass($dsn, $user, $pass, $lang, 'tr');

// print some example values
echo "Current locale: $lang\n";
echo "app.name = " . $lc->get('app.name', $lang) . "\n";
echo "app.welcome = " . $lc->get('app.welcome', $lang) . "\n";
echo "Button start = " . $lc->get('button.start', $lang) . "\n";

// list group
$group = $lc->group('app', $lang);
foreach ($group as $k => $v) {
    echo "$k => $v\n";
}
