<template>
    <!-- 모달 창 -->
    <div class="modal" v-show="modalFlg">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">알림</h3>
                    <button type="button" @click="closeModal" class="close">×</button>
                </div>
                <div class="modal-body">
                    <p>정말로 삭제 하시겠습니까?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="$store.dispatch('recipeDelete', $store.state.recipeData.id)" class="btn btn-primary">삭제</button>
                    <button type="button" @click="closeModal" class="btn btn-primary1">취소</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
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
                    <div :class="{ 'like-btn': $store.state.authFlg }" class="like">
                        <!-- $store.dispatch('recipeLike', $route.params.id); likeToggle($store.state.recipeData) -->
                    <button v-if="$store.state.authFlg" @click="recipeLikeToggle($store.state.recipeData, 'recipeLike')" class="header-like" type="button">
                        <img src="../../../public/img/like.png" alt="">
                    </button>
                    <div class="like_text">좋아요 수 : {{ $store.state.recipeData.likes_num }}</div>
                </div>
                    <div>작성일자 : {{ formatDate($store.state.recipeData.created_at) }}</div>
                    <div class="header-view">조회수 {{ $store.state.recipeData.views }}</div>
                </div>
            </div>
        </div>

        <div v-if="$store.state.userInfo && $store.state.recipeData.user_id == $store.state.userInfo.id" class="btn">
            <button v-if="$store.state.userInfo && $store.state.recipeData.user_id == $store.state.userInfo.id" type="button" class="update" @click="$router.push('/recipe/update/' + $store.state.recipeData.id)">수정</button>
            <button v-if="$store.state.userInfo && $store.state.recipeData.user_id == $store.state.userInfo.id" type="button" @click="openModal()" class="delete">삭제</button>
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
            <iframe class="youtube-video" v-if="$store.state.recipeData.embed_url !== null " width="80%" height="400" align :src="$store.state.recipeData.embed_url"></iframe>
            <div v-else>이 게시글은 동영상이 없습니다.</div>
        </div>

        <div class="profile">
            <div class="profile-title">레시피 작성자</div>
            <img :src="$store.state.recipeData.profile" class="profile-img">
            <div class="profile-name">{{ $store.state.recipeData.u_nickname }}</div>
        </div>

        <h2>댓글</h2>

        <div class="comment-section">
            <!-- 댓글 불러오기 시작 -->
            <div v-if="$store.state.commentData" v-for="(item, index) in $store.state.commentData" :key="index" class="comment">
                <div v-if="commentFlg || item.id !== commentId">
                    <div v-if="!item.deleted_at" class="comment-header">
                        <p class="comment-author">{{ item.u_nickname }}</p>
                        <p class="comment-date">{{ item.created_at }}</p>
                        <div class="btn_grid">
                            <button @click="commentUpdateOn(item.id); cocomentOff()" v-if="$store.state.userInfo && $store.state.userInfo.id == item.user_id" type="button">수정</button>
                            <button @click="$store.dispatch('commentDelete', item.id)" v-if="$store.state.userInfo && $store.state.userInfo.id == item.user_id" type="button">삭제</button>
                        </div>
                    </div>
                    <p v-if="!item.deleted_at" class="comment-content">{{ item.content }}</p>
                    <p v-else>삭제된 댓글 입니다.</p>

                    <!-- 아래 답글 버튼 누를경우 해당 댓글 밑에 입력창 생성 -->
                    <div class="comment-actions" v-show="!item.deleted_at">
                        <button v-if="$store.state.authFlg" type="button" @click="cocomentOn(item.id);" class="comment_actions_btn" v-show="$store.state.authFlg">답글</button>
                        <button v-if="$store.state.authFlg" @click="likeToggle(item, 'boardCommentLike')" type="button" class="like-button"><img src="../../../../hankkidndn/public/img/like.png"></button>
                        <p class="likes_num">좋아요 수 : {{ item.likes_num }}</p>
                        <div class="like_grid">
                        </div>
                    </div>
                </div>
                <!-- 댓글 수정창 -->
                <div v-if="commentUpdateFlg && item.id == commentId" class="comment-form">
                    <form id="boardCommentUpdate">
                        <input autocomplete="off" name="content" type="text" placeholder="댓글" class="comment-input" :value="item.content">
                        <button type="button" @click="$store.dispatch('commentUpdate', item.id); commentUpdateOff();" class="comment-submit">수정</button>
                    </form>
                </div>

                <!-- 대댓글 불러오기 시작 -->
                <div v-for="(item2, index2) in $store.state.cocommentData" :key="index2">
                    <div v-if="item2.cocomment == item.id" class="comment cocomment-padding">
                        <div v-if="item2.id !== cocommentId" class="comment-margin">
                            <div v-if="!item2.deleted_at" class="comment-header">
                                <p class="comment-author">{{ item2.u_nickname }}</p>
                                <p class="comment-date">{{ item2.created_at }}</p>
                                <div class="btn_grid">
                                <button @click="commentUpdateOn(item2.id)" v-if="$store.state.userInfo && $store.state.userInfo.id == item2.user_id" type="button">수정</button>
                                <button @click="$store.dispatch('commentDelete', item2.id)" v-if="$store.state.userInfo && $store.state.userInfo.id == item2.user_id" type="button">삭제</button>
                            </div>
                            </div>
                            <p v-if="!item2.deleted_at" class="comment-content">{{ item2.content }}</p>
                            <p v-else>삭제된 댓글 입니다.</p>
                            <div v-if="!item2.deleted_at" class="comment-actions">
                                <button v-if="$store.state.authFlg" @click="likeToggle(item2, 'boardCommentLike')" type="button" class="like-button"><img src="../../../../hankkidndn/public/img/like.png"></button>
                                <p>좋아요 수 : {{ item2.likes_num }}</p>
                            </div>
                        </div>

                        <!-- 대댓글 수정창 -->
                        <div v-if="commentUpdateFlg && item2.id == cocommentId" class="comment-form">
                            <form id="boardCommentUpdate">
                                <input autocomplete="off" name="content" type="text" placeholder="댓글" class="comment-input" :value="item2.content">
                                <button type="button" @click="$store.dispatch('commentUpdate', item2.id); commentUpdateOff();" class="comment-submit">수정</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 대댓글 입력 칸 -->
                <div v-if="cocomentFlg && item.id == cocommentId" class="comment-form">
                    <form id="boardCocomment" class="cocomment-box">
                        <input type="hidden" name="recipe_board_id" :value="route.params.id">
                        <input name="content" autocomplete="off" type="text" placeholder="답글" class="comment-input" v-model="cocomment">
                        <button type="button" @click="$store.dispatch('cocomentInsert', item.id), cocomment = '', cocomentOff()" class="comment-submit">답글</button>
                    </form>
                </div>
            </div>
            
            <!-- 댓글 입력창 -->
            <form id="boardComment">
                <div v-if="$store.state.authFlg" class="comment-form">
                    <input autocomplete="off" @click="cocomentFlg = false" type="text" name="content" placeholder="댓글" class="comment-input" required v-model="comment">
                    <button type="button" @click="$store.dispatch('commentRecipeInsert', $route.params.id), comment = '';" class="comment-submit">댓글</button>
                </div>
                <div v-else class="comment-form">
                    <div class="comment-input">로그인 후 댓글을 작성해주세요</div>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import { onBeforeMount, ref} from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();
const modalFlg = ref(false);
const likeFlg = ref(true);

// 댓글 관련
const comment = ref('');
const commentId = ref();
const cocommentId = ref();
const cocomment = ref('');
const commentFlg = ref(true);
const cocomentFlg = ref(false);

// 댓글 수정
const commentUpdateFlg = ref(false);

function openModal() {
    modalFlg.value = true
}

function closeModal() {
    modalFlg.value = false
}

// 답글 창 생성 기능
function cocomentOn(id) {
    cocommentId.value = id;
    cocomentFlg.value = true;
}

// 답글 창 취소 기능
function cocomentOff() {
    cocomentFlg.value = false;
}

// 댓글 수정창 생성 기능
function commentUpdateOn(id) {
    commentUpdateFlg.value = true;
    commentFlg.value = false;
    cocommentId.value = id;
    commentId.value = id;
}

function commentUpdateOff() {
    commentUpdateFlg.value = false;
    commentFlg.value = true;
    cocommentId.value = null;
}

// 좋아요 기능
function likeToggle(data, action) {
    if(likeFlg.value) {
        likeFlg.value = false;

        store.dispatch(action, data.id)
    
        if(data.like_chk == 1) {
            data.like_chk = 0;
            data.likes_num--;
        } else {
            data.like_chk = 1;
            data.likes_num++;
        }

        setTimeout(() => {
                likeFlg.value = true;
            }, 1000);
    }
}

function recipeLikeToggle(data, action) {
    if(likeFlg.value) {
        likeFlg.value = false;

        store.dispatch(action, data.id)

        setTimeout(() => {
                likeFlg.value = true;
            }, 1000);
    }
}

onBeforeMount(() => {
    store.dispatch('getRecipeDetail', route.params.id);
    // store.dispatch('recipeViewUp', route.params.id)
    // console.log(store.state.recipeStuff)
})

// 시간 표시 제어
const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('ko-KR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    }).replace(/\.$/, '');  // 마지막 점 제거
};
</script>

<style scoped src="../../css/recipedetail.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>