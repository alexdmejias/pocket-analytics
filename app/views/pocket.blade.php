<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>


{{$data['count']}}
<ol>
@foreach ($data['list'] as $key)
    <li>{{$key->given_title}}</li>
@endforeach
</ol>
</body>
</html>