// 우편번호 주소찾기
 function execDaumPostcode() {
    // 새로운 Daum 우편번호 찾기 객체를 생성하고, 완료 시 호출될 콜백 함수를 설정합니다.
    new daum.Postcode({
        // 우편번호 찾기가 완료되었을 때 실행될 콜백 함수입니다.
        oncomplete: function(data) {
            var addr = ''; // 주소 정보를 저장할 변수를 초기화합니다.
            var extraAddr = ''; // 추가 주소 정보를 저장할 변수를 초기화합니다.

            // 사용자가 선택한 주소의 타입이 도로명 주소인 경우
            if (data.userSelectedType === 'R') { 
                addr = data.roadAddress; // 도로명 주소를 addr 변수에 저장합니다.
            } else { 
                addr = data.jibunAddress; // 지번 주소를 addr 변수에 저장합니다.
            }
            // 사용자가 선택한 주소의 타입이 도로명 주소인 경우
            if(data.userSelectedType === 'R'){
                // 법정동명이 존재하고, 동, 로, 가로 끝나는 경우 추가 주소 정보를 설정합니다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraAddr += data.bname;
                }
                // 건물명이 존재하고, 아파트인 경우 추가 주소 정보를 설정합니다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 추가 주소 정보가 존재하는 경우 괄호로 묶어서 설정합니다.
                if(extraAddr !== ''){
                    extraAddr = ' (' + extraAddr + ')';
                }
            } else {
                 // 사용자가 선택한 주소의 타입이 지번 주소인 경우 추가 주소 정보를 비웁니다.
                document.querySelector("#UserAdd1").value = '';
            }
            // 우편번호 입력 필드에 우편번호를 설정
            document.querySelector('#zipp_code_id').value = data.zonecode;
            // 기본주소 영역
            document.querySelector("#UserAdd1").value = addr;
            // 추가 주소정보 입력
            document.querySelector("#UserAdd1").value += extraAddr;
            // 두 번째 주소 입력 필드에 포커스를 설정합니다.
            document.querySelector("#UserAdd2").focus(); 
        }
    // 우편번호 찾기 창을 엽니다.
    }).open();
}

// 휴대폰번호 숫자만 입력되게.
document.querySelector('#phone2').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
document.querySelector('#phone3').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// 비밀번호 위아래 일치
document.querySelector('#password').addEventListener('input', validatePasswords);
document.querySelector('#confirm_password').addEventListener('input', validatePasswords);

function validatePasswords() {
    var password = document.querySelector('#password').value;
    var confirmPassword = document.querySelector('#confirm_password').value;
    var errorMessage = document.querySelector('#error_message');

if (password !== confirmPassword) {
    errorMessage.style.display = 'block'; // 비밀번호가 일치하지 않을 때 에러 메시지 표시
} else {
    errorMessage.style.display = 'none'; // 비밀번호가 일치할 때 에러 메시지 숨김
}
}


 