document.addEventListener('DOMContentLoaded', function() {
    //DOM이 로드되면 실행될 함수를 등록합니다.
    // 자바스크립트에서 'DOMContentLoaded' 이벤트는 웹 페이지의 초기 HTML
    // 문서가 완전히 로드되고 파싱된 후에 발생하는 이벤트입니다. 즉, HTML 요소들이
    // DOM으로 변환되어 스크립트에 의해 접근 가능한 상태가 되었을 때 발생합니다.
    
    //agree_1_yes, agree_1_no, agree_2_yes, agree_2_no, next_button 요소를 가져옵니다.
    const agree1Yes = document.querySelector('#agree_1_yes');
    const agree1No = document.querySelector('#agree_1_no');
    const agree2Yes = document.querySelector('#agree_2_yes');
    const agree2No = document.querySelector('#agree_2_no');
    const nextButton = document.querySelector('#next_button');

  // 이용약관 체크박스를 기본적으로 비동의 상태로 설정합니다.
  agree1Yes.checked = false;
  agree1No.checked = true;
  agree2Yes.checked = false;
  agree2No.checked = true;
  nextButton.disabled = true;  // 다음 버튼도 초기에는 비활성화 상태로 설정합니다.

    function checkAgreement() {
        if (agree1Yes.checked && agree2Yes.checked) {
            nextButton.disabled = false;
        } else {
            nextButton.disabled = true;
        }
    }

    // 각 체크박스의 변경 이벤트에 checkAgreement 함수를 연결합니다.
    agree1Yes.addEventListener('change', checkAgreement);
    agree1No.addEventListener('change', checkAgreement);
    agree2Yes.addEventListener('change', checkAgreement);
    agree2No.addEventListener('change', checkAgreement);

    // 다음 단계 버튼 클릭 시 실행될 함수를 정의합니다.
    nextButton.addEventListener('click', function(event) {
        // 하나라도 동의하지 않은 체크박스가 있으면
        if (!agree1Yes.checked || !agree2Yes.checked) {
            // 기본 동작(페이지 전환)을 막고 경고창을 띄웁니다.
            event.preventDefault();
            alert('모든 약관에 동의해야 합니다.');
        } else {
            // 모든 약관에 동의했으면 다음 페이지로 이동합니다.
            window.location.href = 'join-final.html';
        }
    });
});



