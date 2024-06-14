import { createStore } from 'vuex';
import router from './router';

const store = createStore({
    state() {
        return {
            // 인증 flg
            authFlg: document.cookie.indexOf('auth=') >= 0 ? true : false,
            // 유저 정보 받아오는 쪽
            userInfo: localStorage.getItem('userInfo') ? JSON.parse(localStorage.getItem('userInfo')) : null,
            recipeListData: [],
            BoardListData:[],
            MainNewData:[],
            MainBestData:[],
        }
    },
    mutations: {
        // 메인 최근레시피 출력
        setMainBoardData(state, data) {
            state.MainNewData = data;
        },
        setMainBestData(state, data) {
            console.log(data);
            state.MainBestData = data
        },
        // 레시피 리스트 저장
        setRecipeBoardData(state, data) {
            state.recipeListData = data;
        },
        // 질문,자유 게시판 등 리스트 저장
        setBoardData(state, data) {
            state.BoardListData = data;
        }
        ,
        // 인증 플래그 저장
        setAuthFlg(state, flg) {
            state.authFlg = flg;
        },
        // 유저 정보 저장
        setUserInfo(state, data) {
            state.boardData = data;
        },
    },
    actions: {
        getMainNewList(context) {
            const url = '/api/main'

            axios.get(url)
            .then(response => {
                console.log(response.data.bestData)
                context.commit('setMainBoardData', response.data.newData)
                context.commit('setMainBestData', response.data.bestData)
            })
            .catch();
        },

        // 레시피 페이지 이동 후 해당 게시글 획득
        getRecipeList(context, num) {
            const url = '/api/recipe=' + num;

            axios.get(url)
            .then(response => {
                console.log(response.data.data)
                context.commit('setRecipeBoardData', response.data.data);

                router.push('/recipe=' + num);
            })
            .catch()
        },

        // 보드 페이지 이동 후 해당 게시글 획득
        getBoardList(context, num) {
            const url = '/api/board=' + num;

            axios.get(url)
            .then(response => {
                console.log(response.data.data)
                context.commit('setBoardData', response.data.data);
                router.push('/board='+ num);
            })
            .catch()

            

        },
        
        userInfoUpdate(context) {
            const url = '/api/user'
            const data = new FormData(document.querySelector('#myPageForm'));
            
            axios.put(url, data)
            .then(response => {
                router.replace('/mypage');
            })
            .catch()
        },
        //회원가입 처리 action
        registration(context) {
            const url = '/api/registration';
            const form = document.querySelector('#registrationForm');
            const data = new FormData(form);
            // const data = new FormData(document.querySelector('#registrationForm'));
            console.log(data);

            axios.post(url, data)
            .then(response => {
                console.log(response.data) //TODO
                router.replace('/login');
            })
            .catch(error => {
                console.log(error.response.data); //TODO
                alert('회원가입에 실패했습니다 (' + error.response.data.code + ')');
            });
        },

        //로그인 처리
        login(context) {
            const url = '/login';
            const form = document.querySelector('#loginForm');
            const data = new FormData(form);
            axios.post(url, data)
            .then(response => {
                console.log(response.data); //TODO
                localStorage.setItem('userInfo', JSON.stringify(response.data.data));
                context.commit('setUserInfo', response.data.data);
                context.commit('setAuthFlg', true);

                router.replace('/main');
            })
            .catch(error => {
                console.log(error.response); //TODO
                alert('로그인에 실패했습니다.(' + error.response.data.code + ')');
            });
        },
    }
});

export default store;

