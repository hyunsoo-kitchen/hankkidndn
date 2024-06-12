     // 휴대전화 국가 코드
     const phoneCodeSelect = document.getElementById("phone-code");

     // 휴대전화 국가 코드 선택 시 이벤트 핸들러
     phoneCodeSelect.addEventListener("change", function() {
         // 선택한 국가 코드 값
         const selectedCode = phoneCodeSelect.value;
         
         // 국가 코드에 따라 휴대전화 입력란의 placeholder 변경
         const phone2Input = document.getElementById("phone2");
         const phone3Input = document.getElementById("phone3");
         
         switch(selectedCode) {
             case "010":
                 phone2Input.placeholder = "1234";
                 phone3Input.placeholder = "5678";
                 break;
             case "011":
                 phone2Input.placeholder = "9876";
                 phone3Input.placeholder = "5432";
                 break;
             case "012":
                 phone2Input.placeholder = "4567";
                 phone3Input.placeholder = "8901";
                 break;
             // 필요한 국가 코드에 대한 case 추가
             default:
                 break;
         }
 });
 function execDaumPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업을 통한 검색 결과 항목 클릭 시 실행
            var addr = ''; // 주소_결과값이 없을 경우 공백 
            var extraAddr = ''; // 참고항목

            //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            if (data.userSelectedType === 'R') { // 도로명 주소를 선택
                addr = data.roadAddress;
            } else { // 지번 주소를 선택
                addr = data.jibunAddress;
            }

            if(data.userSelectedType === 'R'){
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraAddr += data.bname;
                }
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                if(extraAddr !== ''){
                    extraAddr = ' (' + extraAddr + ')';
                }
            } else {
                document.getElementById("UserAdd1").value = '';
            }

            // 선택된 우편번호와 주소 정보를 input 박스에 넣는다.
            document.getElementById('zipp_code_id').value = data.zonecode;
            document.getElementById("UserAdd1").value = addr;
            document.getElementById("UserAdd1").value += extraAddr;
            document.getElementById("UserAdd2").focus(); // 우편번호 + 주소 입력이 완료되었음으로 상세주소로 포커스 이동
        }
    }).open();
    document.getElementById('phone2').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
}
 