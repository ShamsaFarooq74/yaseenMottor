<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$mailData['title']}}</title>
</head>
<body>
	<h3>{{$mailData['title']}}</h3><br>
	<p>{!!$mailData['body']!!}</p>
	<br><br>
	{{'Viper Software House'}}<br>
	{{'Contact : +123456789'}}<br>
	{{'Address : Lahore, Pakistan'}}<br>
</body>
</html>