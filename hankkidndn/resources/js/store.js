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

            // 레시피 디테일 페이지
            recipeData: [],
            recipeProgram: [],
            recipeStuff: [],

            // 보드 디테일 페이지
            boardDetail: [], 
            boardImg: [],

            // 보드 디테일 페이지 댓글 데이터
            commentData: [],
            cocommentData: [],

            // 중복 신고 방지 모달 플래그
            reportFailFlg: false,
            reportSuccessFlg: false,
            //-------------------------끝------------------------------

            //---------------------노경호------------------------------
            mypageUserinfo: [],

            mypageRecipeList: [],
            mypageBoardList: [],

            myRecipeCommentList: [],
            myBoardCommentList: [],
            
            myRecipePagination: localStorage.getItem('myRecipePagination') ? JSON.parse(localStorage.getItem('myRecipePagination')) : {current_page: '1'},
            myBoardPagination: localStorage.getItem('myBoardPagination') ? JSON.parse(localStorage.getItem('myBoardPagination')) : {current_page: '1'},

            myRCommentPagination: localStorage.getItem('myRCommentPagination') ? JSON.parse(localStorage.getItem('myRCommentPagination')) : {current_page: '1'},
            myBCommentPagination: localStorage.getItem('myBCommentPagination') ? JSON.parse(localStorage.getItem('myBCommentPagination')) : {current_page: '1'},

            isAuthenticated: false,

            // 아이디, 닉네임 인증

            userId: '',
            userNickname: '',

            idFlg: false,
            nicknameFlg: false,
            
            //-------------------------끝------------------------------
            
            //------------------------이현수---------------------------
            recipeListData: [],
            filteredRecipes: [],
            searchRecipeListData: localStorage.getItem('searchPagination') ? JSON.parse(localStorage.getItem('searchPagination')).data : [],
            searchPagination: localStorage.getItem('searchPagination') ? JSON.parse(localStorage.getItem('searchPagination')) : null,
            searchBoardListData: localStorage.getItem('searchPagination') ? JSON.parse(localStorage.getItem('searchPagination')).data : [],
            
            //-----------------------끝-------------------------------
        }
    },
    mutations: {
        //---------------------권현수------------------------------

        // 메인 최근레시피 출력
        setMainBoardData(state, data) {
            state.mainNewData = data;
            // console.log(state.mainNewData)
        },
        // 메인 베스트레시피 출력
        setMainBestData(state, data) {
            // console.log(data);
            state.mainBestData = data
            // console.log(state.mainBestData)
        },
        // 레시피 리스트 저장
        // setRecipeData 함수 선언
        setRecipeData(state, data) {
            // state 객체의 recipeListData 속성을 data 객체의 속성 값으로 설정합니다.
            state.recipeListData = data.data;

            // state 객체의 pagination 속성을 data 객체로 설정합니다.
            state.pagination = data
            
            // localStorage에 'pagination'이라는 키로 data 객체를 JSON 문자열로 저장합니다.
            localStorage.setItem('pagination', JSON.stringify(data));
        },
        // 레시피 데이터 저장
        setDetailRecipeData(state, data) {
            state.recipeData = data;
        },
        // 질문,자유 게시판 등 리스트 저장
        setBoardData(state, data) {
            state.boardListData = data.data;
            state.pagination = data
            localStorage.setItem('pagination', JSON.stringify(data));
            // console.log(state.boardListData);
        },
        // 레시피 디테일 정보 저장
        setRecipeDetail(state, data){
            // console.log(data)
            state.recipeData = data.data;
            state.recipeProgram = data.program;
            state.recipeStuff = data.stuff;
            state.commentData = data.comment;
            state.cocommentData = data.cocomment;
            // console.log(state.commentData)
            // console.log(state.recipeData)
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
            // console.log(state.commentData[data.key]);
            // console.log(data);
            // state.commentData.splice(data.key, 1);
            state.commentData[data.key] = data.data;
            // console.log(state.commentData[data.key]);
        },
        setCocommentData(state, data){
            // state.cocommentData.splice(data.key, 1);
            state.cocommentData[data.key] = data.data;
        },

        // 보드 게시글 댓글 업데이트 처리
        updateCommentData(state, data) {
            state.commentData[data.key] = data.data;
        },
        updateCocommentData(state, data) {
            // console.log(state.cocommentData[data.key]);
            state.cocommentData[data.key] = data.data;
            // console.log(state.cocommentData[data.key]);
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
            state.myBoardPagination = data;
            localStorage.setItem('myBoardPagination', JSON.stringify(data));
        },
        setMyRecipeData(state, data) {
            state.mypageRecipeList = data.data;
            state.myRecipePagination = data;
            localStorage.setItem('myRecipePagination', JSON.stringify(data));
        },
        setMyBCommentData(state,data) {
            state.myBoardCommentList = data.data;
            state.myBCommentPagination = data;
            localStorage.setItem('myBCommentPagination', JSON.stringify(data));
            console.log(state.myBoardCommentList)
        },
        setMyRCommentData(state,data) {
            state.myRecipeCommentList = data.data;
            state.myRCommentPagination = data;
            localStorage.setItem('myRCommentPagination', JSON.stringify(data));
        },

        //마이페이지 개인정보 인증
        setAuthenticate(state, isAuthenticated) {
            state.isAuthenticated = isAuthenticated;
        },
        // 마이페이지 개인정보 인증 초기화
        resetAuthenticate(state) {
            state.isAuthenticated = false;
        },

        //-------------------------노경호 끝-------------------------- 

        //-------------------------이현수 시작------------------------
        setBoardViewCount(state, data) {
            state.boardData = data;
        },
        setFilteredRecipes(state, data) {
            state.filteredRecipes = data.data;
            state.pagination = data
        },
        // 검색 레시피 리스트 저장
        setSearchRecipeData(state, data) {
            state.searchRecipeListData = data.data;
            state.searchPagination = data
            localStorage.setItem('searchPagination', JSON.stringify(data));
        },
        
        setSearchBoardData(state, data) {
            state.searchBoardListData = data.data;
            state.searchPagination = data
            localStorage.setItem('searchPagination', JSON.stringify(data));
        },
        // -----------------------이현수 끝 ---------------------------
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

            axios.get(url)
            .then(response => {
                // console.log(response.data.data)
                if(response.data.data.video_link) {
                    const videoLink = response.data.data.video_link
                        if (videoLink.includes("watch")) {
                            const videoId = videoLink.split("v=")[1].split("&")[0];
                            const embedUrl = `https://www.youtube.com/embed/${videoId}`;
                            response.data.data.embed_url = embedUrl;
                        } else if (videoLink.includes("be/")) {
                            const videoId = videoLink.split("be/")[1].split("&")[0];
                            const embedUrl = `https://www.youtube.com/embed/${videoId}`;
                            response.data.data.embed_url = embedUrl;
                        } else {
                            response.data.data.embed_url = null;
                        }
                } else {
                    response.data.data.embed_url = null;
                }
                context.commit('setRecipeDetail', response.data)
                router.push('/recipe/detail/' + response.data.data.id)
            })
            .catch(error => {
                alert('존재하지않는 게시글 입니다.')
                router.back();
            })
        },

        // 리스트에서 보드 디테일 페이지로 이동
        getBoardDetail(context, id) {
            const url = '/api/board/detail/' + id

            axios.get(url)
            .then(response => {
                context.commit('setBoardDetail', response.data)

                router.push('/board/detail/' + id);
            })
            .catch();
        },

        // 레시피 게시글 삭제 처리
        recipeDelete(context, id) {
            const url = '/api/recipe/delete/' + id
            // console.log(data.id)
            // console.log(data.board_type)
            axios.delete(url)
            .then(response => {
                const recipeType = context.state.recipeData.boards_type_id
                // 삭제한 게시글의 게시판 첫번째 페이지로 이동
                router.replace('/recipe/' + recipeType + '?page=1')
            })
            .catch(error => {
                alert('게시글 삭제에 실패했습니다 ( 게시글번호' + error.response.data.data + ')');
            });
        },

        // 보드 게시글 삭제 처리
        boardDelete(context, id) {
            const url = '/api/board/delete/' + id
            // console.log(data.id)
            // console.log(data.board_type)
            axios.delete(url)
            .then(response => {
                const recipeType = context.state.boardDetail.boards_type_id
                // 삭제한 게시글의 게시판 첫번째 페이지로 이동
                router.replace('/board/' + recipeType + '?page=1')
            })
            .catch(error => {
                alert('게시글 삭제에 실패했습니다 ( 게시글번호' + error.response.data.data + ')');
            });
        },

        // 레시피 게시글 작성 처리
        recipeInsert(context) {
            const url = '/api/recipe/insert'
            const data = new FormData(document.querySelector('#recipeForm'));
            console.log(data)
            axios.post(url, data)
            .then(response => {
                console.log(response.data)
                router.replace('/recipe/'+ response.data.data.boards_type_id +'?page=1');
            })
            .catch(error => {
                console.log(error.response.data);
                alert('글 작성에 실패했습니다.. (' + error.response.data.code + ')');
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

        // 레시피 수정페이지 게시글 획득처리
        getRecipeUpdate(context, id) {
            const url = '/api/recipe/update/' + id
            
            axios.get(url)
            .then(response => {
                context.commit('setRecipeDetail', response.data)
            })
            .catch();
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

        // 레시피 수정페이지
        recipeUpdate(context, id) {
            const url = '/api/recipe/update/' + id
            const data = new FormData(document.querySelector('#recipeForm'));
            data.append('json', JSON.stringify(context.state.recipeProgram));
            axios.post(url, data)
            .then(response => {
                console.log(response.data)
                context.commit('setRecipeDetail', response.data)
                router.replace('/recipe/detail/' + id)
            })
            .catch(error => {
                console.log(error.response.data);
                alert('글 작성에 실패했습니다.. (' + error.response.data.code + ')');
            });
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
            .catch(error => {
                console.log(error.response.data);
                alert('글 작성에 실패했습니다.. (' + error.response.data.code + ')');
            });
        },

        // 레시피 게시글 댓글 작성 처리
        commentRecipeInsert(context, id) {
            const url = '/api/recipe/comment/' + id
            const data = new FormData(document.querySelector('#boardComment'));
            console.log(id)
            axios.post(url, data)
            .then(response => {
                // console.log(response.data.data)
                context.commit('setMoreComment', response.data.data);
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
                        console.log('코멘트 삭제 아이템 : ',item);
                        changeData.data = response.data.data;
                        changeData.key = key;
                        context.commit('setCommentData', changeData)
                        return false;
                    }
                });
                context.state.cocommentData.forEach((item, key) => {
                    if(item.id == response.data.data.id) {
                        console.log('코코멘트 삭제 아이템 : ',item);
                        changeData.data = response.data.data;
                        changeData.key = key;
                        context.commit('setCocommentData', changeData)
                        return false;
                    }
                });
            })
            .catch();
        },

        // 레시피 좋아요 처리
        recipeLike(context, id) {
            const url = '/api/recipe/like/' + id
            console.log(id)
            axios.put(url)
            .then(response => {
                context.commit('setDetailRecipeData', response.data.data)
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

        // 게시글 조회 수 증가
        recipeViewUp(context, id) {
            const url = '/api/recipe/detail/view/' + id

            axios.post(url)
            .then(response => {

            })
            .catch();
        },

        // 게시글 조회 수 증가
        boardViewUp(context, id) {
            const url = '/api/board/detail/view/' + id

            axios.post(url)
            .then(response => {

            })
            .catch();
        },

        // 보드 게시글 신고 기능
        boardReport(context, id) {
            const url ='/api/board/report/' + id
            const data = new FormData(document.querySelector('#boardReportForm')); 

            axios.post(url, data)
            .then(response => {
                // console.log(response.data.code);
                if(response.data.code == 1) {
                    context.state.reportFailFlg = true;
                } else {
                    context.state.reportSuccessFlg = true;
                }
            })
            .catch();
        },

        // 레시피 게시글 신고 기능
        recipeReport(context, id) {
            const url ='/api/recipe/report/' + id
            const data = new FormData(document.querySelector('#recipeReportForm')); 

            axios.post(url, data)
            .then(response => {
                // console.log(response.data.code);
                if(response.data.code == 1) {
                    context.state.reportFailFlg = true;
                } else {
                    context.state.reportSuccessFlg = true;
                }
            })
            .catch();
        },
        test(context) {
            const url = '/api/login/kakao';

            axios.get(url)
            .then(response => {
                localStorage.setItem('userInfo', JSON.stringify(response.data.data));
                context.commit('setUserInfo', response.data.data);
                context.commit('setAuthFlg', true);
                router.back();
            })
            .catch(error => {
                alert(error.response.data.msg);
            });
        },
        // 댓글, 답글 게시글 신고 기능
        commentReport(context, id) {
            const url ='/api/comment/report/' + id
            const data = new FormData(document.querySelector('#commentReportForm')); 

            axios.post(url, data)
            .then(response => {
                // console.log(response.data.code);
                if(response.data.code == 1) {
                    context.state.reportModalFlg = true;
                } else {
                    context.state.reportSuccessFlg = true;
                }
            })
            .catch();
        },

        kakaoLogin(context) {
            const url = '/api/kakaoLogin'

            axios.get(url)
            .then(response => {
                localStorage.setItem('userInfo', JSON.stringify(response.data.data));
                context.commit('setUserInfo', response.data.data);
                context.commit('setAuthFlg', true);

                router.replace('/main');
            })
            .catch();
        },
        //---------------------끝---------------------------

        //---------------------노경호------------------------------
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
            const data = new FormData(document.querySelector('#registrationForm'));

            axios.post('/api/registration', data)
            .then(response => {
                  alert('회원가입이 완료되었습니다.');
                  router.replace('/main');
              })
              .catch(error => {
                console.log(error.response.data);
                alert('회원가입 중 오류가 발생했습니다.');
              });
        },

        // 유저 ID체크
        idCheck(context, data) {
            const url = '/api/regist/userid'
            // console.log(data)
            const formData = new FormData();
            formData.append('u_id', data);
            axios.post(url, formData)
            .then(response => {
                context.state.userId = data;
                context.state.idFlg = true;
                alert('사용가능한 아이디 입니다.')

            })
            .catch(error => {
                alert('사용불가능한 아이디 입니다.')
                context.state.idFlg = false;
            });
        },

        // 유저 닉네임 체크
        nicknameCheck(context, data) {
            const url = '/api/regist/userNickname'
            console.log(data)
            const formData = new FormData();
            formData.append('u_nickname', data);
            axios.post(url, formData)
            .then(response => {
                context.state.userNickname = data;
                context.state.nicknameFlg = true;
                alert('사용가능한 닉네임 입니다.')

            })
            .catch(error => {
                context.state.nicknameFlg = false;
                alert('사용불가능한 닉네임 입니다.(' + error.response.data.code + ')');
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
                // console.log(error.response); //TODO
                // router.replace('/main');
                alert(error.response.data.msg);
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
        getRecipeListInMy(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/mypage/recipe' + param;
            
            console.log(url);
            axios.get(url)
            .then(response => {
                context.commit('setMyRecipeData', response.data.data);
            })
            .catch()
        },

        // 마이페이지 내가 쓴 게시글
        getBoardListInMy(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/mypage/board' + param;

            console.log(url);
            axios.get(url)
            .then(response => {
                context.commit('setMyBoardData', response.data.data);
            })
            .catch()
        },

        // 마이페이지 내가 레시피 게시판에 쓴 댓글
        getRCommentListInMy(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/mypage/rcomment' + param;

            console.log(url);
            axios.get(url)
            .then(response => {
                // console.log(response.data.data)
                context.commit('setMyRCommentData', response.data.data);
            })
            .catch()
        },

        // 마이페이지 내가 보드 게시판에 쓴 댓글
        getBCommentListInMy(context, page) {
            const param = page == 1 ? '' : '?page=' + page;
            const url = '/api/mypage/bcomment' + param;

            console.log(url);
            axios.get(url)
            .then(response => {
                context.commit('setMyBCommentData', response.data.data);
            })
            .catch()
        },

        //마이페이지 내 정보 인증
        authenticate({ commit }, password) {
            const data = new FormData();
            data.append('u_password', password);

            axios.post('/api/authenticate', data)
            .then(response => {
                if (response.data.success) {
                    commit('setAuthenticate', true);
                } else {
                    alert(response.data.message || '비밀번호가 틀렸습니다.');
                }
            })
            .catch(error => {
                console.error('인증 오류:', error.response ? error.response.data : error.message);
                alert('비밀번호를 확인해주세요.');
            });
        },
        
        // 비밀번호 업데이트
        updatePassword(context) {
            const data = new FormData(document.querySelector('#updatePasswordForm'));

            axios.post('/api/user/updatepassword', data)
              .then(response => {
                if (response.data.success) {
                  alert('비밀번호가 성공적으로 변경되었습니다.');
                } else {
                  alert('비밀번호 변경에 실패했습니다.');
                }
              })
              .catch(error => {
                console.log(error.response.data);
                alert('비밀번호 변경 중 오류가 발생했습니다.');
              });
        },

        // 닉네임 변경
        updateNickname(context) {
            const data = new FormData(document.querySelector('#updateNicknameForm'));

            axios.post('/api/user/updatenickname', data)
                .then(response => {
                    if (response.data.success) {
                        alert('닉네임이 성공적으로 변경되었습니다.');
                    } else {
                        alert('닉네임 변경에 실패했습니다.');
                    }
                })
                .catch(error => {
                    console.log(error.response.data);
                    alert('닉네임 변경 중 오류가 발생했습니다.');
                });
        },

        // 휴대폰번호 변경
        updatePhonenum(context) {
            const data = new FormData(document.querySelector('#updatePhoneForm'));

            axios.post('/api/user/updatephonenum', data)
                .then(response => {
                    if (response.data.success) {
                        alert('휴대폰번호가 성공적으로 변경되었습니다.');
                    } else {
                        alert('휴대폰번호 변경에 실패했습니다.');
                    }
                })
                .catch(error => {
                    console.log(error.response.data);
                    alert('휴대폰번호 변경 중 오류가 발생했습니다.');
                });
        },

        // 프로필사진 변경
        updateProfile(commit) {
            const url = '/api/profile/update'

            const data = new FormData(document.querySelector('#profileForm'));
            // formData.append('profile', file);

            axios.post(url, data)
            .then(response => {
                console.log(response.data)
            })
            .catch();
      
            // return axios.post('/api/profile/update', formData, {
            //   headers: {
            //     'Content-Type': 'multipart/form-data',
            //   },
            // }).then(response => {
            //   // handle success, e.g., update user profile in state
            //   commit('setUserProfile', response.data);
            // }).catch(error => {
            //   // handle error
            //   console.error(error);
            // });
          },

        // 생년월일 변경
        updateBirthat(context) {
            const data = new FormData(document.querySelector('#updateBirthForm'));

            axios.post('/api/user/updatebirthat', data)
                .then(response => {
                    if (response.data.success) {
                        alert('생년월일이 성공적으로 변경되었습니다.');
                    } else {
                        alert('생년월일 변경에 실패했습니다.');
                    }
                })
                .catch(error => {
                    console.log(error.response.data);
                    alert('생년월일 변경 중 오류가 발생했습니다.');
                });
        },
        
        // 주소 변경
        updateAddress(context) {
            const data = new FormData(document.querySelector('#updateBirthForm'));

            axios.post('/api/user/updateaddress', data)
                .then(response => {
                    if (response.data.success) {
                        alert('주소가 성공적으로 변경되었습니다.');
                    } else {
                        alert('주소 변경에 실패했습니다.');
                    }
                })
                .catch(error => {
                    console.log(error.response.data);
                    alert('주소 변경 중 오류가 발생했습니다.');
                });
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

        searchRecipes(context, data) {
            const url ='/api/search/recipe?search=' + data.search + '&page=' + data.page;
            axios.get(url)
            .then(response => {
                if(response.data.data.total !== 0) {
                    console.log(response.data.data);
                    context.commit('setSearchRecipeData', response.data.data);
                    // router.replace('/search/recipe?page=' + data.page);
                    router.replace('/search/recipe?search=' + data.search + '&page=' + data.page);
                } else {
                    alert('해당 레시피가 존재하지 않습니다')
                }
            })
            .catch(error => {
                console.log(error.response);
            }) 
        },

        searchBoards(context, data) {
            let url;
            if (data.searchCriteria === 'title') {
                url = `/api/search/board/${data.board_type}?search=${data.search}&page=${data.page}`;
            } else if (data.searchCriteria === 'nickname') {
                url = `/api/search/board/name/${data.board_type}?search=${data.search}&page=${data.page}`;
            }

            console.log(url);

            axios.get(url)
                .then(response => {
                    if(response.data.data.total !== 0) {
                    // console.log('searchBoards', response.data);
                    context.commit('setSearchBoardData', response.data.data);
                    router.replace('/search/board/' + data.board_type + '/' + data.search + '?page=' + data.page);
                    } else {
                        alert('해당 게시글이 존재하지 않습니다.')
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },


    }
});

export default store;

