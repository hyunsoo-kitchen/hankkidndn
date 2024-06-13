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
// 아이디 입력 필드 제한, 중복확인 버튼
// 비밀번호 입력 필드 제한
document.addEventListener('DOMContentLoaded', function() {
    const userIdInput = document.querySelector('#user_id');
    const idErrorMessage = document.querySelector('#id-error-message');
    const passwordInput = document.getElementById('password');
    const passwordErrorMessage = document.getElementById('password-error-message');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const confirmPasswordErrorMessage = document.getElementById('confirm-password-error-message');

    // 아이디 입력 제한
    userIdInput.addEventListener('input', function() {
        const regex = /^[a-zA-Z0-9]{4,12}$/;
        if (!regex.test(userIdInput.value)) {
            idErrorMessage.style.display = 'block';
            idErrorMessage.textContent = '4-12자의 영문 대소문자와 숫자만 입력 가능합니다.';
        } else {
            idErrorMessage.style.display = 'none';
        }
    });
    // 비밀번호 입력 제한
    passwordInput.addEventListener('input', function() {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if (!regex.test(passwordInput.value)) {
            passwordErrorMessage.style.display = 'block';
        } else {
            passwordErrorMessage.style.display = 'none';
        }
    });

    // 비밀번호 입력 시 항상 에러 메시지 표시
    passwordInput.addEventListener('focus', function() {
        passwordErrorMessage.style.display = 'block';
    });

    passwordInput.addEventListener('blur', function() {
        if (passwordInput.value === '') {
            passwordErrorMessage.style.display = 'none';
        }
    });


     // 비밀번호 입력 시 항상 에러 메시지 표시
    //  passwordInput.addEventListener('input', function() {
    //     passwordErrorMessage.style.display = 'block';
    //     const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    //     if (!regex.test(passwordInput.value)) {
    //         passwordErrorMessage.textContent = '최소 8자, 하나 이상의 대문자, 소문자, 숫자, 특수 문자를 포함해야 합니다.';
    //     } else {
    //         passwordErrorMessage.textContent = '사용 가능한 비밀번호입니다.';
    //         passwordErrorMessage.style.color = 'green';
    //     }
    // });
    // 비밀번호 확인 입력 제한
    confirmPasswordInput.addEventListener('input', function() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordErrorMessage.style.display = 'block';
        } else {
            confirmPasswordErrorMessage.style.display = 'none';
        }
    });
});

// function checkDuplicateId() {
//     const userId = document.getElementById('user_id').value;
//     const idErrorMessage = document.getElementById('id-error-message');

//     // 예시 중복 확인 로직. 실제 구현 시 서버와 통신 필요.
//     const existingIds = ['testuser', 'sampleuser']; // 예시 데이터
//     if (existingIds.includes(userId)) {
//         idErrorMessage.style.display = 'block';
//         idErrorMessage.textContent = '이미 사용 중인 아이디입니다.';
//     } else {
//         idErrorMessage.style.display = 'block';
//         idErrorMessage.textContent = '사용 가능한 아이디입니다.';
//         idErrorMessage.style.color = 'green';
//     }
// }

function checkDuplicateNickname() {
    
    const nickname = document.getElementById('nickname').value;
    const nicknameErrorMessage = document.getElementById('nickname-error-message');

    // 예시 중복 확인 로직. 실제 구현 시 서버와 통신 필요.
    const existingNicknames = ['nickname1', 'nickname2']; // 예시 데이터
    if (existingNicknames.includes(nickname)) {
        nicknameErrorMessage.style.display = 'block';
        nicknameErrorMessage.textContent = '이미 사용 중인 닉네임입니다.';
    } else {
        nicknameErrorMessage.style.display = 'block';
        nicknameErrorMessage.textContent = '사용 가능한 닉네임입니다.';
        nicknameErrorMessage.style.color = 'green';
    }
}



 