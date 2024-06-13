<template>
<div class="container">
        <div class="header">
            <img class="main_img" src="/img/Rectangle 112.png">
        </div>
        <div class="main_list">
            <h2>글 작성</h2>
            <hr>
            <div class="select_why">
                <select name="board" id="board">
                    <option value="freeboard">자유게시판</option>
                    <option value="questionboard">질문게시판</option>
                    <option value="qanda">문의게시판</option>
                </select>
                <div></div>
            </div>
            <input type="text" placeholder="제목">
            <textarea name="content" id="content" rows="30" placeholder="내용을 입력해주세요"></textarea>
            <div class="buttons">
                <button class="complete">작성하기</button>
                <button class="cancel ">취소</button>
            </div>
        </div>
    </div>
</template>
<script upset>

</script>
<style scoped src="../../css/boardinsert.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>