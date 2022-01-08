{{--<h1>Login Details</h1>--}}
{{--<p>{{$fname}}</p><br>--}}
{{--<p>{{$lname}}</p><br>--}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">
    @foreach($results as $values)
        {{$values}};
    @endforeach
</div>
</body>
</html>
