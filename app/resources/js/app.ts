import '../css/app.css';
import 'primeicons/primeicons.css'
import './bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import { RotcPresets } from './presets/RotcPresets';
import { Ripple } from 'primevue';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import Tooltip from 'primevue/tooltip';

const appName = import.meta.env.VITE_APP_NAME;

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                ripple: true,
                theme: {
                    preset: RotcPresets,
                    options: {
                        prefix: 'p',
                        darkModeSelector: 'none',
                        cssLayer: false
                    }
                }
             })
             .use(ConfirmationService)
             .use(ToastService)
             .directive('ripple', Ripple)
             .directive('tooltip', Tooltip)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});