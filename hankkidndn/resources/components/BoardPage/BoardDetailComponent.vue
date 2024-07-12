<template>
    <!-- 블라인드 처리 모달 창 -->
    <div class="modals" v-if="$store.state.boardDetail.blind_flg == 1">
        <img src="../../../public/img/경냥이.png" class="cat-image">
        <div class="modal-contents">
        <p>해당 게시물은 신고로 인해 블라인드 처리 됐습니다.</p>
        <p>게시물을 확인하시려면 확인 아니면 취소를 눌러주세요.</p>
        <div class="modal-buttons">
            <button type="button" @click="$store.state.boardDetail.blind_flg = 0">확인</button>
            <button type="button" @click="$router.back()">취소</button>
        </div>
        </div>
    </div>

    
    
    <!-- 삭제 모달 창 -->
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
                    <button type="button" @click="$store.dispatch('boardDelete', $store.state.boardDetail.id)" class="btn btn-primary">삭제</button>
                    <button type="button" @click="closeModal" class="btn btn-primary1">취소</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 중복신고 방지 모달 창 -->
    <div class="modal" v-show="$store.state.reportFailFlg">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">알림</h3>
                    <button type="button" @click="$store.state.reportFailFlg = false" class="close">×</button>
                </div>
                <div class="modal-body">
                    <p>신고는 한번만 가능합니다.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="$store.state.reportFailFlg = false" class="btn btn-primary1">확인</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 신고 접수 모달 창 -->
    <div class="modal" v-show="$store.state.reportSuccessFlg">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">알림</h3>
                    <button type="button" @click="$store.state.reportSuccessFlg = false" class="close">×</button>
                </div>
                <div class="modal-body">
                    <p>신고가 접수되었습니다.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="$store.state.reportSuccessFlg = false" class="btn btn-primary1">확인</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 신고 모달 창 -->
    <div class="modal" v-show="reportFlg">
        <form id="boardReportForm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">알림</h3>
                        <button type="button" @click="reportModalOff()" class="close">×</button>
                    </div>
                    <select name="report_type">
                        <option value="1">욕설, 비방, 차별, 혐오</option>
                        <option value="2">홍보, 영리 목적</option>
                        <option value="3">불법 정보</option>
                        <option value="4">음란, 청소년 유해</option>
                        <option value="5">개인 정보 노출, 유포, 거래</option>
                        <option value="6">도배, 스팸</option>
                        <option value="7">기타</option>
                    </select>
                    <div class="modal-body">
                        <textarea name="content" v-model="reportContent" required placeholder="신고내용을 100자 이내로 작성해주세요."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="$store.dispatch('boardReport', $store.state.boardDetail.id); reportModalOff() " class="btn btn-primary">신고</button>
                        <button type="button" @click="reportModalOff()" class="btn btn-primary1">취소</button>
                    </div>
                </div>
            </div>
        </form> 
    </div>

    <!-- 댓글 신고 모달 창 -->
    <div class="modal" v-show="commentReportFlg">
        <form id="commentReportForm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">알림</h3>
                        <button type="button" @click="commentReportModalOff()" class="close">×</button>
                    </div>
                    <select name="report_type">
                        <option value="1">욕설, 비방, 차별, 혐오</option>
                        <option value="2">홍보, 영리 목적</option>
                        <option value="3">불법 정보</option>
                        <option value="4">음란, 청소년 유해</option>
                        <option value="5">개인 정보 노출, 유포, 거래</option>
                        <option value="6">도배, 스팸</option>
                        <option value="7">기타</option>
                    </select>
                    <div class="modal-body">
                        <textarea name="content" v-model="reportContent" required placeholder="신고내용을 100자 이내로 작성해주세요."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="$store.dispatch('commentReport', commentReportId); commentReportModalOff() " class="btn btn-primary">신고</button>
                        <button type="button" @click="commentReportModalOff()" class="btn btn-primary1">취소</button>
                    </div>
                </div>
            </div>
        </form> 
    </div>

    <!-- 게시글 불러오기 시작 -->
    <div class="container">
        <div class="main_list">
            <div class="main_title">
                <h2 class="title_name">{{ getBoardName($store.state.boardDetail.boards_type_id) }}</h2>
                <div class="buttons">
                    <div>
                        <button v-if="$store.state.userInfo && $store.state.boardDetail.user_id == $store.state.userInfo.id" type="button" class="update" @click="$router.push('/board/update/' + $store.state.boardDetail.id)">수정</button>
                        <button v-if="deleteBtn($store.state.boardDetail.user_id)" type="button" @click="openModal()" class="delete">삭제</button>
                        <button type="button" v-if="$store.state.authFlg" class="report" @click="reportModalOn()">신고</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="main_title_content">
                <div class="main_title_grid">
                <h2>{{ $store.state.boardDetail.title }}</h2>
                <div class="main_view">조회수 : {{ $store.state.boardDetail.views }}</div>
            </div>
                <div class="main_title_content_title">
                    <p>{{ formatDate($store.state.boardDetail.created_at) }}</p>
                    <p class="name">{{ $store.state.boardDetail.u_nickname }}</p>
                </div>
                <hr>
                <div class="main_content">
                    <div class="image-container">
                        <img v-for="(item, index) in $store.state.boardImg" :key="index" :src="item.img_path">
                    </div>
                    <p>{{ $store.state.boardDetail.content }}</p>
                </div>
                <h2>댓글 : {{ $store.state.commentCount }}</h2>

                <!-- 댓글 불러오기 시작 -->
                <div class="comment-section">
                    <div v-if="$store.state.commentData" v-for="(item, index) in $store.state.commentData" :key="index" class="comment">
                        <div v-if="commentFlg || item.id !== commentId">
                            <div class="comment-content" v-if="item.blind_flg == 1">
                                <div>해당 댓글은 신고로인해 블라인드 처리 됐습니다.</div>
                                <button type="button" @click="item.blind_flg = 0">확인하기</button>
                            </div>
                            <div v-else-if="!item.deleted_at" class="comment-header">
                                <p class="comment-author">{{ item.u_nickname }}</p>
                                <p class="comment-date">{{ item.created_at }}</p>
                                <div class="btn_grid">
                                    <button @click="commentUpdateOn(item.id)" v-if="$store.state.userInfo && $store.state.userInfo.id == item.user_id" type="button">수정</button>
                                    <button @click="$store.dispatch('commentDelete', item.id)" v-if="commentDeleteBtn(item.user_id)" type="button">삭제</button>
                                    <button type="button" v-if="$store.state.authFlg" @click="commentReportModalOn(item.id)">신고</button>
                                </div>
                                <p class="comment-content">{{ item.content }}</p>
                            </div>
                            <p v-else>삭제된 댓글 입니다.</p>
    
                            <!-- 아래 답글 버튼 누를경우 해당 댓글 밑에 입력창 생성 -->
                            <div class="comment-actions" v-show="!item.deleted_at && item.blind_flg != 1">
                                <button v-if="$store.state.authFlg " type="button" @click="cocomentOn(item.id)" class="comment_actions_btn">답글</button>
                                <div class="comment-like">
                                    <button v-if="$store.state.authFlg" @click="likeToggle(item, 'boardCommentLike')" type="button" class="like-button"><img src="../../../../hankkidndn/public/img/like.png"></button>
                                    <p class="likes_num">좋아요 수 : {{ item.likes_num }}</p>
                                    <div class="like_grid">
                                    </div>
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
                                <div v-if="item2.id !== cocommentId" class="comment_margin">
                                    <div class="comment-content" v-if="item2.blind_flg == 1">
                                        <div>해당 댓글은 신고로인해 블라인드 처리 됐습니다.</div>
                                        <button type="button" @click="item2.blind_flg = 0">확인하기</button>
                                    </div>
                                    <div v-else-if="!item2.deleted_at" class="comment-header">
                                        <p class="comment-author">{{ item2.u_nickname }}</p>
                                        <p class="comment-date">{{ item2.created_at }}</p>
                                        <div class="btn_grid">
                                            <button @click="commentUpdateOn(item2.id)" v-if="$store.state.userInfo && $store.state.userInfo.id == item2.user_id" type="button">수정</button>
                                            <button @click="$store.dispatch('commentDelete', item2.id)" v-if="commentDeleteBtn(item2.user_id)" type="button">삭제</button>
                                            <button type="button" v-if="$store.state.authFlg" @click="commentReportModalOn(item2.id)">신고</button>
                                        </div>
                                        <p class="comment-content">{{ item2.content }}</p>
                                    </div>
                                    <p v-else>삭제된 답글 입니다.</p>
                                    <div v-if="!item2.deleted_at" class="comment-actions">
                                        <div class="comment-like">
                                            <button v-if="$store.state.authFlg" @click="likeToggle(item2, 'boardCommentLike')" type="button" class="like-button"><img src="../../../../hankkidndn/public/img/like.png"></button>
                                            <p>좋아요 수 : {{ item2.likes_num }}</p>
                                        </div>
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
                                <input type="hidden" name="board_id" :value="route.params.id">
                                <input name="content" autocomplete="off" type="text" placeholder="답글" class="comment-input" v-model="cocomment">
                                <button type="button" @click="$store.dispatch('cocomentInsert', item.id), cocomment = '', cocomentOff()" class="comment-submit">답글</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- 댓글 입력창 -->
                    <form id="boardComment">
                        <div v-if="$store.state.authFlg " class="comment-form">
                            <input autocomplete="off" @click="cocomentFlg = false" type="text" name="content" placeholder="댓글" class="comment-input" required v-model="comment">
                            <button type="button" @click="$store.dispatch('commentInsert', data.id), comment = '';" class="comment-submit">댓글</button>
                        </div>
                        <div v-else class="comment-form">
                            <div class="comment-input">로그인 후 댓글을 작성해주세요</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();

const likeFlg = ref(true);

// 댓글 관련
const comment = ref('');
const commentId = ref();
const cocommentId = ref();
const cocomment = ref('');
const commentFlg = ref(true);
const cocomentFlg = ref(false);

// 신고 관련
const reportFlg = ref(false);
const commentReportFlg = ref(false);
const commentReportId = ref('');
const reportContent = ref('');

// 댓글 수정
const commentUpdateFlg = ref(false);

// 삭제 모달
const modalFlg = ref(false);
const data = reactive({
    board_type: null,
    id: route.params.id,
});

// 삭제 모달 제어
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
            }, 500);
    }
}


onBeforeMount(() => {
    store.dispatch('getBoardDetail', data.id)
    store.dispatch('getBoardCountComment', data.id)
});

// 게시판 이름 설정
function getBoardName(id) {
      switch (parseInt(id)) {
        case 6:
          return '공지게시판';
        case 7:
          return '자유게시판';
        case 8:
          return '질문게시판';
        case 9:
          return '문의게시판';
    }
}

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

// 신고 모달
function reportModalOn() {
    reportFlg.value = true;
}

function reportModalOff() {
    reportFlg.value = false;
}

// 댓글 신고 모달
function commentReportModalOn(id) {
    commentReportFlg.value = true;
    commentReportId.value = id
}

function commentReportModalOff() {
    commentReportFlg.value = false;
    reportContent.value = '';
}

// 게시글 삭제버튼 if 검사
function deleteBtn(id) {
    if(store.state.userInfo && id == store.state.userInfo.id) {
        return true;
    } else if (store.state.adminFlg) {
        return true;
    } else {
        return false;
    }
}

// 댓글 삭제버튼 if 검사
function commentDeleteBtn(id) {
    if(store.state.userInfo && store.state.userInfo.id == id) {
        return true;
    } else if (store.state.adminFlg) {
        return true;
    } else {
        return false;
    }
}

</script>
<style scoped src="../../css/boarddetail.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>
