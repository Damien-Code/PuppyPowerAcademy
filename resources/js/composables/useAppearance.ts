import { ref } from 'vue';

type Appearance = 'light';  // Modified to only allow light

export function updateTheme() {
    if (typeof window === 'undefined') return;

    // Always remove dark class
    document.documentElement.classList.remove('dark');
}

export function initializeTheme() {
    if (typeof window === 'undefined') return;

    updateTheme();
}

export function useAppearance() {
    const appearance = ref<Appearance>('light');

    function updateAppearance() {
        appearance.value = 'light';
        localStorage.setItem('appearance', 'light');
        setCookie('appearance', 'light');
        updateTheme();
    }

    return {
        appearance,
        updateAppearance,
    };
}

const setCookie = (name: string, value: string, days = 365) => {
    if (typeof document === 'undefined') return;
    const maxAge = days * 24 * 60 * 60;
    document.cookie = `${name}=${value};path=/;max-age=${maxAge};SameSite=Lax`;
};
