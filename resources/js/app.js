// import './bootstrap';
// import '../css/app.css';

import { createApp, h } from 'vue';

import App from './App.vue';

function readEmail(message_id) {

    const appContainer = document.createElement('div');
    appContainer.classList.add('appContainer');
    document.body.appendChild(appContainer);

    const props = {
        message_id
    };
    const app = createApp(App, props).mount(appContainer);

    // receive custom event
    // $on is a custom event listener

    // app.$on('close', () => {
    //     app.$destroy();
    //     appContainer.remove();
    // });


    console.log('Email read', app);

    return app;
}

window.readEmail = readEmail;


// import { createInertiaApp } from '@inertiajs/inertia-vue3';
// import { InertiaProgress } from '@inertiajs/progress';
// import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
// import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

// const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
//     setup({ el, app, props, plugin }) {
//         return createApp({ render: () => h(app, props) })
//             .use(plugin)
//             .use(ZiggyVue, Ziggy)
//             .mount(el);
//     },
// });

// InertiaProgress.init({ color: '#4B5563' });
