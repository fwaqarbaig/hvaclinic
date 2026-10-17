import { createIcons, icons } from 'lucide';

// Make window.lucide available globally for blade templates and dynamic scripts
window.lucide = {
    createIcons: (options = {}) => createIcons({ icons, ...options }),
    icons,
};

// Automatically instantiate icons on DOMContentLoaded safely
const initIcons = () => {
    if (window.lucide && typeof window.lucide.createIcons === 'function') {
        window.lucide.createIcons();
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initIcons);
} else {
    initIcons();
}
