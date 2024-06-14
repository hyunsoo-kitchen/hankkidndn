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
        }
    },
    mutations: {
        setRecipeBoardData(state, data) {
            state.recipeListData = data;
        },
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
        // 보드 페이지 이동
        getRecipeList(context, num) {
            const url = '/recipe=' + num;

            axios.get(url)
            .then(response => {
                console.log(response.data.data)
                context.commit('setRecipeBoardData', response.data.data);

                router.push('/recipe=' + num);
            })
            .catch()
        },

        getBoardList(context, num) {
            const url = '/board=' + num;

            axios.get(url)
            .then(response => {
                console.log(response.data.data)
                context.commit('setBoardData', response.data.data);
                router.push('/board='+ num);
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

