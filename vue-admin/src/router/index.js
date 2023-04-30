import { createRouter, createWebHistory } from "vue-router";

import store from "../store/index.js";

import Login from "../views/Login.vue";
import DefaultLayout from "../components/DefaultLayout.vue";

import Dashboard from "../views/Dashboard.vue";
import Jadwal from "../views/Jadwal.vue";

import Guru from "../views/Guru.vue";
import Siswa from "../views/Siswa.vue";
import Kelas from "../views/Kelas.vue";
import Sesi from "../views/Sesi.vue";
import Presensi from "../views/Presensi.vue";

import GuruForm from "../views/GuruForm.vue";
import SiswaForm from "../views/SiswaForm.vue";
import KelasForm from "../views/KelasForm.vue";
import SesiForm from "../views/SesiForm.vue";
import JadwalForm from "../views/JadwalForm.vue";

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
                path: "/jadwal",
                name: "Jadwal",
                component: Jadwal,
            },
            {
                path: "/editjadwal/:id",
                name: "EditJadwal",
                component: JadwalForm,
            },
            {
                path: "/tambahjadwal",
                name: "TambahJadwal",
                component: JadwalForm,
            },
            {
                path: "/guru",
                name: "Guru",
                component: Guru,
            },
            {
                path: "/tambahguru",
                name: "TambahGuru",
                component: GuruForm,
            },
            {
                path: "/editguru/:id",
                name: "EditGuru",
                component: GuruForm,
            },
            {
                path: "/siswa",
                name: "Siswa",
                component: Siswa,
            },

            {
                path: "/tambahsiswa",
                name: "TambahSiswa",
                component: SiswaForm,
            },
            {
                path: "/editsiswa/:id",
                name: "EditSiswa",
                component: SiswaForm,
            },
            {
                path: "/kelas",
                name: "Kelas",
                component: Kelas,
            },
            {
                path: "/editkelas/:id",
                name: "EditKelas",
                component: KelasForm,
            },
            {
                path: "/tambahkelas",
                name: "TambahKelas",
                component: KelasForm,
            },
            {
                path: "/sesi",
                name: "Sesi",
                component: Sesi,
            },
            {
                path: "/editsesi/:id",
                name: "EditSesi",
                component: SesiForm,
            },
            {
                path: "/tambahsesi",
                name: "TambahSesi",
                component: SesiForm,
            },
            {
                path: "/presensi",
                name: "Presensi",
                component: Presensi,
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
