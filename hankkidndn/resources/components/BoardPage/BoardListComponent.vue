<template>
<div class="container">
        <div class="header">
            <img class="main-img" src="../../../public/img/recipe_order.png">
            <div class="ul-list">
                <ul>
                    <li class="line">자유게시판</li>
                    <li class="line">질문게시판</li>
                    <li>문의게시판</li>
                </ul>
            </div>
        </div>
        <div class="main-list">
            <div class="head-title">
                <h3>자유게시판</h3>
                <form action="#">
                    <div class="search-bar">
                        <select name="name-tag" id="name-tag">
                            <option value="title">제목</option>
                            <option value="nickname">닉네임</option>
                        </select>
                        <input type="text">
                        <button type="submit"><img src="../../../public/img/search.png"></button>
                    </div>
                </form>
            </div>
        <div class="text-box-head">
            <div class="list-number">번호</div>
            <div class="list-title">제목</div>
            <div class="list-ninkname">닉네임</div>
            <div class="list-day">등록일</div>
        </div>
        <div class="text-box">
            <div class="list-number">1</div>
            <div class="list-title">이현수</div>
            <div class="list-ninkname">이현수달</div>
            <div class="list-day">2024-06-07</div>
        </div>
        <div class="text-box">
            <div class="list-number">1</div>
            <div class="list-title">이현수</div>
            <div class="list-ninkname">이현수달</div>
            <div class="list-day">2024-06-07</div>
        </div>
        <div class="text-box">
            <div class="list-number">1</div>
            <div class="list-title">이현수</div>
            <div class="list-ninkname">이현수달</div>
            <div class="list-day">2024-06-07</div>
        </div>
        <div class="text-box">
            <div class="list-number">1</div>
            <div class="list-title">이현수</div>
            <div class="list-ninkname">이현수달</div>
            <div class="list-day">2024-06-07</div>
        </div>
        <div class="text-box">
            <div class="list-number">1</div>
            <div class="list-title">이현수</div>
            <div class="list-ninkname">이현수달</div>
            <div class="list-day">2024-06-07</div>
        </div>
        <div class="text-box">
            <div class="list-number">1</div>
            <div class="list-title">이현수</div>
            <div class="list-ninkname">이현수달</div>
            <div class="list-day">2024-06-07</div>
        </div>
        <div class="text-box">
            <div class="list-number">1</div>
            <div class="list-title">이현수</div>
            <div class="list-ninkname">이현수달</div>
            <div class="list-day">2024-06-07</div>
        </div>
        <div class="btn-box">
            <button class="text-btn" type="submit">글쓰기</button>
        </div>
        <div class="number-container">
            <div class="number">1</div>
            <div class="number">2</div>
            <div class="number">3</div>
            <div class="number">4</div>
            <div class="number">5</div>
            <img src="../../../public/img/next.png">
        </div>
        </div>
    </div>
</template>
<script setup>
    
import { onBeforeMount } from 'vue';
import { useStore } from 'vuex';


const store = useStore();

onBeforeMount(() => {
    // 현재 주소 값 획득
    const url = new URL(window.location.href)
    // console.log(url);
    const urlParams = url.searchParams

    // 주소값에서 list의 파라미터 획득
    const num = urlParams.get('list')
    store.dispatch('getBoardList', num)
});
</script>
<style scoped src="../../css/boardlist.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>