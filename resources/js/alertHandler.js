window.showBladeToast = function(message, type = 'success') {
    fetch(`/components/toast?message=${encodeURIComponent(message)}&type=${type}`)
        .then(res => res.text())
        .then(html => {
            const container = document.getElementById('toast-container');
            const temp      = document.createElement('div');

            temp.innerHTML = html.trim();

            const toast = temp.firstChild;
            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('opacity-0', 'translate-y-2');
                toast.classList.add('opacity-100', 'translate-y-0');
            });

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');

                setTimeout(() => toast.remove(), 300);
            }, 5000);
        });
};

window.showExceptionPopup = function(message) {
    const popup      = document.getElementById('exception-popup');
    const messageBox = document.getElementById('exception-message');

    messageBox.textContent = message;
    popup.classList.remove('hidden');
    popup.classList.add('flex');
};

window.closeExceptionPopup = function() {
    const popup = document.getElementById('exception-popup');

    popup.classList.add('hidden');
    popup.classList.remove('flex');
};