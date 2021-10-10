require('./bootstrap');
window.Vue = require('vue').default;

import Vue from 'vue';
import Router from 'vue-router';
import FormLogin from './components/Auth/FormLogin';
import BookInStock from './components/Borrower/BookInStock';
import FormRegister from './components/Auth/FormRegister';
import UserBorrowed from './components/Borrower/Borrowed';
import AdminBorrowRequest from './components/Admin/BorrowRequest';
import AdminApproved from './components/Admin/Approved';
import AdminBorrowed from './components/Admin/Borrowed';
import AdminBooks from './components/Admin/Books';
import AdminStatus from './components/Admin/Status';
import FormBook from './components/Admin/FormBook';
import Unauth from './components/Auth/Unauth';
import * as authHelper from './helper/authHelper';

Vue.use(Router);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('navbar-user', require('./components/Template/NavbarUser.vue').default);

const routerList = new Router({
    mode: 'history',
    routes: [
        {
            path: '/login',
            name: 'login',
            component: FormLogin,
        },
        {
            path: '/register',
            name: 'register',
            component: FormRegister
        },
        {
            path: '/borrower/book-in-stock',
            name: 'bookInStock',
            component: BookInStock,
            meta: {
                middleware: ['user']
            }
        },
        {
            path: '/borrower/borrowed',
            name: 'userBorrowed',
            component: UserBorrowed,
            meta: {
                middleware: ['user']
            }
        },
        {
            path: '/admin/borrow-request',
            name: 'borrowRequest',
            component: AdminBorrowRequest,
            meta: {
                middleware: ['admin']
            }
        }
        ,
        {
            path: '/admin/borrow-approve',
            name: 'borrowApproved',
            component: AdminApproved,
            meta: {
                middleware: ['admin']
            }
        }
        ,
        {
            path: '/admin/borrow-borrowed',
            name: 'borrowBorrowed',
            component: AdminBorrowed,
            meta: {
                middleware: ['admin']
            }
        }
        ,
        {
            path: '/admin/status',
            name: 'status',
            component: AdminStatus,
            meta: {
                middleware: ['admin']
            }
        },
        {
            path: '/admin/books',
            name: 'books',
            component: AdminBooks,
            meta: {
                middleware: ['admin']
            }
        },
        {
            path: '/admin/books/create',
            name: 'booksCreate',
            component: FormBook,
            meta: {
                middleware: ['admin']
            }
        },
        {
            path: '/admin/books/update/:idBook',
            name: 'booksUpdate',
            component: FormBook,
            meta: {
                middleware: ['admin']
            }
        },
        {
            path: '/401',
            name: 'unauth',
            component: Unauth,
        },

    ]
});

const isLogin = () => authHelper.token() ? true : false;
const role = () =>authHelper.getRole();

routerList.beforeEach((to, from, next) => {
    if (to.meta.middleware) {
        switch (to.meta.middleware[0]) {
            case 'admin':
                if (!isLogin() || role() != 'admin') {
                    next({ name: 'unauth' });
                }
                break;

            case 'user':
                if (!isLogin() || role() != 'user') {
                    next({ name: 'unauth' });
                }
                break;
        }
    }
    return next();
});

const app = new Vue({
    el: '#app',
    router: routerList
});
