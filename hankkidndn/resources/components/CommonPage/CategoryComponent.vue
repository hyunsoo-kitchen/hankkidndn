<template>
    <!-- Header -->
    <header>
        <div class="nav-container">
            <div @click="openModal" id="hambuger" :style="hambuger"></div>
            <div @click="closeModal" id="close-hambuger" :style="closeHambuger"></div>
                <nav v-if="!isMobileView" id="nav-list">
                    <ul>
                        <li><button @click="$router.push('/recipe/99?page=1')">추천</button></li>
                        <li class="dropdown">
                            <button>레시피</button>
                            <ul class="dropdown-content">
                                <li><button @click="$router.push('/recipe/100?page=1')">전체</button></li>
                                <li><button @click="$router.push('/recipe/1?page=1')">한식</button></li>
                                <li><button @click="$router.push('/recipe/2?page=1')">중식</button></li>
                                <li><button @click="$router.push('/recipe/3?page=1')">양식</button></li>
                                <li><button @click="$router.push('/recipe/4?page=1')">일식</button></li>
                                <li><button @click="$router.push('/recipe/5?page=1')">베이킹</button></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <button>게시판</button>
                            <ul class="dropdown-content">
                                <li><button @click="$router.push('/board/6?page=1')">공지사항</button></li>
                                <li><button @click="$router.push('/board/7?page=1')">자유게시판</button></li>
                                <li><button @click="$router.push('/board/8?page=1')">질문게시판</button></li>
                                <li><button @click="$router.push('/board/9?page=1')">문의게시판</button></li>
                            </ul>
                        </li>
                        <li><button>이벤트</button></li>
                    </ul>
                </nav>
        </div>
        <nav v-if="isModalOpen" class="hambuger-nav-list">
            <ul class="dropdown-content">
                <li  @click="$router.push('/recipe/99?page=1')" class="dropdown-content-li">추천</li>
                <hr>
                <li @click="$router.push('/recipe/100?page=1')" class="dropdown-content-li">전체</li>
                <li @click="$router.push('/recipe/1?page=1')" class="dropdown-content-li">한식</li>
                <li @click="$router.push('/recipe/2?page=1')" class="dropdown-content-li">중식</li>
                <li @click="$router.push('/recipe/3?page=1')" class="dropdown-content-li">양식</li>
                <li @click="$router.push('/recipe/4?page=1')" class="dropdown-content-li">일식</li>
                <li @click="$router.push('/recipe/5?page=1')" class="dropdown-content-li">베이킹</li>
                <hr>
                <li @click="$router.push('/board/6?page=1')" class="dropdown-content-li">공지사항</li>
                <li @click="$router.push('/board/7?page=1')" class="dropdown-content-li">자유게시판</li>
                <li @click="$router.push('/board/8?page=1')" class="dropdown-content-li">질문게시판</li>
                <li @click="$router.push('/board/9?page=1')" class="dropdown-content-li">문의게시판</li>
                <hr>
                <li class="dropdown-content-li">이벤트</li>
            </ul>
        </nav>
    </header>
</template>
<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { useStore } from 'vuex';


const store = useStore();
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

function getRecipeList(categoryId) {
    store.dispatch('getRecipeList', categoryId);
}

function getBoardList(categoryId) {
    store.dispatch('getBoardList', categoryId);
}

</script>
<style scoped src="../../css/category.css">
    
</style>