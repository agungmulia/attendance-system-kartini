import { createStore } from "vuex";
import axiosClient from "../axios.js";

const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
        },

        siswa: {
            loading: false,
            data: [],
        },

        tahunAjaranPresensi: {
            loading: false,
            data: {},
        },

        presensiSiswa: {
            loading: false,
            data: {},
        },

        absen: {
            loading: false,
            data: [],
        },

        keterangan_absensi: {
            loading: false,
            data: [],
        },

        notification: {
            show: false,
            type: "success",
            message: "",
        },
    },
    getters: {},
    actions: {
        login({ commit }, user) {
            return axiosClient.post("/loginsiswa", user).then(({ data }) => {
                commit("setUser", data.user);
                commit("setToken", data.token);
                return data;
            });
        },
        logout({ commit }) {
            return axiosClient.post("/logout").then((response) => {
                commit("logout");
                return response;
            });
        },

        getDataAbsen({ commit }, { url = null } = {}) {
            commit("setAbsenLoading", true);
            return axiosClient
                .get("/dataAbsen")
                .then((res) => {
                    commit("setAbsen", res.data);
                    commit("setAbsenLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setAbsenLoading", false);
                    throw err;
                });
        },

        getTahunAjaranPresensi({ commit }) {
            return axiosClient.get(`/tahunPresensi`).then((res) => {
                commit("setTahunAjaranPresensi", res.data);
                return res;
            });
        },

        kosongkanPresensi({ commit }) {
            commit("setPresensiKosong");
        },

        presensiSiswa({ commit }, tahun) {
            commit("setPresensiSiswaLoading", true);
            return axiosClient
                .get(`presensiSiswa/${tahun}`)
                .then((res) => {
                    commit("setPresensiSiswa", res.data);
                    commit("setPresensiSiswaLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setPresensiSiswaLoading", false);
                    throw err;
                });
        },

        getKeteranganAbsensi({ commit }) {
            commit("setKeteranganAbsensiLoading", true);
            return axiosClient
                .get(`/dataIzin`)
                .then((res) => {
                    commit("setKeteranganAbsensi", res.data);
                    commit("setKeteranganAbsensiLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setKeteranganAbsensi", err.response.data);
                    commit("setKeteranganAbsensiLoading", false);
                    throw err;
                });
        },

        getSiswaProfile({ commit }) {
            commit("setSiswaLoading", true);
            return axiosClient
                .get(`/profilsiswa`)
                .then((res) => {
                    commit("setSiswa", res.data);
                    commit("setSiswaLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setSiswaLoading", false);
                    throw err;
                });
        },

        getUser({ commit }) {
            return axiosClient.get("/userSiswa").then((res) => {
                commit("setUser", res.data);
            });
        },

        updateProfile({ commit }, siswa) {
            let response;
            commit("setCurrentGuruProfileLoading", true);
            response = axiosClient
                .put("/updateProfileSiswa", siswa)
                .then((res) => {
                    commit("setSiswaLoading", false);
                    commit("notify", {
                        type: "success",
                        message: "Update Profil Berhasil!",
                    });
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentSiswaLoading", false);
                    commit("notify", {
                        type: "failed",
                        message: err.response.data.message,
                    });
                    throw err;
                });
        },

        updatePassword({ commit }, data) {
            let response;
            commit("setSiswaLoading", true);
            response = axiosClient
                .post("/gantiPasswordSiswa", data)
                .then((res) => {
                    commit("notify", {
                        type: "success",
                        message: "Ganti Password Berhasil!",
                    });
                    commit("setSiswaLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("notify", {
                        type: "failed",
                        message: err.response.data.error,
                    });
                    commit("setSiswaLoading", false);
                    throw err;
                });
        },
    },
    mutations: {
        logout: (state) => {
            state.user.token = null;
            state.user.data = {};
            sessionStorage.removeItem("TOKEN");
        },
        setUser: (state, user) => {
            state.user.data = user;
        },

        setToken: (state, token) => {
            state.user.token = token;
            sessionStorage.setItem("TOKEN", token);
        },

        setSiswaLoading: (state, loading) => {
            state.siswa.loading = loading;
        },

        setSiswa: (state, siswa) => {
            state.siswa.data = siswa.data;
        },

        setAbsenLoading: (state, loading) => {
            state.absen.loading = loading;
        },

        setAbsen: (state, absen) => {
            state.absen.data = absen.data;
        },

        setKeteranganAbsensiLoading: (state, loading) => {
            state.keterangan_absensi.loading = loading;
        },

        setTahunAjaranPresensi: (state, tahunAjaranPresensi) => {
            state.tahunAjaranPresensi.data = tahunAjaranPresensi.data;
        },

        setKeteranganAbsensi: (state, keterangan_absensi) => {
            state.keterangan_absensi.data = keterangan_absensi.data;
        },

        setPresensiSiswaLoading: (state, loading) => {
            state.presensiSiswa.loading = loading;
        },

        setPresensiSiswa: (state, presensiSiswa) => {
            state.presensiSiswa.data = presensiSiswa.data;
        },

        setPresensiKosong: (state, presensiSiswa) => {
            state.presensiSiswa.data = {};
        },

        notify: (state, { message, type }) => {
            state.notification.show = true;
            state.notification.type = type;
            state.notification.message = message;
            setTimeout(() => {
                state.notification.show = false;
            }, 2500);
        },
    },
    modules: {},
});

export default store;
