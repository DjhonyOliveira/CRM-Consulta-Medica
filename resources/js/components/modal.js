function modal(modalId = 'draggableModal', headerId = 'modalHeader') {
    const modal = document.getElementById(modalId);
    const header = document.getElementById(headerId);

    if (!modal || !header) return;

    let isDragging = false;
    let offset = { x: 0, y: 0 };

    header.addEventListener('mousedown', (e) => {
        isDragging = true;
        const rect = modal.getBoundingClientRect();
        offset.x = e.clientX - rect.left;
        offset.y = e.clientY - rect.top;
        modal.style.transition = 'none';
    });

    document.addEventListener('mousemove', (e) => {
        if (isDragging) {
            modal.style.left = `${e.clientX - offset.x}px`;
            modal.style.top = `${e.clientY - offset.y}px`;
            modal.style.transform = 'none';
        }
    });

    document.addEventListener('mouseup', () => {
        isDragging = false;
    });
}

export default modal;
