document.addEventListener('DOMContentLoaded', function() {
    const agree1Yes = document.querySelector('#agree_1_yes');
    const agree1No = document.querySelector('#agree_1_no');
    const agree2Yes = document.querySelector('#agree_2_yes');
    const agree2No = document.querySelector('#agree_2_no');
    const nextButton = document.querySelector('#next_button');

    function checkAgreement() {
        if (agree1Yes.checked && agree2Yes.checked) {
            nextButton.disabled = false;
        } else {
            nextButton.disabled = true;
        }
    }

    agree1Yes.addEventListener('change', checkAgreement);
    agree1No.addEventListener('change', checkAgreement);
    agree2Yes.addEventListener('change', checkAgreement);
    agree2No.addEventListener('change', checkAgreement);

    nextButton.addEventListener('click', function(event) {
        if (!agree1Yes.checked || !agree2Yes.checked) {
            event.preventDefault();
        } else {
            window.location.href = 'join-final.html';
        }
    });
});


