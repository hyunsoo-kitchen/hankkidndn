import { createStore } from 'vuex';
import router from './router';

const store = createStore({
    state() {
        return {
            recipeListData: [],
            BoardListData:[],
            authFlg: document.cookie.indexOf('auth=') >= 0 ? true : false,
        }
    },
    mutations: {
        setRecipeBoardData(state, data) {
            state.recipeListData = data;
        },
        setBoardData(state, data) {
            state.BoardListData = data;
        }
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
        }
    }
});

export default store;

// 회원가입 처리 action
// registration(context) {
//     const url = '/api/registration';
//     const data = new FormData(document.querySelector('#registForm'));

//     axios.post(url, data)
//     .then(response => {
//         console.log(response.data) //TODO
//         router.replace('/login');
//     })
//     .catch(error => {
//         console.log(error.response.data); //TODO
//         alert('회원가입에 실패했습니다 (' + error.response.data.code + ')');
//     });
// }