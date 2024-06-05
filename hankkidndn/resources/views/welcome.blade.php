<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- 헤더안에 csrf 토큰생성 --}}
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <script src="{{ asset('js/app.js') }}" defer></script>
    <title>Hankkidndn</title>
</head>
<body>
    <div id = "app">
        <App-Component></App-Component>
    </div>
</body>
</html>