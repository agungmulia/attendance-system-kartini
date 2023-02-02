import { createRouter, createWebHistory } from "vue-router";

import store from "../store/index.js";

import Login from "../views/Login.vue";
import DefaultLayout from "../components/DefaultLayout.vue";

import Dashboard from "../views/Dashboard.vue";
import Jadwal from "../views/Jadwal.vue";
import Rekapitulasi from "../views/Rekapitulasi.vue";
import Profil from "../views/Profil.vue";

import Absen from "../views/Absen.vue";
import Siswa from "../views/Siswa.vue";

const routes = [
    {
        path: "/",
        redirect: "/dashboard",
        component: DefaultLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: "/dashboard",
                name: "Dashboard",
                component: Dashboard,
            },
            {
                path: "/rekapitulasi",
                name: "Rekapitulasi",
                component: Rekapitulasi,
            },
            {
                path: "/jadwal",
                name: "Jadwal",
                component: Jadwal,
            },
            {
                path: "/profil",
                name: "Profil",
                component: Profil,
            },
            {
                path: "/absen/:id",
                name: "Absensi",
                component: Absen,
            },

            {
                path: "/siswa",
                name: "Siswa",
                component: Siswa,
            },
            {
                path: "/siswa/:id",
                name: "Siswa",
                component: Siswa,
            },
        ],
    },

    {
        path: "/login",
        name: "Login",
        meta: { isGuest: true },
        component: Login,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: "Login" });
    } else if (store.state.user.token && to.meta.isGuest) {
        next({ name: "Dashboard" });
    } else {
        next();
    }
});
export default router;
