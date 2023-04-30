import { createStore } from "vuex";
import axiosClient from "../axios.js";

const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
        },

        dashboard: {
            loading: false,
            data: [],
        },

        kelas: {
            loading: false,
            links: [],
            data: [],
        },

        guru: {
            loading: false,
            links: [],
            data: [],
        },

        jadwal: {
            loading: false,
            links: [],
            data: {},
        },
        siswa: {
            loading: false,
            links: [],
            data: [],
        },

        sesi: {
            loading: false,
            data: [],
        },

        currentSiswa: {
            loading: false,
            data: {},
        },

        currentGuru: {
            loading: false,
            data: {},
        },

        currentKelas: {
            loading: false,
            data: {},
        },

        currentSesi: {
            loading: false,
            data: {},
        },

        currentJadwal: {
            loading: false,
            data: {},
        },

        presensi: {
            loading: false,
            data: [],
            total_hadir: 0,
            total_izin: 0,
            total_alpha: 0,
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

        cariGuru({ commit }, id) {
            commit("setCurrentGuruLoading", true);
            return axiosClient
                .get(`/guru/${id}`)
                .then((res) => {
                    commit("setCurrentGuru", res.data);
                    commit("setCurrentGuruLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentGuruLoading", false);
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

        showKelas({ commit }, id) {
            commit("setCurrentKelasLoading", true);
            return axiosClient
                .get(`/kelas/${id}`)
                .then((res) => {
                    commit("setCurrentKelas", res.data);
                    commit("setCurrentKelasLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentKelasLoading", false);
                    throw err;
                });
        },

        showSesi({ commit }, id) {
            commit("setCurrentSesiLoading", true);
            return axiosClient
                .get(`/sesi/${id}`)
                .then((res) => {
                    commit("setCurrentSesi", res.data);
                    commit("setCurrentSesiLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentSesiLoading", false);
                    throw err;
                });
        },

        showJadwal({ commit }, id) {
            commit("setCurrentJadwalLoading", true);
            return axiosClient
                .get(`/jadwal/${id}`)
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

        searchFilterGuru({ commit }, query) {
            commit("setGuruLoading", true);
            return axiosClient
                .get("/searchFilterGuru?query=" + query)
                .then((res) => {
                    commit("setGuru", res.data);
                    commit("setGuruLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setGuruLoading", false);
                    throw err;
                });
        },

        getGuru({ commit }, { url = null } = {}) {
            url = url || "/guru";
            commit("setGuruLoading", true);
            return axiosClient
                .get(url)
                .then((res) => {
                    commit("setGuru", res.data);
                    commit("setGuruLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setGuruLoading", false);
                    throw err;
                });
        },

        kosongkanPresensi({ commit }) {
            commit("setPresensiLoading", true);
            commit("setPresensiKosong");
            commit("setPresensiLoading", false);
        },

        searchFilterSiswa({ commit }, query) {
            commit("setSiswaLoading", true);
            return axiosClient
                .get("/searchFilterSiswa?query=" + query)
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

        getSiswa({ commit }, { url = null } = {}) {
            url = url || "/siswa";
            commit("setSiswaLoading", true);
            return axiosClient
                .get(url)
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
        searchFilterKelas({ commit }, query) {
            commit("setKelasLoading", true);
            return axiosClient
                .get("/searchFilterKelas?query=" + query)
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

        getKelas({ commit }, { url = null } = {}) {
            url = url || "/kelas";
            commit("setKelasLoading", true);
            return axiosClient
                .get(url)
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

        searchFilterJadwal({ commit }, query) {
            commit("setJadwalLoading", true);
            return axiosClient
                .get("/searchFilterJadwal?query=" + query)
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

        getJadwal({ commit }, { url = null } = {}) {
            url = url || "/jadwal";
            commit("setJadwalLoading", true);
            return axiosClient
                .get(url)
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

        getDashboardData({ commit }) {
            commit("setDashboardLoading", true);
            return axiosClient
                .get(`/totalData`)
                .then((res) => {
                    commit("setDashboard", res.data);
                    commit("setDashboardLoading", false);
                    return res;
                })
                .catch((err) => {
                    commit("setDashboardLoading", false);
                    throw err;
                });
        },

        getUser({ commit }) {
            return axiosClient.get("/user").then((res) => {
                commit("setUser", res.data);
            });
        },

        cariPresensi({ commit }, presensi) {
            let response;
            commit("setPresensiLoading", true);

            return axiosClient.post("/detailPresensi", presensi).then((res) => {
                commit("setPresensiLoading", false);
                if (res.request.status == 200) {
                    commit("setPresensi", res.data);
                } else {
                    commit("setPresensiKosong");
                }
                return res;
            });
        },

        updateGuru({ commit }, guru) {
            let response;
            commit("setCurrentGuruLoading", true);
            return axiosClient
                .put(`/guru/${guru.nip_guru}`, guru)
                .then((res) => {
                    commit("setCurrentGuruLoading", false);
                    if (res.request.status == 200) {
                        commit("setCurrentGuru", res.data);
                    }
                    return res;
                });
        },

        updateSiswa({ commit }, siswa) {
            let response;
            commit("setCurrentSiswaLoading", true);

            return axiosClient
                .put(`/siswa/${siswa.nis_siswa}`, siswa)
                .then((res) => {
                    commit("setCurrentSiswaLoading", false);
                    if (res.request.status == 200)
                        commit("setCurrentSiswa", res.data);
                    return res;
                });
        },

        updateKelas({ commit }, kelas) {
            let response;
            commit("setCurrentKelasLoading", true);
            return axiosClient
                .put(`/kelas/${kelas.kode_kelas}`, kelas)
                .then((res) => {
                    commit("setCurrentKelasLoading", false);
                    if (res.request.status == 200)
                        commit("editSiswa", res.data);
                    return res;
                });
        },

        kosongkanKelas({ commit }, kode_kelas) {
            let response;
            response = axiosClient
                .put(`/kosongkanKelas/${kode_kelas}`)
                .then((res) => {
                    commit("notify", {
                        type: "success",
                        message: "Kosongkan Kelas berhasil!",
                    });
                    commit("setCurrentSesi", res.data);
                    return res;
                });
        },

        hapusWaliKelas({ commit }, nip_guru) {
            let response;
            response = axiosClient
                .put(`/hapusWaliKelas/${nip_guru}`)
                .then((res) => {
                    commit("notify", {
                        type: "success",
                        message: "Hapus wali kelas berhasil!",
                    });
                    commit("setCurrentSesi", res.data);
                    return res;
                });
            return response;
        },

        updateSesi({ commit }, sesi) {
            commit("setCurrentSesiLoading", true);
            let response;
            return axiosClient.put(`/sesi/${sesi.id}`, sesi).then((res) => {
                commit("setCurrentSesiLoading", false);
                if (res.request.status == 200)
                    commit("setCurrentSesi", res.data);
                return res;
            });
        },

        updateJadwal({ commit }, jadwal) {
            let response;
            commit("setCurrentJadwalLoading", true);
            return axiosClient
                .put(`/jadwal/${jadwal.kode_jadwal}`, jadwal)
                .then((res) => {
                    commit("setCurrentJadwalLoading", false);
                    if (res.request.status == 200)
                        commit("setCurrentJadwal", res.data);
                    return res;
                });
        },

        tambahGuru({ commit }, guru) {
            let response;
            commit("setCurrentGuruLoading", true);

            return axiosClient.post("/guru", guru).then((res) => {
                commit("setCurrentGuruLoading", false);
                if (res.request.status == 200) {
                    commit("setCurrentGuru", res.data);
                }
                return res;
            });
        },

        tambahSiswa({ commit }, siswa) {
            let response;
            commit("setCurrentSiswaLoading", true);

            return axiosClient.post("/siswa", siswa).then((res) => {
                commit("setCurrentSiswaLoading", false);
                if (res.request.status == 200)
                    commit("setCurrentSiswa", res.data);
                return res;
            });
        },

        tambahKelas({ commit }, kelas) {
            let response;
            commit("setCurrentKelasLoading", true);
            return axiosClient.post("/kelas", kelas).then((res) => {
                commit("setCurrentKelasLoading", false);
                if (res.request.status == 200)
                    commit("setCurrentKelas", res.data);
                return res;
            });
        },

        tambahSesi({ commit }, sesi) {
            let response;
            commit("setCurrentSesiLoading", true);
            return axiosClient.post("/sesi", sesi).then((res) => {
                commit("setCurrentSesiLoading", false);
                if (res.request.status == 200)
                    commit("setCurrentSesi", res.data);
                return res;
            });
        },

        tambahJadwal({ commit }, sesi) {
            let response;
            commit("setCurrentJadwalLoading", true);
            return axiosClient.post("/jadwal", sesi).then((res) => {
                commit("setCurrentJadwalLoading", false);
                if (res.request.status == 200)
                    commit("setCurrentJadwal", res.data);
                return res;
            });
        },

        deleteGuru({}, nip_guru) {
            return axiosClient.delete(`/guru/${nip_guru}`);
        },

        deleteSiswa({}, nis_siswa) {
            return axiosClient.delete(`/siswa/${nis_siswa}`);
        },

        deleteKelas({}, kode_kelas) {
            return axiosClient.delete(`/kelas/${kode_kelas}`);
        },

        deleteSesi({}, id) {
            return axiosClient.delete(`/sesi/${id}`);
        },

        deleteJadwal({}, id) {
            return axiosClient.delete(`/jadwal/${id}`);
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

        setDashboardLoading: (state, loading) => {
            state.dashboard.loading = loading;
        },

        setDashboard: (state, dashboard) => {
            state.dashboard.data = dashboard.data;
        },

        setGuruLoading: (state, loading) => {
            state.guru.loading = loading;
        },

        setGuru: (state, guru) => {
            state.guru.data = guru.data;
            state.guru.links = guru.meta.links;
        },

        setKelasLoading: (state, loading) => {
            state.kelas.loading = loading;
        },

        setKelas: (state, kelas) => {
            state.kelas.data = kelas.data;
            state.kelas.links = kelas.links;
        },

        setJadwalLoading: (state, loading) => {
            state.jadwal.loading = loading;
        },

        setJadwal: (state, jadwal) => {
            state.jadwal.data = jadwal.data;
            state.jadwal.links = jadwal.links;
        },

        setSiswaLoading: (state, loading) => {
            state.siswa.loading = loading;
        },

        setSiswa: (state, siswa) => {
            state.siswa.data = siswa.data;
            state.siswa.links = siswa.meta.links;
        },

        setSesiLoading: (state, loading) => {
            state.sesi.loading = loading;
        },

        setSesi: (state, sesi) => {
            state.sesi.data = sesi.data;
        },

        setPresensiLoading: (state, loading) => {
            state.presensi.loading = loading;
        },

        setPresensi: (state, presensi) => {
            state.presensi.data = presensi.data;
            state.presensi.total_hadir = presensi.total_hadir;
            state.presensi.total_izin = presensi.total_izin;
            state.presensi.total_alpha = presensi.total_alpha;
        },

        setPresensiKosong: (state, presensi) => {
            state.presensi.data = [];
            state.presensi.total_hadir = 0;
            state.presensi.total_izin = 0;
            state.presensi.total_alpha = 0;
        },

        setCurrentGuruLoading: (state, loading) => {
            state.currentGuru.loading = loading;
        },

        setCurrentGuru: (state, currentGuru) => {
            state.currentGuru.data = currentGuru.data;
        },

        setCurrentSiswaLoading: (state, loading) => {
            state.currentSiswa.loading = loading;
        },

        setCurrentSiswa: (state, currentSiswa) => {
            state.currentSiswa.data = currentSiswa.data;
        },

        setCurrentKelasLoading: (state, loading) => {
            state.currentKelas.loading = loading;
        },

        setCurrentKelas: (state, currentKelas) => {
            state.currentKelas.data = currentKelas.data;
        },

        setCurrentSesiLoading: (state, loading) => {
            state.currentSesi.loading = loading;
        },

        setCurrentSesi: (state, currentSesi) => {
            state.currentSesi.data = currentSesi.data;
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
