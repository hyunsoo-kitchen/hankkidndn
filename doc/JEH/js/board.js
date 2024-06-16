// 샘플 데이터 (실제 데이터는 서버에서 가져올 수 있습니다)
const boardData = [
    { id: 1, title: '첫 번째 게시물', author: '관리자', date: '2024-06-16' },
    { id: 2, title: '두 번째 게시물', author: '사용자', date: '2024-06-15' },
    { id: 3, title: '세 번째 게시물', author: '관리자', date: '2024-06-14' },
    { id: 4, title: '네 번째 게시물', author: '주임', date: '2024-06-13' },
    { id: 5, title: '다섯 번째 게시물', author: '관리자', date: '2024-06-12' },
    { id: 6, title: '여섯 번째 게시물', author: '사용자', date: '2024-06-11' },
    { id: 7, title: '일곱 번째 게시물', author: '관리자', date: '2024-06-10' },
    { id: 8, title: '여덟 번째 게시물', author: '사용자', date: '2024-06-09' },
    { id: 9, title: '아홉 번째 게시물', author: '관리자', date: '2024-06-08' },
    { id: 10, title: '열 번째 게시물', author: '사용자', date: '2024-06-07' },
    { id: 11, title: '열한 번째 게시물', author: '사용자', date: '2024-06-11' },
    { id: 12, title: '열 두번째 게시물', author: '관리자', date: '2024-06-10' },
    { id: 13, title: '열 세번째 게시물', author: '사용자', date: '2024-06-09' },
    { id: 14, title: '열 네번째 게시물', author: '관리자', date: '2024-06-08' },
    { id: 15, title: '열 다섯번째 게시물', author: '사용자', date: '2024-06-07' },
    { id: 16, title: '열 여섯번째 게시물', author: '사용자', date: '2024-06-11' },
    { id: 17, title: '열 일곱번째 게시물', author: '관리자', date: '2024-06-10' },
    { id: 18, title: '열 여덟번째 게시물', author: '사용자', date: '2024-06-09' },
    { id: 19, title: '열 아홉번째 게시물', author: '관리자', date: '2024-06-08' },
    { id: 20, title: '스무 번째 게시물', author: '사용자', date: '2024-06-07' },
    { id: 21, title: '스물 한번째 게시물', author: '사용자', date: '2024-06-11' },
    { id: 22, title: '스물 두번째 게시물', author: '관리자', date: '2024-06-10' },
    { id: 23, title: '스물 세번째 게시물', author: '사용자', date: '2024-06-09' },
    { id: 24, title: '스물 네번째 게시물', author: '관리자', date: '2024-06-08' },
    { id: 25, title: '스물 다섯번째 게시물', author: '사용자', date: '2024-06-07' },
    { id: 26, title: '스물 여섯번째 게시물', author: '사용자', date: '2024-06-11' },
    { id: 27, title: '스물 일곱번째 게시물', author: '관리자', date: '2024-06-10' },
    { id: 28, title: '스물 여덟번째 게시물', author: '사용자', date: '2024-06-09' },
    { id: 29, title: '스물 아홉번째 게시물', author: '관리자', date: '2024-06-08' },
    { id: 30, title: '서른 번째 게시물', author: '사용자', date: '2024-06-07' },
    // 더 많은 데이터 추가 가능
];

const rowsPerPage = 5;
let currentPage = 1;

function displayTablePage(page) {
    const tbody = document.querySelector('#board-table-body');
    tbody.innerHTML = '';

    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const pageData = boardData.slice(start, end);

    pageData.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${row.id}</td>
            <td>${row.title}</td>
            <td>${row.author}</td>
            <td>${row.date}</td>
        `;
        tbody.appendChild(tr);
    });

    updatePagination();
}

function updatePagination() {
    const pagination = document.querySelector('#pagination');
    pagination.innerHTML = '';

    const totalPages = Math.ceil(boardData.length / rowsPerPage);


    // Page number buttons
    for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement('button');
        button.innerText = i;
        button.classList.add('page-button');
        if (i === currentPage) {
            button.classList.add('active');
        }
        button.addEventListener('click', () => {
            currentPage = i;
            displayTablePage(currentPage);
        });
        pagination.appendChild(button);
    }
}

function getCurrentPageData(start, end) {
    return boardData.slice(start, end);
}

function search() {
    const searchInput = document.getElementById('searchInput').value.trim().toLowerCase();
    const filteredData = boardData.filter(item => {
        return item.title.toLowerCase().includes(searchInput) ||
               item.author.toLowerCase().includes(searchInput) ||
               item.date.includes(searchInput);
    });

    currentPage = 1;
    displayTablePage(currentPage);
}

// 초기 로드
displayTablePage(currentPage);
