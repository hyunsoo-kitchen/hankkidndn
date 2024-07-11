<template>
    <div class="head_container">
        <div class="head_logo">
            <img class="img-logo" alt="logo" src="../../../public/img/logo.png">
        </div>
        <div class="head_title">한끼든든</div>
        <div></div>
        <div>
            <p>admin0001</p>    
        </div>
        <div>
            <button @click="$store.dispatch('adminLogout')" type="button" >로그아웃</button>
        </div>
    </div>

    <div class="body_container">
        <div class="category">
            <button class="category_btn" @click="$router.push('/admindashboard')">대시보드</button>
            <button class="category_btn" @click="$router.push('/adminnotice?page=1')">공지사항</button>
            <button class="category_btn" @click="$router.push('/adminuserfind')">사용자 관리</button>
            <button class="category_btn" @click="$router.push('/admincontentcontroll')">컨텐츠 관리</button>
            <button class="category_btn" @click="$router.push('/adminad')">광고, 캠페인 관리</button>
        </div>
        <div v-if="!adFlg">
            <div>
                <h2>광고 페이지</h2>
                <button @click="adInsertOn()" type="button">광고 수정</button>
            </div>
            <div>
                <Swiper
            :spaceBetween="30"
            :centeredSlides="true"
            :autoplay="{
            delay: 2500,
            disableOnInteraction: false,
            }"
            :pagination="{
            clickable: true,
            }"
            :navigation="true"
            :modules="modules"
            class="ad-img-container">
                <swiper-slide v-for="(item, key) in $store.state.adImage" :key="key">
                    <img class="ad-img" :src="item.img_path">
                </swiper-slide>
            </Swiper>
            </div>
        </div>
        <div v-if="adFlg" class="cook_list">
            <form id="adDataForm">
                <div class="cook-btn">
                    <h3>광고 수정</h3>
                </div>
                <div v-for="(item, index) in $store.state.adImage" :key="index">
                    <div v-if="item.img_path == ''" class="font-red program-aline">광고 이미지를 넣어주세요.</div>
                    <div class="content_list">
                        <div class="header-box">
                            <p> 광고순서 {{ index + 1 }}</p>
                            <label>
                                <div class="ad-img-btn">이미지 파일</div>
                                <input required hidden :name="'file' + (index + 1)" type="file" accept="image/*" @change="adImg($event, index)" >
                            </label>
                            <button v-if="$store.state.adImage.length > 1" @click="removeAdImgs(index)" class="ad-remove-btn margin-botton" type="button">순서 제거</button>
                        </div>
                        <img v-if="item.img_path" :src="item.img_path" style="margin-bottom: 10px;" class="img_thumb">
                    </div>
                </div>
                <div class="list-input">
                    <button @click="addAdImgs()" class="ad-add-btn" type="button">순서 추가</button>
                </div>
                <div>
                    <button @click="$store.dispatch('adInsert'); adInsertOff()" type="button">저장</button>
                    <button @click="adInsertOff()" type="button" id="cancel">취소</button>
                </div>
            </form>
        </div>
    </div>


</template>
<script setup>
import { ref } from 'vue';
import { onBeforeMount } from 'vue';
import { useStore } from 'vuex';

// 스와이퍼
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';

const modules = [Autoplay, Pagination, Navigation];
const store = useStore();

const adFlg = ref(false);

function addAdImgs(){
    store.state.adImage.push({ img_path: '' });
};

function removeAdImgs(index){
    store.state.adImage.splice(index, 1);
};

// 광고 이미지 미리보기
function adImg(img, index) {

    const file = img.target.files[0];

    // 취소 누를경우 빈배열 생기는걸 방지
    if (!file) return;

    // 선택한 파일의 URL 생성
    const imageUrl = URL.createObjectURL(file);

    store.state.adImage[index].img_path = imageUrl;
}

function adInsertOn() {
    adFlg.value = true;
}

function adInsertOff() {
    adFlg.value = false;
}

onBeforeMount(() => {
    store.dispatch('getAdData');
});

</script>
<style scoped src="../../css/admin_ad.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>