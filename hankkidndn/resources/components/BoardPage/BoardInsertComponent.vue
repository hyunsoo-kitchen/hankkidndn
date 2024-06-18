<template>
<form id="boardInsertForm">
    <div class="container">
        <div class="header">
            <img class="main_img" src="../../../public/img/recipe_order.png">
        </div>
        <div class="main_list">
            <h2>글 작성</h2>
            <hr>
            <div class="select_why">
                <select name="board" id="board" >
                    <option value="7">자유게시판</option>
                    <option value="8">질문게시판</option>
                    <option value="9">문의게시판</option>
                </select>
                <div></div>
            </div>
            <input type="text" placeholder="제목">
            <textarea name="content" id="content" rows="30" placeholder="내용을 입력해주세요"></textarea>
            <div class="buttons">
                <button @click="store.dispatch('boardInsert')" class="complete">작성하기</button>
                <button @click="$router.back()" class="cancel ">취소</button>
            </div>
        </div>
    </div>
</form>
</template>
<script upset>

</script>
<style scoped src="../../css/boardinsert.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>