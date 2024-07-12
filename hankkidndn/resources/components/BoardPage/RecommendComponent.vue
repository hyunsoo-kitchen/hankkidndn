<template>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jua&display=swap" rel="stylesheet">
    <div class="main_title">
        <img src="/img/img.ppg.jpg" class="recommend_main_img">
    </div>
    <main>
      <div>
        <CategoryComponent/>
      </div>
    <div class="card">
       <img class="logo" src="../../../public/img/logo.png" alt="">
         <p class="title-line"><span class="side-title">HOT 여름 추천 레시피</span></p>
        <div class="recommend_grid season-container">
            <div @click="$store.dispatch('getRecipeDetail', item.id)" class="center season_img_box" v-for="(item, index) in $store.state.seasonRecommendInfo" :key="index">
                 <div class="image-container"><img class="item-image" :src="item.thumbnail"></div>
                <div class="data-box">
                    <div class="card-title">{{ item.title }}</div>
                    <div class="card-name">{{ item.u_nickname }}</div>
                    <div class="star-view">
                        <div class="card-star">{{ formatDate(item.created_at) }}</div>
                        <div class="card-view">조회수 : {{ item.views }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr> 
        <div class="slider">
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
            class="header-img-container">
                <swiper-slide v-for="(item, key) in $store.state.adImage" :key="key">
                    <img class="header-img" :src="item.img_path">
                </swiper-slide>
          </Swiper>
            <!-- <div class="slide-container">
                <div class="slides">
                    <div class="slide"><img class="slide-img" src="../../../public/img/ad7.png" alt=""></div>
                    <div class="slide"><img class="slide-img" src="../../../public/img/ad9.png" alt=""></div>
                    <div class="slide"><img class="slide-img" src="../../../public/img/ad10.png" alt=""></div>
                </div>
                <button class="prev-button">&lt;</button>
                <button class="next-button">&gt;</button>
                <div class="slide-dots">
                    <span class="dot" data-slide-index="0"></span>
                    <span class="dot" data-slide-index="1"></span>
                    <span class="dot" data-slide-index="2"></span>
                </div>
            </div> -->
        </div>
        <hr>
      <div class="card">  
        <img class="logo" src="../../../public/img/logo.png" alt="">
        <p class="title-line"><span class="side-title">냉장고 털기 추천 레시피</span></p>
        <div class="recommend_grid frige-container">
            <div @click="$store.dispatch('getRecipeDetail', item.id)" class="center frige_img_box" v-for="(item, index) in $store.state.frigeRecommendInfo" :key="index">
                 <div class="image-container"><img class="item-image" :src="item.thumbnail"></div>
                <div class="data-box">
                    <div class="card-title2">{{ item.title }}</div>
                    <div class="card-name">{{ item.u_nickname }}</div>
                    <div class="star-view">
                        <div class="card-star">{{ formatDate(item.created_at) }}</div>
                        <div class="card-view">조회수 : {{ item.views }}</div>
                    </div>
                </div>
            </div>
        </div>
      </div>
        <hr>
      <div class="card">  
        <img class="logo" src="../../../public/img/logo.png" alt="">
        <p class="title-line"><span class="side-title">주간 베스트 레시피</span></p>
        <div class="recommend_grid weeklybest-container">
            <div @click="$store.dispatch('getRecipeDetail', item.id)" class="center season_img_box" v-for="(item, index) in $store.state.weeklybestRecommendInfo" :key="index">
                 <div class="image-container"><img class="item-image" :src="item.thumbnail"></div>
                <div class="data-box">
                    <div class="card-title3">{{ item.title }}</div>
                    <div class="card-name">{{ item.u_nickname }}</div>
                    <div class="star-view">
                        <div class="card-star">{{ formatDate(item.created_at) }}</div>
                        <div class="card-view">조회수 : {{ item.views }}</div>
                    </div>
                </div>
            </div>
        </div>
      </div>  
    </main>
</template>
<script setup>
import { onBeforeMount, ref, onMounted, onBeforeUnmount } from 'vue';
import { useStore } from 'vuex';
import CategoryComponent from '../CommonPage/CategoryComponent.vue';
   // 스와이퍼
   import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';

const modules = [Autoplay, Pagination, Navigation];

  const store = useStore(); // Vuex 스토어 사용  
  const isModalOpen = ref(false);
  const isMobileView = ref(window.innerWidth <= 1044);
  
  // function openModal() {
  //   const hambuger = document.querySelector('#hambuger');
  //   const closeHambuger = document.querySelector('#close-hambuger');
  //   isModalOpen.value = true;
  //   hambuger.style.display = 'none';
  //   closeHambuger.style.display = 'block';
  // }
  
  function closeModal() {
    const hambuger = document.querySelector('#hambuger');
    const closeHambuger = document.querySelector('#close-hambuger');
    isModalOpen.value = false;
    hambuger.style.display = 'block';
    closeHambuger.style.display = 'none';
  }
  
  function handleResize() {
    isMobileView.value = window.innerWidth <= 1044;
    if (!isMobileView.value) {
      closeModal();
    }
  }
  
  onMounted(() => {
    window.addEventListener('resize', handleResize);
    handleResize();
  });
  
  onBeforeUnmount(() => {
    store.dispatch('getAdData');
    window.removeEventListener('resize', handleResize);
  });
  
  // function getRecipeList(categoryId) {
  //   store.dispatch('getRecipeList', categoryId);
  // }
  
  // function getBoardList(categoryId) {
  //   store.dispatch('getBoardList', categoryId);
  // }

onBeforeMount(() => {
    store.dispatch('getSeasonRecommendInfo');
    store.dispatch('getFrigeRecommendInfo');
    store.dispatch('weeklybestRecommendInfo');
    store.dispatch('getAdData');
});

// 날짜 표시 제어
const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ko-KR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).replace(/\.$/, ''); 
};

// 스와이퍼 효과 구현
// document.addEventListener("DOMContentLoaded", () => {
//     const sliders = document.querySelectorAll(".slide-container");

//     sliders.forEach(slider => {
//         const slides = slider.querySelector(".slides");
//         const slideCount = slides.children.length;
//         let currentIndex = 0;
    
//     function showNextSlide() {
//         currentIndex = (currentIndex + 1) % slideCount;
//         slides.style.transform = `translateX(${-currentIndex * 1200}px)`;
//     }

//     setInterval(showNextSlide, 3000); //3초마다 슬라이드 변경]
    
//     // 화면 크기 변경시 슬라이드 위치를 다시 계산
//     window.addEventListener("resize", () => {
//         const slideWidth = slider.offsetWidth;
//         slides.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
//     });
//   });
// });

// 광고 버튼 슬라이드 구현
// document.addEventListener("DOMContentLoaded", function() {
//   const slides = document.querySelector(".slides");
//   const prevButton = document.querySelector(".prev-button");
//   const nextButton = document.querySelector(".next-button");
//   const dots = document.querySelectorAll(".dot");

//   let currentIndex = 0;
//   const slideCount = slides.children.length;
//   const slideWidth = slides.offsetWidth;

//   function showSlide(index) {
//     if (index < 0) {
//       index = slideCount - 1;
//     } else if (index >= slideCount) {
//       index = 0;
//     }
//     currentIndex = index;
//     slides.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
//     updateDots();
//   }

//   function updateDots() {
//     dots.forEach((dot, index) => {
//       if (index === currentIndex) {
//         dot.classList.add("active");
//       } else {
//         dot.classList.remove("active");
//       }
//     });
//   }

//   function handleClickDot(index) {
//     showSlide(index);
//   }

//   prevButton.addEventListener("click", () => {
//     showSlide(currentIndex - 1);
//   });

//   nextButton.addEventListener("click", () => {
//     showSlide(currentIndex + 1);
//   });

//   // dots.forEach(dot => {
//   //   dot.addEventListener("click", () => {
//   //     const slideIndex = Number(dot.getAttribute("data-slide-index"));
//   //     showSlide(slideIndex);
//   //   });
//   dots.forEach((dot, index) => {
//     dot.addEventListener("click", () => {
//       handleClickDot(index);
//     });
//   });

//   // 초기 활성화 설정
//   updateDots();
// });

// 윈도우 리사이즈 이벤트 처리 (반응형 대응)
// window.addEventListener('resize', () => {
//     updateSlidePosition();
// });

</script>
<style scoped src="../../css/recommend.css"></style>