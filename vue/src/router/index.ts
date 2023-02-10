import {createRouter, createWebHistory} from "vue-router";
import ProductView from '../views/ProductView.vue';
import SingleProductView from '../views/SingleProductView.vue'

const routes = [
    {
        path: '/',
        redirect: '/products',
    },
    {
        path: '/products',
        name: 'products',
        component: ProductView
    },
    {
        path: '/products/:id',
        name: 'singleProduct',
        component: SingleProductView
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
