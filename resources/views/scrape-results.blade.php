<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrape Results</title>
</head>
<body>
    <h1>{{ $data['title'] }}</h1>
    <p>{{ $data['description'] }}</p>
    <div>
        @foreach($data['images'] as $image)
            <img src="{{ $image }}" alt="Image" style="max-width: 200px;">
        @endforeach
    </div>
</body>
</html>