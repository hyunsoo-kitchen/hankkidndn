<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- 헤더안에 csrf 토큰생성 --}}
    {{-- <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script> --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jua&display=swap" rel="stylesheet">
    <title>Hankkidndn</title>
</head>
<body>
    <div id = "app">
        <App-Component></App-Component>
    </div>
</body>
</html>