const modal = document.getElementById('addressModal');
const openBtn = document.getElementById('openModalBtn');
const emptyAddBtn = document.getElementById('emptyAddBtn');
const closeBtns = document.querySelectorAll('.close-modal, #cancelModalBtn');
const editBtns = document.querySelectorAll('.edit-btn');
const form = document.getElementById('addressForm');
const modalTitle = document.querySelector('.modal-header h2');
const methodInput = document.getElementById('method-input');

function openModal(editData = null) {
    modal.classList.add('active');
    if (editData) {
        modalTitle.innerText = 'Edit address';
        form.action = `/profile/addresses/${editData.id}`;
        methodInput.value = 'PATCH';
        // Populate fields
        for (let field in editData) {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                if (input.type === 'radio') {
                    const radio = form.querySelector(`[name="${field}"][value="${editData[field]}"]`);
                    if (radio) radio.checked = true;
                } else if (input.type === 'checkbox') {
                    input.checked = editData[field];
                } else {
                    input.value = editData[field];
                }
            }
        }
    } else {
        modalTitle.innerText = 'Add new address';
        form.action = '/profile/addresses';
        methodInput.value = 'POST';
        form.reset();
    }
}

function closeModal() {
    modal.classList.remove('active');
}

openBtn?.addEventListener('click', () => openModal());
emptyAddBtn?.addEventListener('click', () => openModal());

closeBtns.forEach(btn => btn.addEventListener('click', closeModal));

editBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const addressData = JSON.parse(btn.dataset.address);
        openModal(addressData);
    });
});

modal?.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
});

// Hide flash message after 4 seconds
setTimeout(() => {
    const flash = document.getElementById('flash-message');
    if (flash) flash.style.display = 'none';
}, 4000);