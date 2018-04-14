import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';

Vue.use(VueRouter);

import App from './views/App';
import Home from './views/Home';
import ProductsComponent from './views/products/ProductsComponent';
import ProductsDashboard from './views/products/ProductsDashboard';
import ProductsInventoryAdd from './views/products/ProductsInventoryAdd';
import CategoriesSet from './views/categories/CategoriesSet';
import EbidCategoriesAdd from './views/ebid_categories/EbidCategoriesAdd';
import BonanzaCategoriesAdd from './views/bonanza_categories/BonanzaCategoriesAdd';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/products',
            name: 'products',
            component: ProductsComponent,
            children: [
                {
                    path: '/products/dashboard',
                    name: 'products.dashboard',
                    component: ProductsDashboard,
                },
                {
                    path: '/products/inventory/add',
                    name: 'products.inventory.add',
                    component: ProductsInventoryAdd,
                },
                {
                    path: '/categories/get',
                    name: 'categories.get',
                    component: CategoriesSet,
                },
                {
                    path: '/ebid_categories/add',
                    name: 'ebid_categories.add',
                    component: EbidCategoriesAdd,
                },
                {
                    path: '/bonanza_categories/add',
                    name: 'bonanza_categories.add',
                    component: BonanzaCategoriesAdd,
                },
            ]
        },
    ]
});


const app = new Vue({
    el: '#app',
    components: {
        App,
    },
    router
});