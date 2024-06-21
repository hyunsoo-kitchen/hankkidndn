import { createStore } from 'vuex';
import router from './router';

const store = createStore({
    state() {
        return {
            // 인증 flg
            authFlg: document.cookie.indexOf('auth=') >= 0 ? true : false,
            // 유저 정보 받아오는 쪽
            userInfo: localStorage.getItem('userInfo') ? JSON.parse(localStorage.getItem('userInfo')) : null,

            //---------------------권현수------------------------------

            // 각 게시판 리스트 정보
            recipeListData: [],
            boardListData:[],
            // 메인 페이지에 출력할 리스트
            mainNewData:[],
            mainBestData:[],

            // 페이지 네이션
            pagination: localStorage.getItem('pagination') ? JSON.parse(localStorage.getItem('pagination')) : {current_page: '1'},
            // 이현수
            // boardList: [], 
            boardDetail: [], 
            boardImg: [],

            // 댓글 데이터
            commentData: [],
            cocommentData: [],
            //-------------------------끝------------------------------

            //---------------------노경호------------------------------
            mypageUserinfo: [],
            mypageRecipeList: [],
            mypageBoardList: [],

            //-------------------------끝------------------------------
        }
    },
    mutations: {
        //---------------------권현수------------------------------

        // 메인 최근레시피 출력
        setMainBoardData(state, data) {
            state.mainNewData = data;
        },
        // 메인 베스트레시피 출력
        setMainBestData(state, data) {
            // console.log(data);
            state.mainBestData = data
        },
        // 레시피 리스트 저장
        setRecipeData(state, data) {
            state.recipeListData = data.data;
            state.pagination = data
            localStorage.setItem('pagination', JSON.stringify(data));
        },
        // 질문,자유 게시판 등 리스트 저장
        setBoardData(state, data) {
            state.boardListData = data.data;
            state.pagination = data
            localStorage.setItem('pagination', JSON.stringify(data));
            // console.log(state.boardListData);
        },
        // 보드 디테일 정보 저장
        setBoardDetail(state, data){
            state.boardDetail = data.data;
            state.boardImg = data.img;
            state.commentData = data.comment;
            state.cocommentData = data.cocomment;
        },
        setMoreComment(state, data){
            state.commentData.push(data)
        },
        setMoreCocomment(state, data){
            state.cocommentData.push(data)
        },

        // 삭제 후 배열에 삭제한 댓글 추가
        setCommentData(state, data){
            console.log(data);
            state.commentData.splice(data.key, 1);
            state.commentData[data.key] = data.data;
        },
        setCocommentData(state, data){
            state.cocommentData.splice(data.key, 1);
            state.cocommentData[data.key] = data.data;
        },

        // 보드 게시글 댓글 업데이트 처리
        updateCommentData(state, data) {
            state.commentData[data.key] = data.data;
        },
        updateCocommentData(state, data) {
            state.cocommentData[data.key] = data.data;
        },
        //---------------------끝---------------------------

        // 인증 플래그 저장
        setAuthFlg(state, flg) {
            state.authFlg = flg;
        },
        // 유저 정보 저장
        setUserInfo(state, data) {
            console.log(data)
            state.userInfo = data;
        },

        setMypageUserInfo(state, userInfo) {
            state.mypageUserinfo = userInfo;
            console.log(state.mypageUserinfo);
        },
        setMyBoardData(state, data) {
            state.mypageBoardList = data.data;
            // state.pagination = data
            // localStorage.setItem('pagination', JSON.stringify(data));
            // console.log(state.boardListData);
        },
        setMyRecipeData(state, data) {
            state.mypageRecipeList = data.data;
        },
        //-------------------------노경호 끝-------------------------- 
        setBoardViewCount(state, data) {
            state.boardData = data;
        },
        // --------------- 이현수 끝
    },
    actions: {
        //---------------------권현수------------------------------

        // 메인페이지 게시글 획득
        getMainNewList(context) {
            const url = '/api/main'

            axios.get(url)
            .then(response => {
                // console.log(response.data.bestData)
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

        // 보드 페이지 리스트 처리
        getBoardList(context, data) {
            const url = '/api/board/' + data.board_type + '?page=' + data.page;

            axios.get(url)
            .then(response => {
                // console.log(response.data.data)
                context.commit('setBoardData', response.data.data);
                router.push('/board/' + data.board_type + '?page=' + data.page);
            })
            .catch()
        },

        // 리스트에서 레시피 디테일 페이지로 이동
        getRecipeDetail(context, id) {
            const url = '/api/recipe/detail/' + id

            axios.get(url, data)
            .then(response => {
                // console.log(response.data.data)
            })
            .catch()
        },

        // 리스트에서 보드 디테일 페이지로 이동
        getBoardDetail(context, id) {
            const url = '/api/board/detail/' + id

            axios.get(url)
            .then(response => {
                context.commit('setBoardDetail', response.data)
                console.log(response.data)
                router.replace('/board/detail/' + id);
            })
            .catch();
        },

        // 보드 게시글 삭제 처리
        boardDelete(context, data) {
            const url = '/api/board/delete/' + data
            // console.log(data.id)
            // console.log(data.board_type)
            axios.delete(url)
            .then(response => {
                const board_type = context.state.boardDetail.boards_type_id
                // 삭제한 게시글의 게시판 첫번째 페이지로 이동
                router.replace('/board/' + board_type + '?page=1')
            })
            .catch(error => {
                alert('게시글 삭제에 실패했습니다 ( 게시글번호' + error.response.data.data + ')');
            });
        },

        // 보드 게시글 작성 처리
        boardInsert(context) {
            const url= '/api/board/insert';
            const data = new FormData(document.querySelector('#boardInsertForm'));
            console.log(data)
            axios.post(url, data)
            .then(response => {
                console.log(response.data);
                router.replace('/board/'+ response.data.data.boards_type_id +'?page=1');
            })
            .catch(error => {
                console.log(error.response.data);
                alert('글 작성에 실패했습니다.. (' + error.response.data.code + ')');
            });
        },

        // 보드 수정페이지 게시글 획득처리
        getBoardUpdate(context, id) {
            const url = '/api/board/update/' + id

            axios.get(url)
            .then(response => {
                context.commit('setBoardDetail', response.data)
            })
            .catch();
        },

        // 보드 수정페이지 게시글 수정 처리
        boardUpdate(context, id) {
            const url = '/api/board/update/' + id
            const data = new FormData(document.querySelector('#boardUpdateForm'));
            
            axios.post(url, data)
            .then(response => {
                console.log(response.data)
                context.commit('setBoardDetail', response.data)
                router.replace('/board/detail/' + id)
            })
            .catch();
        },

        // 보드 게시글 댓글 작성 처리
        commentInsert(context, id) {
            const url = '/api/board/comment/' + id
            const data = new FormData(document.querySelector('#boardComment'));
            console.log(id)
            axios.post(url, data)
            .then(response => {
                // console.log(response.data.data)
                context.commit('setMoreComment', response.data.data);
            })
            .catch();
        },

        // 보드 게시글 대댓글 작성 처리
        cocomentInsert(context, id) {
            const url = '/api/board/cocomment/' + id
            console.log(id);
            const data = new FormData(document.querySelector('#boardCocomment'));
            axios.post(url, data)
            .then(response => {
                console.log(response.data.data)
                context.commit('setMoreCocomment', response.data.data);
            })
            .catch();
        },

        // 보드 게시글 댓글 수정 처리
        commentUpdate(context, id) {
            const url = '/api/board/comment/update/' + id
            const data = new FormData(document.querySelector('#boardCommentUpdate'));

            axios.post(url, data)
            .then(response => {
                const changeData = {
                    'data': '',
                    'key': '',
                }

                context.state.commentData.forEach((item, key) => {
                    if(item.id == response.data.data.id) {
                        changeData.data = response.data.data;
                        changeData.key = key;
                        context.commit('updateCommentData', changeData)
                        return false;
                    }
                });
                context.state.cocommentData.forEach((item, key) => {
                    if(item.id == response.data.data.id) {
                        changeData.data = response.data.data;
                        changeData.key = key;
                        context.commit('updateCocommentData', changeData)
                        return false;
                    }
                });
            })
            .catch();
        },

        // 보드 게시글 댓글 삭제 처리
        commentDelete(context, id) {
            const url = '/api/board/comment/delete/' + id

            axios.delete(url)
            .then(response => {
                const changeData = {
                    'data': '',
                    'key': '',
                }
                context.state.commentData.forEach((item, key) => {
                    if(item.id == response.data.data.id) {
                        changeData.data = response.data.data;
                        changeData.key = key;
                        context.commit('setCommentData', changeData)
                        return false;
                    }
                });
                context.state.cocommentData.forEach((item, key) => {
                    if(item.id == response.data.data.id) {
                        changeData.data = response.data.data;
                        changeData.key = key;
                        context.commit('setCocommentData', changeData)
                        return false;
                    }
                });
            })
            .catch();
        },

        // 보드 게시글 댓글 좋아요 처리
        boardCommentLike(context, id) {
            const url = '/api/board/comment/like/' + id
            console.log(id)
            axios.put(url)
            .then(response => {
                
            })
            .catch();  
        },
        //---------------------끝---------------------------


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
            const url = '/api/login';
            const form = document.querySelector('#loginForm');
            const data = new FormData(form);

            // 0618 csrf 버그 수정완료. 기존 강제셋팅 삭제 - 노경호
            axios.post(url, data)
            .then(response => {
                // console.log(response.data); //TODO
                localStorage.setItem('userInfo', JSON.stringify(response.data.data));
                context.commit('setUserInfo', response.data.data);
                context.commit('setAuthFlg', true);

                // router.replace('/main');
                router.back();
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
                // router.back();
            });
        },
        //---------------------노경호------------------------------
        // 마이 페이지 유저정보
        getMypageUserInfo(context) {
            const url ='/api/mypage/userinfo';

            axios.get(url)
            .then(response => {
                console.log(response.data); //TODO
                context.commit('setMypageUserInfo', response.data.data);
            })
            .catch(error => {
                console.log(error.response); //TODO
                alert('게시글 습득에 실패했습니다.(' + error.response.data.code + ')')
            });
        },

        // 마이페이지 내가 쓴 레시피
        getRecipeListInMy(context, data) {
            const url ='api/mypage/recipe';

            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setMyRecipeData', response.data.data);
            })
            .catch()
        },


        // 마이페이지 내가 쓴 게시글
        getBoardListInMy(context, data) {
            const url ='/api/mypage/board';

            axios.get(url)
            .then(response => {
                console.log(response.data);
                context.commit('setMyBoardData', response.data.data);
                // router.push('/board/' + data.board_type + '?page=' + data.page);
            })
            .catch()
        },

        //-------------------------끝------------------------------
        // 이현수
        // getBoardViewCount(context) {
        //     const url = 'api/board/detail';

        //     axios.get(url)
        //     .then(response => {
        //         console.log(response.data);
        //         context.commit('setBoardViewCount', response.data.data);
        //     })
        //     .catch(error => {
        //         console.log(error.response);
        //         alert('게시글 습득에 실패했습니다.(' + error.response.data.code + ')')
        //     });
        // }
    }
});

export default store;

