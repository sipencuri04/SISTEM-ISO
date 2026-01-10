/**
 * SISTEM ISO - Main JavaScript
 * Features: Dark Mode Toggle + Mobile Menu
 */

// ==================== DARK MODE TOGGLE ====================
class ThemeManager {
    constructor() {
        this.theme = localStorage.getItem('theme') || 'light';
        this.init();
    }

    init() {
        // Apply saved theme
        document.documentElement.setAttribute('data-theme', this.theme);

        // Update toggle button icon
        this.updateToggleIcon();

        // Listen for toggle clicks
        const toggleBtn = document.querySelector('.theme-toggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => this.toggle());
        }
    }

    toggle() {
        this.theme = this.theme === 'light' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', this.theme);
        localStorage.setItem('theme', this.theme);
        this.updateToggleIcon();

        // Add animation
        this.animateToggle();
    }

    updateToggleIcon() {
        const toggleBtn = document.querySelector('.theme-toggle');
        if (toggleBtn) {
            toggleBtn.textContent = this.theme === 'light' ? '🌙' : '☀️';
        }
    }

    animateToggle() {
        document.documentElement.style.transition = 'none';
        setTimeout(() => {
            document.documentElement.style.transition = '';
        }, 1);
    }
}

// ==================== MOBILE MENU TOGGLE ====================
class MobileMenu {
    constructor() {
        this.sidebar = document.querySelector('.sidebar');
        this.isOpen = false;
        this.init();
    }

    init() {
        // Create mobile menu toggle button
        this.createToggleButton();

        // Close sidebar on mobile by default
        if (window.innerWidth <= 768) {
            this.close();
        }

        // Listen for window resize
        window.addEventListener('resize', () => this.handleResize());
    }

    createToggleButton() {
        const existing = document.querySelector('.mobile-menu-toggle');
        if (existing) return;

        const toggle = document.createElement('button');
        toggle.className = 'mobile-menu-toggle';
        toggle.innerHTML = `
            <span></span>
            <span></span>
            <span></span>
        `;
        toggle.addEventListener('click', () => this.toggle());

        document.body.appendChild(toggle);
    }

    toggle() {
        this.isOpen ? this.close() : this.open();
    }

    open() {
        if (this.sidebar) {
            this.sidebar.classList.remove('mobile-hidden');
            this.isOpen = true;
        }
    }

    close() {
        if (this.sidebar) {
            this.sidebar.classList.add('mobile-hidden');
            this.isOpen = false;
        }
    }

    handleResize() {
        if (window.innerWidth > 768) {
            this.open();
        } else if (window.innerWidth <= 768 && !this.isOpen) {
            this.close();
        }
    }
}

// ==================== SMOOTH SCROLL ====================
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

// ==================== FORM VALIDATION HELPER ====================
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'var(--danger)';
                } else {
                    field.style.borderColor = 'var(--border-color)';
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi!');
            }
        });
    });
}

// ==================== TABLE SEARCH ====================
function tableSearch(inputId, tableId) {
    const input = document.getElementById(inputId);
    const table = document.getElementById(tableId);

    if (!input || !table) return;

    input.addEventListener('keyup', function () {
        const filter = this.value.toUpperCase();
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const textContent = rows[i].textContent || rows[i].innerText;
            if (textContent.toUpperCase().indexOf(filter) > -1) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    });
}

// ==================== TOOLTIP ====================
function initTooltips() {
    const tooltipTriggers = document.querySelectorAll('[data-tooltip]');

    tooltipTriggers.forEach(trigger => {
        trigger.addEventListener('mouseenter', function () {
            const tooltipText = this.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = tooltipText;
            tooltip.style.cssText = `
                position: absolute;
                background: var(--text-primary);
                color: var(--bg-card);
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 12px;
                white-space: nowrap;
                z-index: 1000;
                pointer-events: none;
            `;

            document.body.appendChild(tooltip);

            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';

            this._tooltip = tooltip;
        });

        trigger.addEventListener('mouseleave', function () {
            if (this._tooltip) {
                this._tooltip.remove();
                delete this._tooltip;
            }
        });
    });
}

// ==================== INITIALIZE ON DOM READY ====================
document.addEventListener('DOMContentLoaded', function () {
    // Initialize theme manager
    new ThemeManager();

    // Initialize mobile menu
    new MobileMenu();

    // Initialize other features
    initSmoothScroll();
    initFormValidation();
    initTooltips();

    // Add fade-in animation to main content
    const content = document.querySelector('.content');
    if (content) {
        content.classList.add('fade-in');
    }

    console.log('🎨 SISTEM ISO loaded successfully!');
});

// ==================== EXPORTS FOR USE IN OTHER SCRIPTS ====================
window.SistemISO = {
    ThemeManager,
    MobileMenu,
    tableSearch,
    initFormValidation,
    initTooltips
};
