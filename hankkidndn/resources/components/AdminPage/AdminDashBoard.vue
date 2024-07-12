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
            <button @click="$store.dispatch('adminLogout')" type="button">로그아웃</button>
        </div>
    </div>

    <div class="body_container">
        <div class="category">
            <button class="category_btn" @click="$router.push('/admindashboard')">대시보드</button>
            <button class="category_btn" @click="$router.push('/adminnotice?page=1')">공지사항</button>
            <button class="category_btn" @click="$router.push('/adminuserfind')">사용자 관리</button>
            <button class="category_btn" @click="$router.push('/admincontentcontroll')">컨텐츠 관리</button>
            <button class="category_btn" @click="$router.push('/adminad')">광고 관리</button>
            <button class="category_btn" @click="$router.push('/adminevent?page=1')">이벤트 관리</button>
        </div>
        <div class="main_container">
            <div class="head_notice">
                <div class="head_report_count">
                    <div>처리해야할 신고 수 : {{ approveChkCountData }}</div>
                </div>
                <div></div>
                <div class="head_info">
                    <div>신규 가입자 : {{ todayStats.user_count }}</div> 
                    <div>탈퇴회원 : {{ todayStats.withdrawal_count }}</div>
                    <div>새 레시피 : {{ todayStats.recipe_count }}</div>
                    <div>새 게시글 : {{ todayStats.post_count }}</div>
                </div>
            </div>

            <!-- 프로그래스바 -->
            <div class="prograsbar_container">
                <div>
                    <h3>유저 연령대별 통계</h3>
                    <hr>
                </div>
                <!-- 전체유저 게이지바 -->
                <div class="total_gauge">
                    <!-- 10대 미만 -->
                    <div class="under_ten" id="under_ten"></div>
                    <!-- 10대 -->
                    <div class="teenager" id="teenager"></div>
                    <!-- 20대 -->
                    <div class="twenties" id="twenties"></div>
                    <!-- 30대 -->
                    <div class="thirties" id="thirties"></div>
                    <!-- 40대 -->
                    <div class="forties" id="forties"></div>
                    <!-- 50대 -->
                    <div class="fifties" id="fifties"></div>
                    <!-- 60대 이상 -->
                    <div class="sixties" id="sixties"></div>
                </div>
                <div class="gauge_info">
                    <p id="under_ten_p"></p>
                    <p id="teenager_p"></p>
                    <p id="twenties_p"></p>
                    <p id="thirties_p"></p>
                    <p id="forties_p"></p>
                    <p id="fifties_p"></p>
                    <p id="sixties_p"></p>
                </div>
                <!-- 통계 -->
                <div class="PPcount_box">
                    <!-- <div>10대 미만 : {{ $store.state.userAgeRange[0].user_count }}명</div> -->
                    <p id="under_ten_pp"></p>
                    <p id="teenager_pp"></p>
                    <p id="twenties_pp"></p>
                    <p id="thirties_pp"></p>
                    <p id="forties_pp"></p>
                    <p id="fifties_pp"></p>
                    <p id="sixties_pp"></p>
                </div>
            </div>

            <!-- 신규 가입 추이 -->
            <div class="new_member_container">
                <div>
                    <h3>신규 가입자</h3>
                    <hr>
                </div>
                <div class="n_m_head">
                    <div>가입일</div>
                    <div>이름</div>
                    <div>닉네임</div>
                    <div>아이디</div>
                    <div>성별</div>
                    <div>생일</div>
                </div>
                <div class="n_m_body">
                    <div class="n_m_list" v-for="(item, index) in newMemberData" :key="index">
                        <div>{{ item.created_at }}</div>
                        <div>{{ item.u_name }}</div>
                        <div>{{ item.u_nickname }}</div>
                        <div>{{ item.u_id }}</div>
                        <div>{{ item.gender }}</div>
                        <div>{{ item.birth_at }}</div>
                    </div>
                </div> 
            </div>
            
            <!-- 간략 통계 -->
            <div class="statistics">
                <div>
                    <h3>일자별 요약</h3>
                    <hr>
                </div>
                <div class="stats_head">
                    <div>일자</div>
                    <div>신규가입</div>
                    <div>새 레시피</div>
                    <div>새 게시글</div>
                    <div>탈퇴회원</div>
                </div>
                <div class="stats_body">
                    <div class="stats_list" v-for="(item, index) in dailyStatsData" :key="index" >
                        <div>{{ item.date }}</div>
                        <div>{{ item.user_count }}</div>
                        <div>{{ item.recipe_count }}</div>
                        <div>{{ item.post_count }}</div>
                        <div>{{ item.withdrawal_count }}</div>
                    </div>
                </div>
                <hr>
                <div class="stats_summary">
                    <div class="week_summary">
                        <div>최근 7일 합계</div>
                        <div>{{ weeklyStatsData.weekly_summary.user_count }}</div>
                        <div>{{ weeklyStatsData.weekly_summary.recipe_count }}</div>
                        <div>{{ weeklyStatsData.weekly_summary.post_count }}</div>
                        <div>{{ weeklyStatsData.weekly_summary.withdrawal_count }}</div>
                    </div>
                    <div class="month_summary">
                        <div>이번달({{ currentMonth }}) 합계</div>
                        <div>{{ monthlyStatsData.monthly_summary.user_count }}</div>
                        <div>{{ monthlyStatsData.monthly_summary.recipe_count }}</div>
                        <div>{{ monthlyStatsData.monthly_summary.post_count }}</div>
                        <div>{{ monthlyStatsData.monthly_summary.withdrawal_count }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, computed, watch, ref } from 'vue';
import { useStore } from 'vuex';

// const tenunderCount = ref(store.state.userAgeRange.find(group => group.age_group === '10대 미만'));

const store = useStore();
onBeforeMount(() => {
    store.dispatch('getNewMemberList');
    store.dispatch('getDailyStatsList');
    store.dispatch('getDailyStatsListData');
    store.dispatch('getWeeklyStatsList');
    store.dispatch('getMonthlyStatsList');
    store.dispatch('getApproveChkCount');
    store.dispatch('getAllUsersCount');
    store.dispatch('getUsersAgeRange');
});

const newMemberData = computed(() => store.state.newMemberListData);
const dailyStatsData = computed(() => store.state.dailyStatsData);
const todayStats = computed(() => store.state.todayStats);
const weeklyStatsData = computed(() => store.state.weekStatsData);
const monthlyStatsData = computed(() => store.state.monthStatsData);
const approveChkCountData = computed(() => store.state.approvechkCountData);

const totalUser = computed(() => store.state.allUserCount);
const userAgeRange = computed(() => store.state.userAgeRange);

const underTenCount = computed(() => {
    const ageGroup = userAgeRange.value.find(group => group.age_group === '10대 미만');
    return ageGroup ? ageGroup.user_count : 0;
});
const teenageCount = computed(() => {
    const ageGroup = userAgeRange.value.find(group => group.age_group === '10대');
    return ageGroup ? ageGroup.user_count : 0;
});
const twentiesCount = computed(() => {
    const ageGroup = userAgeRange.value.find(group => group.age_group === '20대');
    return ageGroup ? ageGroup.user_count : 0;
});
const thirtiesCount = computed(() => {
    const ageGroup = userAgeRange.value.find(group => group.age_group === '30대');
    return ageGroup ? ageGroup.user_count : 0;
});
const fortiesCount = computed(() => {
    const ageGroup = userAgeRange.value.find(group => group.age_group === '40대');
    return ageGroup ? ageGroup.user_count : 0;
});
const fiftiesCount = computed(() => {
    const ageGroup = userAgeRange.value.find(group => group.age_group === '50대');
    return ageGroup ? ageGroup.user_count : 0;
});
const sixtiesCount = computed(() => {
    const ageGroup = userAgeRange.value.find(group => group.age_group === '60대 이상');
    return ageGroup ? ageGroup.user_count : 0;
});

function updateGaugeBar() {
    const total = totalUser.value || 1; // 전체 사용자 수가 0인 경우 대비

    // 각 연령대 비율 계산
    const underTenPercentage = ((underTenCount.value / total) * 100).toFixed(2);
    const teenagePercentage = ((teenageCount.value / total) * 100).toFixed(2);
    const twentiesPercentage = ((twentiesCount.value / total) * 100).toFixed(2);
    const thirtiesPercentage = ((thirtiesCount.value / total) * 100).toFixed(2);
    const fortiesPercentage = ((fortiesCount.value / total) * 100).toFixed(2);
    const fiftiesPercentage = ((fiftiesCount.value / total) * 100).toFixed(2);
    const sixtiesPercentage = ((sixtiesCount.value / total) * 100).toFixed(2);

    // 10대 미만
    const underTen = document.getElementById('under_ten');
    const underTenP = document.getElementById('under_ten_p');
    const underTenPP = document.getElementById('under_ten_pp');
    if (underTen, underTenP, underTenPP) {
        underTen.style.width = underTenPercentage + '%';
        underTen.innerText = underTenPercentage;
        underTenP.innerText ='10대 미만 :' + underTenPercentage + '%';
        underTenPP.innerText ='10대 미만 :' + underTenCount.value + '명';

    }

    // 10대
    const teenager = document.getElementById('teenager');
    const teenagerP = document.getElementById('teenager_p');
    const teenagerPP = document.getElementById('teenager_pp');
    if (teenager, teenagerP, teenagerPP) {
        teenager.style.width = teenagePercentage + '%';
        teenager.innerText = teenagePercentage;
        teenagerP.innerText ='10대 :' + teenagePercentage + '%';
        teenagerPP.innerText ='10대 :' + teenageCount.value + '명';
    }

    // 20대
    const twenties = document.getElementById('twenties');
    const twentiesP = document.getElementById('twenties_p');
    const twentiesPP = document.getElementById('twenties_pp');
    if (twenties, twentiesP, twentiesPP) {
        twenties.style.width = twentiesPercentage + '%';
        twenties.innerText = twentiesPercentage;
        twentiesP.innerText = '20대 : '+ twentiesPercentage + '%';
        twentiesPP.innerText = '20대 : '+ twentiesCount.value + '명';
    }

    // 30대
    const thirties = document.getElementById('thirties');
    const thirtiesP = document.getElementById('thirties_p');
    const thirtiesPP = document.getElementById('thirties_pp');
    if (thirties, thirtiesP, thirtiesPP) {
        thirties.style.width = thirtiesPercentage + '%';
        thirties.innerText = thirtiesPercentage;
        thirtiesP.innerText ='30대 : ' + thirtiesPercentage + '%';
        thirtiesPP.innerText ='30대 : ' + thirtiesCount.value + '명';
    }

    // 40대
    const forties = document.getElementById('forties');
    const fortiesP = document.getElementById('forties_p');
    const fortiesPP = document.getElementById('forties_pp');
    if (forties, fortiesP, fortiesPP) {
        forties.style.width = fortiesPercentage + '%';
        forties.innerText = fortiesPercentage;
        fortiesP.innerText = '40대 : ' + fortiesPercentage + '%';
        fortiesPP.innerText = '40대 : ' + fortiesCount.value + '명';
    }

    // 50대
    const fifties = document.getElementById('fifties');
    const fiftiesP = document.getElementById('fifties_p');
    const fiftiesPP = document.getElementById('fifties_pp');
    if (fifties,fiftiesP, fiftiesPP) {
        fifties.style.width = fiftiesPercentage + '%';
        fifties.innerText = fiftiesPercentage;
        fiftiesP.innerText = '50대 : ' + fiftiesPercentage + '%';
        fiftiesPP.innerText = '50대 : ' + fiftiesCount.value + '명';
    }

    // 60대 이상
    const sixties = document.getElementById('sixties');
    const sixtiesP = document.getElementById('sixties_p');
    const sixtiesPP = document.getElementById('sixties_pp');
    if (sixties, sixtiesP, sixtiesPP) {
        sixties.style.width = sixtiesPercentage + '%';
        sixties.innerText = sixtiesPercentage;
        sixtiesP.innerText = '60대 이상 : '+sixtiesPercentage + '%';
        sixtiesPP.innerText = '60대 이상 : '+sixtiesCount.value + '명';
    }


}


watch([underTenCount, teenageCount, twentiesCount, thirtiesCount, fortiesCount, fiftiesCount, sixtiesCount, totalUser], () => {
    updateGaugeBar();
});

// 현재 달 계산
const getCurrentMonth = () => {
    const now = new Date();
    const month = now.toLocaleString('default', { month: 'short' }); // 예: 'Jul' 또는 'July'
    return `${month}`;
};

const currentMonth = ref(getCurrentMonth());
</script>

<style scoped src="../../css/admin_dash.css"></style>
