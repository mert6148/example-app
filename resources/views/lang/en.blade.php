<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Application - English</title>
    <link rel="stylesheet" href="/lang/en/style.css">
</head>
<body>
    @php echo file_get_contents(base_path('lang/en/index.html')) ?? '' @endphp
    <script src="/lang/en/script.js"></script>
</body>
</html>
