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
            <button class="category_btn" @click="$router.push('/adminad')"
            >광고, 캠페인 관리</button>
            <button class="category_btn">통계</button>
        </div>
        <div class="main_container">

            <div class="head_notice">
                <div class="head_report_count">
                    <div>처리해야할 신고 수 : {{ approveChkCountData }}</div>
                </div>
                <div>
                    <h3></h3>
                </div>
                <div class="head_info">
                    <div>신규 가입자 : {{ todayStats.user_count }}</div> 
                    <div>탈퇴회원 : {{ todayStats.withdrawal_count }}</div>
                    <div>새 레시피 : {{ todayStats.recipe_count }}</div>
                    <div>새 게시글 : {{ todayStats.post_count }}</div>
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
import { onBeforeMount, computed, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
onBeforeMount(() => {
    store.dispatch('getNewMemberList');
    store.dispatch('getDailyStatsList');
    store.dispatch('getWeeklyStatsList');
    store.dispatch('getMonthlyStatsList');
    store.dispatch('getApproveChkCount')
});

const newMemberData = computed(() => store.state.newMemberListData);
const dailyStatsData = computed(() => store.state.dailyStatsData);
const todayStats = computed(() => store.state.todayStats);
const weeklyStatsData = computed(() => store.state.weekStatsData);
const monthlyStatsData = computed(() => store.state.monthStatsData);
const approveChkCountData = computed(() => store.state.approvechkCountData);

// 현재 달 계산
const getCurrentMonth = () => {
    const now = new Date();
    const month = now.toLocaleString('default', { month: 'short' }); // 예: 'Jul' 또는 'July'
    return `${month}`;
};

const currentMonth = ref(getCurrentMonth());

</script>

<style scoped src="../../css/admin_dash.css">

</style>