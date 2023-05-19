<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Game Results</title>
    <style>
        body {
            margin-top: 20px;
            margin-left: 20px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    @foreach ($results as $result)
        {{ $result }} <br>
    @endforeach
</body>
</html>