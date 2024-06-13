<template>
  <div class="container">
        <h2 class="main_h2">레시피 등록</h2>
        <form id="recipeForm">
            <div class="first_box">
                <div class="section grid_box">
                    <label class="column_1to2 title_font" for="title"><h3>레시피 제목</h3></label>
                    <input class="column_2to3" type="text" id="title" placeholder="예) 소고기 무국">
                </div>
                <div class="section grid_box">
                    <label class="column_1to2 title_font" for="summary"><h3>요리소개</h3></label>
                    <textarea class="column_2to3to" id="summary" name="summary" placeholder="예) " rows="5"></textarea>
                </div>
                <div class="section grid_box">
                    <label class="column_1to2 title_font" for="video"><h3>동영상</h3></label>
                    <input class="column_2to3" type="url" id="video" name="video" placeholder="예) 영상이 youtube에 있다면 주소를 넣어주세요. https://youtu.be/abcd1234"></input>
                </div>
            </div>
            <div class="section">
                <h3>재료 정보</h3>
                <div id="ingredients">
                    <div class="ingredient_row ingredient_box">
                        <input class="note_input1 ingredient_content" type="text" name="ingredient[]" placeholder="재료 예)돼지고기">
                        <input class="note_input ingredient_content" type="text" name="quantity[]" placeholder="10(수량)">
                        <input class="note_input ingredient_content" type="text" name="" placeholder="예)g, ml(단위)">
                        <input class="note_input ingredient_content" type="text" name="" placeholder="예) (비고)">
                        <button class="remove_btn ingredient_content delete_btn" type="button">제거</button>
                    </div>
                </div>
                <button class="add_btn" type="button" id="addIngredient">추가</button>
            </div>
            <div class="cook-list">
                <div class="cook-btn">
                <h3>요리순서</h3>
                <div class="list-input">
                    <button class="list-btn-remove" type="button">순서 추가</button>
                    <button class="list-btn-start" type="button">순서 제거</button>
                </div>
                </div>
                <div class="content_list">
                <p> Step 1</p>
                <textarea class="text-list" name="list" id="list" placeholder="예 ) 소고기를 기름에 두른 팬에" rows="5"></textarea>
                <input type="file">
            </div>
            </div>
            <div class="cooktip">
                <h3>요리팁</h3>
                <textarea name="tip" id="tip" placeholder="예) 고기가 타지않도록 . . ." rows="3"></textarea>
            </div>
            <div class="actions">
                <button type="submit">저장</button>
                <button type="button" id="saveAndShare">저장 후 공개하기</button>
                <button type="button" id="cancel">취소</button>
            </div>
        </form>
    </div>
</template>
<script upset>

</script>
<style scoped src="../../css/recipeinsert.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>