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
    <link rel="icon" href="{{ asset('img/bowl.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Jua&display=swap" rel="stylesheet">
    <title>Hankkidndn</title>
</head>
<body>
    <div id = "app">
        <App-Component></App-Component>
    </div>
    <script>
        document.addEventListener('keydown', function(event) { // 키를 누를 때 이벤트를 실행함
            if (event.keyCode === 13) { // 키 코드 13번은 엔터키
                event.preventDefault(); // 해당 이벤트 취소
            };
        }, true);
    </script>
</body>
</html>