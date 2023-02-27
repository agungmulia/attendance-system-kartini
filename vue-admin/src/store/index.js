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
            data: [],
        },

        guru: {
            loading: false,
            links: [],
            data: [],
        },

        jadwal: {
            loading: false,
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
                    // commit("setGuru", err.response.data);
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

        getKelas({ commit }) {
            commit("setKelasLoading", true);
            return axiosClient
                .get(`/kelas`)
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

        updateGuru({ commit }, guru) {
            let response;
            response = axiosClient
                .put(`/guru/${guru.nip_guru}`, guru)
                .then((res) => {
                    commit("setCurrentGuruLoading", false);
                    commit("notify", {
                        type: "success",
                        message: "Ubah data guru berhasil dilakukan!",
                    });
                    commit("editGuru", res.data);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentGuruLoading", false);
                    commit("notify", {
                        type: "failed",

                        message: err.response.data.message,
                    });
                    throw err;
                });
        },

        updateSiswa({ commit }, siswa) {
            let response;
            response = axiosClient
                .put(`/siswa/${siswa.nis_siswa}`, siswa)
                .then((res) => {
                    commit("setCurrentSiswaLoading", false);
                    commit("notify", {
                        type: "success",
                        message: "Ubah data siswa berhasil dilakukan!",
                    });
                    commit("editSiswa", res.data);
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

        updateKelas({ commit }, kelas) {
            let response;
            response = axiosClient
                .put(`/kelas/${kelas.kode_kelas}`, kelas)
                .then((res) => {
                    commit("setCurrentKelasLoading", false);
                    commit("notify", {
                        type: "success",
                        message: "Ubah data siswa berhasil dilakukan!",
                    });
                    commit("editSiswa", res.data);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentKelasLoading", false);
                    commit("notify", {
                        type: "failed",

                        message: err.response.data.message,
                    });
                    throw err;
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
                    commit("editSiswa", res.data);
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

        updateSesi({ commit }, sesi) {
            let response;
            response = axiosClient
                .put(`/sesi/${sesi.id}`, sesi)
                .then((res) => {
                    commit("setCurrentSesiLoading", false);
                    commit("notify", {
                        type: "success",
                        message: "Ubah data sesi berhasil dilakukan!",
                    });
                    commit("editSiswa", res.data);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentSesiLoading", false);
                    commit("notify", {
                        type: "failed",

                        message: err.response.data.message,
                    });
                    throw err;
                });
        },

        updateJadwal({ commit }, jadwal) {
            let response;
            response = axiosClient
                .put(`/jadwal/${jadwal.kode_jadwal}`, jadwal)
                .then((res) => {
                    commit("setCurrentJadwalLoading", false);
                    commit("notify", {
                        type: "success",
                        message: "Ubah data jadwal berhasil dilakukan!",
                    });
                    commit("editJadwal", res.data);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentJadwalLoading", false);
                    commit("notify", {
                        type: "failed",

                        message: err.response.data.message,
                    });
                    throw err;
                });
        },

        tambahGuru({ commit }, guru) {
            let response;
            commit("setCurrentGuruLoading", true);

            response = axiosClient
                .post("/guru", guru)
                .then((res) => {
                    commit("setCurrentGuruLoading", false);
                    commit("tambahGuru", res.data);
                    commit("notify", {
                        type: "success",
                        message: "Tambah data guru berhasil dilakukan!",
                    });
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentGuruLoading", false);
                    commit("notify", {
                        type: "failed",
                        message: err.response.data.message,
                    });
                    throw err;
                });
        },

        tambahSiswa({ commit }, siswa) {
            let response;
            commit("setCurrentSiswaLoading", true);

            response = axiosClient
                .post("/siswa", siswa)
                .then((res) => {
                    commit("setCurrentSiswaLoading", false);
                    commit("tambahSiswa", res.data);
                    commit("notify", {
                        type: "success",
                        message: "Tambah data siswa berhasil dilakukan!",
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

        tambahKelas({ commit }, kelas) {
            let response;
            commit("setCurrentKelasLoading", true);
            response = axiosClient
                .post("/kelas", kelas)
                .then((res) => {
                    commit("notify", {
                        type: "success",
                        message: "Tambah data kelas berhasil dilakukan!",
                    });
                    commit("setCurrentKelasLoading", false);
                    commit("tambahKelas", res.data);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentKelasLoading", false);
                    commit("notify", {
                        type: "failed",
                        message: err.response.data.message,
                    });
                    throw err;
                });
        },

        tambahSesi({ commit }, sesi) {
            let response;
            commit("setCurrentSesiLoading", true);
            response = axiosClient
                .post("/sesi", sesi)
                .then((res) => {
                    commit("notify", {
                        type: "success",
                        message: "Tambah data sesi berhasil dilakukan!",
                    });
                    commit("setCurrentSesiLoading", false);
                    commit("tambahSesi", res.data);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentSesiLoading", false);
                    commit("notify", {
                        type: "failed",
                        message: err.response.data.message,
                    });
                    throw err;
                });
        },

        tambahJadwal({ commit }, sesi) {
            let response;
            commit("setCurrentJadwalLoading", true);
            response = axiosClient
                .post("/jadwal", sesi)
                .then((res) => {
                    commit("notify", {
                        type: "success",
                        message: "tambah data jadwal berhasil dilakukan!",
                    });
                    commit("setCurrenJadwalLoading", false);
                    commit("tambahJadwal", res.data);
                    return res;
                })
                .catch((err) => {
                    commit("setCurrentJadwalLoading", false);
                    commit("notify", {
                        type: "failed",
                        message: err.response.data.message,
                    });
                    throw err;
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
            state.siswa.links = siswa.meta.links;
        },

        setSesiLoading: (state, loading) => {
            state.sesi.loading = loading;
        },

        setSesi: (state, sesi) => {
            state.sesi.data = sesi.data;
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

        editGuru: (state, guru) => {
            state.guru = state.guru.data.map((s) => {
                if (s.nip_guru == guru.data.nip_guru) {
                    return guru.data;
                }
                return s;
            });
        },

        editSiswa: (state, siswa) => {
            state.siswa = state.siswa.data.map((s) => {
                if (s.nis_siswa == siswa.data.nis_siswa) {
                    return siswa.data;
                }
                return s;
            });
        },

        editKelas: (state, kelas) => {
            state.kelas = state.kelas.data.map((s) => {
                if (s.kode_kelas == kelas.data.kode_kelas) {
                    return kelas.data;
                }
                return s;
            });
        },

        editSesis: (state, sesi) => {
            state.sesi = state.sesi.data.map((s) => {
                if (s.id == sesi.data.id) {
                    return sesi.data;
                }
                return s;
            });
        },

        editJadwal: (state, jadwal) => {
            state.jadwal = state.jadwal.data.map((s) => {
                if (s.id == jadwal.data.kode_jadwal) {
                    return jadwal.data;
                }
                return s;
            });
        },

        tambahGuru: (state, guru) => {
            state.guru = [...state.guru, guru.data];
        },

        tambahSiswa: (state, siswa) => {
            state.siswa = [...state.siswa, siswa.data];
        },

        tambahKelas: (state, kelas) => {
            state.kelas = [...state.kelas, kelas.data];
        },

        tambahSesi: (state, sesi) => {
            state.sesi = [...state.sesi, sesi.data];
        },

        tambahJadwal: (state, jadwal) => {
            state.jadwal = [...state.jadwal, jadwal.data];
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
