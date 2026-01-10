/**
 * MODAL & NOTIFICATION SYSTEM
 * Modern popups, confirms, and toasts
 */

// ==================== MODAL MANAGER ====================
class ModalManager {
    constructor() {
        this.createContainer();
    }

    createContainer() {
        if (!document.getElementById('modal-container')) {
            const container = document.createElement('div');
            container.id = 'modal-container';
            document.body.appendChild(container);
        }
    }

    /**
     * Show confirmation dialog
     * @param {Object} options - Dialog options
     * @returns {Promise<boolean>}
     */
    confirm(options = {}) {
        const {
            title = 'Konfirmasi',
            message = 'Apakah Anda yakin?',
            confirmText = 'Ya',
            cancelText = 'Tidak',
            type = 'warning', // info, success, warning, danger
            onConfirm = () => { },
            onCancel = () => { }
        } = options;

        return new Promise((resolve) => {
            const overlay = this.createOverlay();
            const modal = this.createModal('confirm-dialog');

            const icons = {
                info: 'ℹ️',
                success: '✅',
                warning: '⚠️',
                danger: '❌'
            };

            modal.innerHTML = `
                <div class="modal-header">
                    <div class="modal-icon ${type}">
                        ${icons[type]}
                    </div>
                    <div class="modal-title">
                        <h3>${title}</h3>
                    </div>
                </div>
                <div class="modal-body">
                    <p>${message}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline modal-cancel">${cancelText}</button>
                    <button class="btn btn-primary modal-confirm">${confirmText}</button>
                </div>
            `;

            overlay.appendChild(modal);
            document.getElementById('modal-container').appendChild(overlay);

            // Show
            setTimeout(() => overlay.classList.add('active'), 10);

            // Event listeners
            const confirmBtn = modal.querySelector('.modal-confirm');
            const cancelBtn = modal.querySelector('.modal-cancel');

            const close = (result) => {
                overlay.classList.remove('active');
                setTimeout(() => overlay.remove(), 300);
                resolve(result);
            };

            confirmBtn.addEventListener('click', () => {
                onConfirm();
                close(true);
            });

            cancelBtn.addEventListener('click', () => {
                onCancel();
                close(false);
            });

            // Close on ESC
            document.addEventListener('keydown', function escHandler(e) {
                if (e.key === 'Escape') {
                    onCancel();
                    close(false);
                    document.removeEventListener('keydown', escHandler);
                }
            });
        });
    }

    /**
     * Show alert dialog
     */
    alert(options = {}) {
        const {
            title = 'Informasi',
            message = '',
            type = 'info',
            buttonText = 'OK'
        } = options;

        const overlay = this.createOverlay();
        const modal = this.createModal();

        const icons = {
            info: 'ℹ️',
            success: '✅',
            warning: '⚠️',
            danger: '❌'
        };

        modal.innerHTML = `
            <div class="modal-header">
                <div class="modal-icon ${type}">
                    ${icons[type]}
                </div>
                <div class="modal-title">
                    <h3>${title}</h3>
                </div>
            </div>
            <div class="modal-body">
                <p>${message}</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary modal-ok">${buttonText}</button>
            </div>
        `;

        overlay.appendChild(modal);
        document.getElementById('modal-container').appendChild(overlay);
        setTimeout(() => overlay.classList.add('active'), 10);

        const okBtn = modal.querySelector('.modal-ok');
        okBtn.addEventListener('click', () => {
            overlay.classList.remove('active');
            setTimeout(() => overlay.remove(), 300);
        });
    }

    /**
     * Show loading modal
     */
    loading(message = 'Memproses...') {
        const overlay = this.createOverlay();
        overlay.id = 'loading-modal-overlay';
        const modal = this.createModal('loading-modal');

        modal.innerHTML = `
            <div class="modal-body">
                <div class="loading-spinner"></div>
                <div class="loading-text">${message}</div>
            </div>
        `;

        overlay.appendChild(modal);
        document.getElementById('modal-container').appendChild(overlay);
        setTimeout(() => overlay.classList.add('active'), 10);

        return {
            close: () => {
                overlay.classList.remove('active');
                setTimeout(() => overlay.remove(), 300);
            }
        };
    }

    /**
     * Show detail modal
     */
    showDetail(options = {}) {
        const {
            title = 'Detail',
            data = {},
            size = 'normal' // normal, large, fullscreen
        } = options;

        const overlay = this.createOverlay();
        const modal = this.createModal(`modal-${size}`);

        let detailHTML = '<div class="detail-grid">';
        for (const [key, value] of Object.entries(data)) {
            detailHTML += `
                <div class="detail-item">
                    <div class="detail-label">${key}</div>
                    <div class="detail-value">${value || '-'}</div>
                </div>
            `;
        }
        detailHTML += '</div>';

        modal.innerHTML = `
            <div class="modal-header">
                <div class="modal-title">
                    <h3>${title}</h3>
                </div>
                <button class="modal-close">✕</button>
            </div>
            <div class="modal-body">
                ${detailHTML}
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline modal-close-btn">Tutup</button>
            </div>
        `;

        overlay.appendChild(modal);
        document.getElementById('modal-container').appendChild(overlay);
        setTimeout(() => overlay.classList.add('active'), 10);

        const closeBtns = modal.querySelectorAll('.modal-close, .modal-close-btn');
        closeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                overlay.classList.remove('active');
                setTimeout(() => overlay.remove(), 300);
            });
        });

        // Close on overlay click
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
                setTimeout(() => overlay.remove(), 300);
            }
        });
    }

    createOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';
        return overlay;
    }

    createModal(className = '') {
        const modal = document.createElement('div');
        modal.className = `modal ${className}`;
        return modal;
    }
}

// ==================== TOAST NOTIFICATIONS ====================
class ToastManager {
    constructor() {
        this.createContainer();
    }

    createContainer() {
        if (!document.getElementById('toast-container')) {
            const container = document.createElement('div');
            container.className = 'toast-container';
            container.id = 'toast-container';
            document.body.appendChild(container);
        }
    }

    /**
     * Show toast notification
     */
    show(options = {}) {
        const {
            title = '',
            message = '',
            type = 'info', // success, error, warning, info
            duration = 4000
        } = options;

        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div class="toast-icon">${icons[type]}</div>
            <div class="toast-content">
                ${title ? `<div class="toast-title">${title}</div>` : ''}
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close">✕</button>
        `;

        const container = document.getElementById('toast-container');
        container.appendChild(toast);

        // Close button
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => this.remove(toast));

        // Auto remove
        if (duration > 0) {
            setTimeout(() => this.remove(toast), duration);
        }

        return toast;
    }

    success(message, title = 'Berhasil') {
        return this.show({ title, message, type: 'success' });
    }

    error(message, title = 'Error') {
        return this.show({ title, message, type: 'error', duration: 6000 });
    }

    warning(message, title = 'Peringatan') {
        return this.show({ title, message, type: 'warning' });
    }

    info(message, title = 'Info') {
        return this.show({ title, message, type: 'info' });
    }

    remove(toast) {
        toast.classList.add('removing');
        setTimeout(() => toast.remove(), 300);
    }
}

// ==================== INITIALIZE ====================
let Modal, Toast;

document.addEventListener('DOMContentLoaded', function () {
    Modal = new ModalManager();
    Toast = new ToastManager();

    // Override native confirm
    window.confirmDelete = async function (message = 'Apakah Anda yakin ingin menghapus item ini?') {
        return await Modal.confirm({
            title: 'Konfirmasi Hapus',
            message: message,
            confirmText: 'Hapus',
            cancelText: 'Batal',
            type: 'danger'
        });
    };

    window.confirmAction = async function (message, title = 'Konfirmasi') {
        return await Modal.confirm({
            title: title,
            message: message,
            type: 'warning'
        });
    };

    console.log('🎨 Modal & Toast system loaded!');
});

// Export for use
window.Modal = Modal;
window.Toast = Toast;
