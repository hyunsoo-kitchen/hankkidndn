<template>
  <div class="container">
        <div v-if="modalFlg" class="delete-modal">
            <div class="modal-title">정말로 삭제 하시겠습니까?</div>
            <div class="delete-btn">
                <button type="button" @click="$store.dispatch('recipeDelete', $store.state.recipeData.id)">삭제</button>
                <button type="button" @click="closeModal()">취소</button>
            </div>
        </div>
        <div class="header">
            <div class="header-img-wrapper">
                <img class="header-img" :src="$store.state.recipeData.thumbnail">
            </div>
            <div class="header-info">
                <div class="header-userinfo">
                    <img class="header-profile" :src="$store.state.recipeData.profile">
                    <div class="header-name">{{ $store.state.recipeData.u_nickname }}</div>
                </div>
                <div class="header-actions">
                    <div class="like">
                    <button v-if="$store.state.authFlg" @click="$store.dispatch('recipeLike', $route.params.id); likeToggle($store.state.recipeData)" class="header-like" type="button">
                        <img src="../../../public/img/like.png" alt="">
                    </button>
                    <div class="like_text">{{ $store.state.recipeData.likes_num }}</div>
                </div>
                    <div class="header-view">조회수 {{ $store.state.recipeData.views }}</div>
                </div>
            </div>
        </div>

        <div v-if="$store.state.userInfo && $store.state.recipeData.user_id == $store.state.userInfo.id" class="btn">
            <button type="button" class="update" @click="$router.push('/recipe/update/' + $store.state.recipeData.id)">수정</button>
            <button type="button" @click="openModal()" class="delete">삭제</button>
        </div>
        
        <div class="explain">
            <div class="explain-title">{{ $store.state.recipeData.title }}</div>
            <div>{{ $store.state.recipeData.content }}</div>
        </div>

        <div class="stuff">
            <div class="stuff-title">재료</div>
            <div class="stuff-all" v-for="(item, index) in $store.state.recipeStuff" :key="index">
                <div class="stuff-name">{{ item.stuff }}</div>
                <div class="stuff-gram">{{ item.stuff_gram }}</div>
            </div>
        </div>
        <div class="line"></div>
        
        <div class="recipe" v-for="(item, index) in $store.state.recipeProgram" :key="index" >
            <img class="recipe-img" :src="item.img_path">
            <div class="recipe-order">과정순서 {{ item.order }}</div>
            <div class="recipe-content">{{ item.program_content }}</div>
        </div>

        <div class="video">
            <iframe width="560" height="315" :src="store.state.recipeData.embed_url" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

        <div class="profile">
            <div class="profile-title">레시피 작성자</div>
            <img :src="$store.state.recipeData.profile" class="profile-img">
            <div class="profile-name">{{ $store.state.recipeData.u_nickname }}</div>
        </div>

        <div class="comments">
            <div class="comments-title">요리후기 : 댓글수</div>
            <div class="line"></div>
            <div class="comment-container">
                <div class="comments-detail">
                    <img class="comment-img" src="" alt="">
                    <span class="comment-name">홍길동</span>
                    <span class="comment-date">2024-06-11 02:33</span>
                    <div class="comment-content">댓글내용</div>
                    <div class="comment-retouch">
                        <button>수정</button>
                        <button>삭제</button>
                    </div>
                    <div class="comment-reply">
                        <button class="comment-reply-btn">답글</button>
                    </div>
                </div>
            </div>
            <div class="comment-input">
                <textarea class="comment-input-content" name="" id=""></textarea>
                <button class="comment-input-btn">입력</button>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onBeforeMount, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();
const modalFlg = ref(false);

function openModal() {
    modalFlg.value = true
}

function closeModal() {
    modalFlg.value = false
}

// 좋아요 기능
function likeToggle(recipeData) {
    
  if(recipeData.like_chk == 1) {
    recipeData.like_chk = 0;
    recipeData.likes_num--;
  } else {
    recipeData.like_chk = 1;
    recipeData.likes_num++;
  }
}

onBeforeMount(() => {
    store.dispatch('getRecipeDetail', route.params.id);
})
</script>
<style scoped src="../../css/recipedetail.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>