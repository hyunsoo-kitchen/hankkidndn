import { createStore } from 'vuex';
import router from './router';

const store = createStore({
    state() {
        return {
            // 인증 flg
            authFlg: document.cookie.indexOf('auth=') >= 0 ? true : false,
            // 유저 정보 받아오는 쪽
            userInfo: localStorage.getItem('userInfo') ? JSON.parse(localStorage.getItem('userInfo')) : null,
            RecipeListData: [],
            BoardListData:[],
            // 메인 페이지에 출력할 리스트
            MainNewData:[],
            MainBestData:[],

            // 페이지 네이션
            recipes: [],
            pagination: localStorage.getItem('pagination') ? JSON.parse(localStorage.getItem('pagination')) : {current_page: '1'},
            // 이현수
            boardList: [], 
            boardDetail: null 
        }
    },
    mutations: {
        // 메인 최근레시피 출력
        setMainBoardData(state, data) {
            state.MainNewData = data;
        },
        // 메인 베스트레시피 출력
        setMainBestData(state, data) {
            // console.log(data);
            state.MainBestData = data
        },
        // 레시피 리스트 저장
        setRecipeData(state, data) {
            state.recipeListData = data.data;
            state.pagination = data
            localStorage.setItem('pagination', JSON.stringify(data));
            // console.log(state.pagination);
            console.log(state.recipeListData);
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
        // 이현수
        // 게시글을 가장 처음에 넣기
        setUnshiftBoardData(state, data) {
            state.boardData.unshift(data);
        },
        setAddUserBoardsCount(state){
            state.userInfo.boards_count++;
            localStorage.setItem('userInfo', state.userInfo);
        },
        setBoardDetail(state, boardDetail) {
            state.boardDetail = boardDetail; 
        }
    },
    actions: {
        // 메인페이지 게시글 획득
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
        getRecipeList(context, data) {
            const url = '/api/recipe/' + data.board_type + '?page=' + data.page;

            axios.get(url)
            .then(response => {
                // console.log(response.data)
                
                context.commit('setRecipeData', response.data.data);
                router.push('/recipe/' + data.board_type + '?page=' + data.page);
            })
            .catch()
        },

        // 보드 페이지 이동 후 해당 게시글 획득
        getBoardList(context, num) {
            const url = '/api/board/' + num;

            axios.get(url)
            .then(response => {
                console.log(response.data.data)
                context.commit('setBoardData', response.data.data);
            })
            .catch()
        },

        // 리스트에서 디테일 페이지 이동
        moveDetail(context, id) {
            const url = '/api/detail/' + id

            axios.get(url, data)
            .then(response => {

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
            
           // 0618 csrf 버그 수정완료. 기존 강제셋팅 삭제 - 노경호
            axios.post(url, data, config)
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
            const url = '/api/login';
            const form = document.querySelector('#loginForm');
            const data = new FormData(form);

            // 0618 csrf 버그 수정완료. 기존 강제셋팅 삭제 - 노경호
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

        //로그아웃 처리
        logout(context) {
            const url = '/api/logout';

            axios.post(url)
            .then(response => {
                console.log(response.data); // TODO
            })
            .catch(error => {
                console.log(error.response); // TODO
                alert('문제가 발생해 강제 로그아웃합니다. (' + error.response.data.code + ')');
            })
            .finally(() => {
                localStorage.clear();

                context.commit('setAuthFlg', false);
                context.commit('setUserInfo', null);

                router.replace('/main');
            });
        },

        boardInsert(context) {
            const url= '/api/boardinsert';
            const data = new FormData(document.querySelector('#boardInsertForm'));

            axios.post(url, data)
            .then(response => {
                console.log(response.data);

                context.commit('setUnshiftBoardData', response.data.data);
                context.commit('setAddUserBoardsCount');
                router.replace('/boardinsert');
            })
            .catch(error => {
                console.log(error.response.data);
                alert('글 작성에 실패했습니다.. (' + error.response.data.code + ')');
            });
        },

        boardDetail(context, boardId) {
            const url = `/api/board/${boardId}`;

            axios.get(url)
                .then(response => {
                    console.log(response.data);

                    context.commit('setBoardDetail', response.data.data);
                    router.push(`/board/${boardId}`);
                })
                .catch(error => {
                    console.log(error.response.data);
                    alert('게시글 조회에 실패했습니다. (' + error.response.data.code + ')');
                });
        }
    }
});

export default store;

