import { createStore } from "vuex";
import axiosClient from "../axios.js";

const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
        },

        currentGuru: {
            loading: false,
            data: {},
        },

        kelas: {
            loading: false,
            data: {},
        },

        jadwal: {
            loading: false,
            data: {},
        },
        siswa: {
            loading: false,
            data: [],
        },

        sesi: {
            loading: false,
            data: {},
        },

        keterangan_absensi: {
            loading: false,
            data: [],
        },

        currentSiswa: {
            loading: false,
            data: {},
        },

        currentJadwal: {
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
            return axiosClient.post("/login", user).then(({ data }) => {
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

        showSiswaByKelas({ commit }, id) {
            commit("setSiswaLoading", true);
            return axiosClient
                .get(`/showSiswaByKelas/${id}`)
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

        showSiswa({ commit }, id) {
            commit("setCurrentSiswaLoading", true);
            return axiosClient
                .get(`/siswa/${id}`)
                .then((res) => {
                    commit("setCurrentSiswa", res.data);
                    commit("setCurrentSiswaLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentSiswaLoading", false);
                    throw err;
                });
        },

        keteranganAbsensiById({ commit }, id) {
            commit("setKeteranganAbsensiLoading", true);
            return axiosClient
                .get(`/keteranganabsensibyid/${id}`)
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

        getGuruProfile({ commit }) {
            commit("setCurrentGuruProfileLoading", true);
            return axiosClient
                .get(`/guruProfile`)
                .then((res) => {
                    commit("setCurrentGuru", res.data);
                    commit("setCurrentGuruProfileLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentGuruProfileLoading", false);
                    throw err;
                });
        },

        getSesi({ commit }) {
            commit("setSesiLoading", true);
            return axiosClient
                .get(`/sesi`)
                .then((res) => {
                    commit("setSesi", res.data);
                    commit("setSesiLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setSesiLoading", false);
                    throw err;
                });
        },

        getKelasAnda({ commit }) {
            commit("setKelasLoading", true);
            return axiosClient
                .get(`/kelasAnda`)
                .then((res) => {
                    commit("setKelas", res.data);
                    commit("setKelasLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setKelasLoading", false);
                    throw err;
                });
        },

        getJadwal({ commit }) {
            commit("setJadwalLoading", true);
            return axiosClient
                .get(`/jadwal`)
                .then((res) => {
                    commit("setJadwal", res.data);
                    commit("setJadwalLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setJadwalLoading", false);
                    throw err;
                });
        },

        getJadwalPage({ commit }) {
            commit("setCurrentJadwalLoading", true);
            return axiosClient
                .get(`/jadwalGuru`)
                .then((res) => {
                    commit("setCurrentJadwal", res.data);
                    commit("setCurrentJadwalLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentJadwalLoading", false);
                    throw err;
                });
        },

        getUser({ commit }) {
            return axiosClient.get("/user").then((res) => {
                commit("setUser", res.data);
            });
        },

        getPDF({ commit }) {
            commit("setKelasLoading", true);
            return axiosClient
                .get("/create-pdf-file", { responseType: "arraybuffer" })
                .then((res) => {
                    commit("setKelasLoading", false);
                    let blob = new Blob([res.data], {
                            type: "application/pdf",
                        }),
                        url = window.URL.createObjectURL(blob);

                    let link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "Rekapitulasi Presensi.pdf";
                    link.click();
                    window.open(link);
                });
        },

        updateProfile({ commit }, currentGuru) {
            let response;
            commit("setCurrentGuruProfileLoading", true);
            response = axiosClient
                .put("/updateProfile", currentGuru)
                .then((res) => {
                    commit("setCurrentGuruProfileLoading", false);
                    commit("notify", {
                        type: "success",
                        message: res.data.message,
                    });
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentGuruProfileLoading", false);
                    commit("notify", {
                        type: "failed",
                        message: err.response.data.message,
                    });
                    throw err;
                });
        },

        updatePassword({ commit }, data) {
            let response;
            commit("setCurrentGuruProfileLoading", true);
            response = axiosClient
                .post("/gantiPassword", data)
                .then((res) => {
                    commit("setCurrentGuruProfileLoading", false);
                    commit("notify", {
                        type: "success",
                        message: res.data.message,
                    });
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentGuruProfileLoading", false);
                    commit("notify", {
                        type: "failed",
                        message: err.response.data.error,
                    });
                    throw err;
                });
        },

        absen({ commit }, data) {
            let response;

            response = axiosClient
                .post("/absen", data)
                .then((res) => {
                    commit("notify", {
                        type: "success",
                        message: "Presensi Berhasil Dilakukan!",
                    });

                    return res;
                })
                .catch((err) => {
                    commit("notify", {
                        type: "failed",
                        message: err.response.data.message,
                    });
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

        setCurrentGuruProfileLoading: (state, loading) => {
            state.currentGuru.loading = loading;
        },

        setCurrentGuru: (state, guru) => {
            state.currentGuru.data = guru.data;
        },

        setKelasLoading: (state, loading) => {
            state.kelas.loading = loading;
        },

        setKelas: (state, kelas) => {
            state.kelas.data = kelas.data;
        },

        setJadwalLoading: (state, loading) => {
            state.jadwal.loading = loading;
        },

        setJadwal: (state, jadwal) => {
            state.jadwal.data = jadwal.data;
        },

        setSiswaLoading: (state, loading) => {
            state.siswa.loading = loading;
        },

        setSiswa: (state, siswa) => {
            state.siswa.data = siswa.data;
        },

        setCurrentSiswaLoading: (state, loading) => {
            state.currentSiswa.loading = loading;
        },

        setCurrentSiswa: (state, currentSiswa) => {
            state.currentSiswa.data = currentSiswa.data;
        },

        setSesiLoading: (state, loading) => {
            state.sesi.loading = loading;
        },

        setSesi: (state, sesi) => {
            state.sesi.data = sesi.data;
        },

        setKeteranganAbsensiLoading: (state, loading) => {
            state.keterangan_absensi.loading = loading;
        },

        setKeteranganAbsensi: (state, keterangan_absensi) => {
            state.keterangan_absensi.data = keterangan_absensi.data;
        },

        setCurrentJadwalLoading: (state, loading) => {
            state.currentJadwal.loading = loading;
        },

        setCurrentJadwal: (state, currentJadwal) => {
            state.currentJadwal.data = currentJadwal.data;
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
