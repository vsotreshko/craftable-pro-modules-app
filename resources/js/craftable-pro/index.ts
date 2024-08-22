import { App, createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/vue3";
import { autoAnimatePlugin } from "@formkit/auto-animate/vue";
import Toast, { POSITION } from "@brackets/vue-toastification";
import "@brackets/vue-toastification/dist/index.css";
import { ZiggyVue } from "ziggy/src/js/vue";
import { AuthenticatedLayout, GuestLayout } from "craftable-pro/Layouts";
import { Notification } from "craftable-pro/Components";
import {
    i18nVue,
    loadTranslations,
} from "craftable-pro/plugins/laravel-vue-i18n";
import { can } from "craftable-pro/plugins/can";
import { PageProps } from "craftable-pro/types/page";

const appName = "Craftable PRO";

const lang = document.documentElement.lang
    ? document.documentElement.lang.replace("-", "_")
    : "en";

export default async function loadModulesComponents(app: App) {
    // All Shared Components from modules
    const componentsGlob = import.meta.glob(
        "../../../vendor/brackets/**/resources/js/Components/Shared/*.vue",
        { eager: true }
    );

    const [components] = await Promise.all([componentsGlob]);

    // Registering Shared components as global components to the app
    Object.keys(components).forEach((path: string) => {
        const pathParts = path.split("/").at(-1);
        if (pathParts) {
            const componentName = pathParts.split(".")[0];
            app.component(`${componentName}`, components[path].default);
        }
    });
}

createInertiaApp({
    title: (title) => {
        const titleElement = document.querySelector("title");

        if (titleElement && !titleElement.hasAttribute("inertia")) {
            titleElement.remove();
        }

        return title ? `${title} - ${appName}` : appName;
    },
    progress: { color: "#4B5563" },
    resolve: async (name) => {
        const pagesCoreGlob = import.meta.glob(
            "../../../vendor/brackets/**/resources/js/Pages/**/*.vue"
        );

        const pagesLocalGlob = import.meta.glob("./Pages/**/*.vue");

        const [pagesCore, pagesLocal] = await Promise.all([
            pagesCoreGlob,
            pagesLocalGlob,
        ]);

        const pages = { ...pagesLocal, ...pagesCore };

        const pagePath = Object.keys(pages).find((key) =>
            key.endsWith(`/${name}.vue`)
        );

        if (!pagePath) {
            throw new Error(`Page '${name}' not found.`);
        }

        const pageComponent = (await pages[pagePath]()).default;

        const page = pageComponent || {
            layout: name.startsWith("Auth/")
                ? GuestLayout
                : AuthenticatedLayout,
        };

        if (page.layout === undefined) {
            if (name.startsWith("Auth/")) {
                page.layout = GuestLayout;
            } else {
                page.layout = AuthenticatedLayout;
            }
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        loadTranslations(
            `/lang/${
                (props.initialPage.props.auth as PageProps["auth"])?.user
                    ?.locale ?? lang
            }/craftable-pro.json`,
            async (translations: JSON) => {
                const app = createApp({ render: () => h(App, props) })
                    .use(plugin)
                    .use(Toast, {
                        transition: "Vue-Toastification__fade",
                        rootComponent: Notification,
                        position: POSITION.BOTTOM_RIGHT,
                    })
                    .use(i18nVue, {
                        resolve: (lang: string) => {
                            return translations;
                        },
                    })
                    .use(autoAnimatePlugin)
                    .use(ZiggyVue)
                    .component("Link", Link)
                    .directive("can", can);

                await loadModulesComponents(app);

                return app.mount(el);
            }
        );
    },
});
