import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);
import firstPage from './components.vue/pages/myFirstVuePage';
import newRoutePage from './components.vue/pages/newRoutePage';
import hooks from './components.vue/pages/basic/hooks';
import methods from './components.vue/pages/basic/methods';

//admin project pages
import home from './admin/pages/home';
import tags from './admin/pages/tags';
import category from './admin/pages/category';

const routes = [

    // projects routes

    {
        path: "/",
        component: home
    },

    {
        path: "/tags",
        component: tags
    },
    {
        path: "/category",
        component: category
    },

    {
        path: '/my-new-vue-router',
        component: firstPage,
        name: "Home"
    },
    {
        path: '/new-route',
        component: newRoutePage
    },

    // vue hooks
    {
        path: "/hooks",
        component: hooks
    },
    // more basics - methods
    {
        path: "/methods",
        component: methods
    },
];
export default new Router({
    mode: 'history',
    routes
});