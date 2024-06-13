<template>
    <!-- Header -->
    <header>
        <div class="nav-container">
            <div @click="openModal" id="hambuger" :style="hambuger"></div>
            <div @click="closeModal" id="close-hambuger" :style="closeHambuger"></div>
            <nav v-if="!isMobileView" id="nav-list">
                <ul>
                    <li><a href="#">추천</a></li>
                    <li class="dropdown">
                        <a href="#">레시피</a>
                        <ul class="dropdown-content">
                            <li><a @click="$router.push('/recipelist')">한식</a></li>
                            <li><a href="#">중식</a></li>
                            <li><a href="#">양식</a></li>
                            <li><a href="#">일식</a></li>
                            <li><a href="#">베이킹</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#">게시판</a>
                        <ul class="dropdown-content">
                            <li><a href="#">공지사항</a></li>
                            <li><a href="#">자유게시판</a></li>
                            <li><a href="#">질문게시판</a></li>
                        </ul>
                    </li>
                    <li><a href="#">이벤트</a></li>
                </ul>
            </nav>
        </div>
        <nav v-if="isModalOpen" class="hambuger-nav-list">
            <ul class="dropdown-content">
                <li class="dropdown-content-li"><a href="#">추천</a></li>
                <hr>
                <li @click="$router.push('/recipelist')" class="dropdown-content-li">한식</li>
                <li class="dropdown-content-li"><a href="#">중식</a></li>
                <li class="dropdown-content-li"><a href="#">양식</a></li>
                <li class="dropdown-content-li"><a href="#">일식</a></li>
                <li class="dropdown-content-li"><a href="#">베이킹</a></li>
                <hr>
                <li class="dropdown-content-li"><a href="#">공지사항</a></li>
                <li class="dropdown-content-li"><a href="#">자유게시판</a></li>
                <li class="dropdown-content-li"><a href="#">질문게시판</a></li>
                <hr>
                <li class="dropdown-content-li"><a href="#">이벤트</a></li>
            </ul>
        </nav>
    </header>
</template>
<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const isModalOpen = ref(false);
const hambuger = ref('');
const closeHambuger = ref('');
const isMobileView = ref(window.innerWidth <= 1044);

function openModal() {
	const closeHambuger = document.querySelector('#close-hambuger');
	isModalOpen.value = true;
	hambuger.value = 'none';
	closeHambuger.value = 'block';
}

function closeModal() {
	const hambuger = document.querySelector('#hambuger');
	const closeHambuger = document.querySelector('#close-hambuger');
	isModalOpen.value = false;
	hambuger.value = 'block';
	closeHambuger.value = 'none';
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
  window.removeEventListener('resize', handleResize);
});

</script>
<style>
    @import url('/hankkidndn/resources/css/category.css');
</style>