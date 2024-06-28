<!-- 일단 음.. 이론부터 빠르게 정리해보자
 
라라벨 Route란?
웹 애플리케이션의 URL을 처리하고 해당 URL에 대한 요청을
적절한 컨트롤러 또는 클로저에 매핑하는 방법을 정의

Method에 따른 Route 등록
 Route::get($url, $callback);
 Route::post($url, $callback);
 Route::put($url, $callback);
 patch 도 있고 delete options도 있는데
 주로 get이랑 post 사용함.

 //문자열 리턴
 Route::get('/hi', function() {
 return '안녕하세요.';})

 //뷰 리턴
 Route::get('/home', function()
    return view('home');

// 파라미터 제어
HTTP요청에 대한 정보를 담고 있는 Request $request 객체에서 파라미터
획득 가능

Route::get('/query', function(Request $request) {
return $request->input('id').",".$request->input('name');
})

컨트롤러 매핑
Route::HTTPMethod('/test', [컨트롤러명::class, 액션명])
Route::get('/test', [TestController::class, 'index']);

class TestController extends Controller
{
    function index() {
        return view('test')
    }
}

Controller란?
주로 비즈니스 로직을 담당하고, 모델(Model)과 뷰(View)를 중개하여
각 컨트롤러는 app/Http/Controllers에 위치

컨트롤러 매핑
Route::get('/login', [UserController::class, 'showLogin'])->name(login.show);

class UserController extends Controller
{
    function showLogin() {
        return view('login');
    }
}

Resource 옵션으로 컨트롤러 생성 시, 컨트롤러 매핑
Route::resource('/board', BoardController::class);

class BoardController extends Controllers
{
    public function index()
    {

    }
    public function create()
    {
    
    }
    public function store(Request $request)
    {
    
    }
    public function show($id)
    {
    
    }
    public function edit($id)
    {
    
    }
    public function update(Requset $request, $id)
    {
    
    }
    public function destroy($id)
    {
    
    }
}

CSRF 방지
라라벨은 세션마다 CSRF 토큰을 자동으로 생성하고, 이 토큰으로 인증된 사용자가 실제로 애플
리케이션에서 요청을 했는지 확인

POST 요청과 함께 넘어온 CSRF 토큰으로 CSRF 방지
POST, PUT, PATCH, DELETE 폼을 만들 때 _token 명칭을 가진 hidden 타입의
입력 필드를 포함시켜 CSRF 보호 미들웨어가 요청을 확인

Blade 지시문 @csrf로 간단히 구현 가능

<body>
    <h1>HOME!!!!</h1>
    <br>
    <br>
    {{---POST---}}
    <form action="/home" method="POST">
    @csrf
    <button type="submit">POST</button>
    </form>

    X-CSRF-TOKEN 헤더로 CSRF 방지
</body>

CSRF 공격
CSRF란?
공격자가 희생자의 권한을 도용하여 특정 웹 사이트의 기능을 실행할 수 있는 취약점
CSRF는 아래의 조건을 만족할 경우 공격이 가능
-희생자가 위조 요청을 보낼 사이트에 로그인 중
-희생자가 공격자가 만든 피싱 사이트에 접속 또는 악성 스크립트 실행을 유도
주로 계정 정보를 탈취해 광고글 작성, 개인정보 탈취, 계정 권한 탈취로 서버 데이터 유출 등의
위험성이 존재

CSRF 기본 대응 방법
Referrer 검증법
-request의 header에 담겨있는 referrer 값을 확인하여 같은 도메인에서 보낸
요청인지 검증하여 차단하는 방법
-동일 사이트 내에서 XSS 취약점이 발견된다면 이를 통하여 CSRF 공격을 실행
가능하므로 주의
CSRF Token 사용
-요청이 들어올 때 마다 서버에서 세션에 저장된 값과 요청으로 전송된 값이 일치하는지 검증
하여 방어
- referrer 검증법과 같이 XSS를 통한 CSRF 공격에 취약하므로 주의

View란?
View는 모든 HTML을 별도의 파일에 배치할 수 있는 편리한 방법을 제공
애플리케이션 로직을 프레젠테이션 로직과 분리
Blade Template을 이용해서 작성

View에 데이터 전달
-with() 메서드는 뷰에 데이터를 전달하는 데 사용
    - with(변수명,값)
      해당 값을 가진 변수를 전달
    - with(배열)
      복수의 데이터를 전달 하고 싶을 경우는 배열로 전달
- 뷰에서는 전달할 때의 변수명으로 php 변수로써 사용
- 일반적으로 리다이렉션 또는 뷰를 반환하는 컨트롤러 메서드 내에서 사용

// 하나의 데이터만 전달할 경우
Route::get('/', function() {
    $arr = [
        'name' => '홍길동'
        ,'age' => 130
        ,'gender' => '1'
        ];
        return view('layout.layout')->with('errMsg', '에러 발생');
    });

// 복수의 데이터를 전달할 경우
Route::get('/', function () {
    $arr = [
        'name' => '홍길동'
        ,'age' => 130
        ,'gender' => '1'
    ];
    return view('layout.layout')->with(['data' =>$arr, 'errMsg' => '에러 발생']);
});

route/web.php


<body>
    <h1>login</h1>
    <h3>ERROR : {{$errMsg}}</h3>
    <br>
</body>
resources/views/login.blade.php

Blade Template 이란?
- 라라벨에 포함된 단순하지만 강력한 템플릿 엔진
- 블레이트 템플릿 구문이 php 코드로 컴파일되어 동작
- 블레이드 지시어를 통해 템플릿 상속 및 데이터 표시, PHP 제어 구조에 대해 편의성 제공
- 파일 확장자는 .blade.php를 사용
- 일반적으로 파일은 resources/views 디렉토리에 배치

Route::get('/', function() {
    return view('layout.layout')->with('name', '홍길동');
});

@include(뷰, [, 배열])
-다른 뷰를 포함
-include할 뷰에 데이터를 보내고 싶을 경우 두번째 아규먼트에 배열 셋팅


뷰 -> 컴포넌트 이벤트(Component)이란?
- $emit 메소드를 사용하여 템플릿 표현식에서 직접 사용자 정의 이벤트를
발생시켜 부모 컴포넌트와 자식컨테이너간에 이벤트를 수신 및 발신
- 일반적으로 자식 컴포넌트에서 부모 컴포넌트의 데이터를 수정하고 싶을 때 사용


--------------- Vue.js -----------------
Vue.js란?
사용자 인터페이스를 구축하기 위한 JavaScript 프레임워크

Lifecycle Hooks

Lifecycle 등록
 -> 사용할 라이프사이클을 import 후, 해당 메소드를 정의 
<template>
 <br><br><br><br><br><br>
 <h1>라이프 사이클</h1>
</template>

<script setup>
import { onBeforeMount, onMounted} from 'vue';

onBeforeMount(() => {
 alert('마운트 전');
 });

 onMounted(() => {
 alert('마운트 후');
 });
 </script>

 <style>
  #app {
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
  }
 </style>
 ---------------------------------------------------------------
 <template>
    <img src="">
    <div>카운트 : {{ state.cnt }}</div>
    <button @click="incrementNum">1증가</button>
    <br>
    <br>
    <div>{{ state.infoMsg }}</div>
 </template>
 <script setup>
 import { onMounted, reactive } form 'vue';

 const state = reactive({
  cnt: 0,
  infoMsg: '',
 });
 function incrementNum() {
   state.cnt++;
 }
 onMounted(() => {
  state.infoMsg = '버튼을 눌러 1씩 증가시키세요.';
 })
 </script>

데이터 바인딩 (Data Binding)이란?
- HTML 요소와 Vue 인스턴스의 데이터를 동적으로 연결하는 기능
- 데이터의 변화에 따라 화면이 자동으로 업데이트되어 사용자에게 더 나은 상호작용을 제송
- Options API에서는 data옵션을 사용


????????????????????????????????
 export default {
 data() {
   return {
    cnt: 0
   }
},
 methods: {
  printCnt() {
    console.log(this.cnt); //0
    this.cnt++;
    console.log(this.cnt); // 1
    }
 },
 mounted() {
   this.printCnt();
 }

 - Composition API에서는 ref()와 reactive() 함수를 사용

ref()
타입제한 없이 사용가능하나 일반적으로 string, number, boolean 과 같은 기본유형에
대한 반응적 참조를 위해 사용
기본 유형에 대해 더 나은 성능을 제공
생성한 개체의 value 속성을 사용하여 값에 접근하고 업데이트

import {ref} from 'vue';

const cnt = ref(0);
console.log(cnt.value); //0

cnt.value++;
console.log(cnt.value); //1

reactive()
객체 타입만 사용 가능하며, 해당 객체에 대한 반응적 참조를 위해 사용
객체에 대해 더 나은 성능을 제공

import {reactive} from 'vue';

const info = reactive({
    name: "홍길동"
    ,age: 20
});
console.log(info.name); // 홍길동

info.name = '김철수';
console.log(info.name); // 김철수


조건부 렌더링
- 일반적으로 v-if는 전환 비용이 더 높고, v-show는 초기 렌더링 비용이 더 높다.
- 자주 전환해야 하는 겨우 v-show, 자주 전환되지 않는 경우 v-if를 사용하는 것이 좋다.

v-if
<template>
 <h1 v-if="flg === '0'">0 입니다.</h1>
 <h1 v-else-if="flg === '1'">1 입니다.</h1>
 <h1 v-else>기타 입니다.</h1>
 <input v-modal="flg" type="text" name="flg" id="flg">
</template>

<script setup>
import {ref} from 'vue';

const flg = ref('0');

</script>

<style>
  #app {
   text-align: center;
   color: #2c3e50;
   margin-top: 60px;
 }
</style>

리스트 렌더링(List Rendering)이란?
- vue의 반복문으로 v-for 디렉티브를 사용하여 배열을 리스트로 렌더링
- v-for="값 in 데이터" 또는  v-for="(값, 키) in 데이터"로 정의하여 사용
- 반복하는 각 요소에 대한 고유 식별자를 제공해야 하므로, :key 디렉티브 작성 필요
 -> :key 디렉티브에서의 key는 반복하는 데이터의 key와는 다른것이므로 주의


 리스트 렌더링 (List Rendering) 예제

 <template>
  <div v-for="val in 5" :key="val">
   <p>{{ val }}</p>
  </div>
 </template>

 <script setup>
 </script>

 <style>
 #app {
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
 }
 </style>
 

음.. 일단
 

-->