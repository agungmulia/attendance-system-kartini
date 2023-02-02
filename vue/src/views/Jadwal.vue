<template>
    <DefaultPage>
        <LoadingView v-if="loading || jadwalLoading" />
        <div v-else>
            <div class="pb-4">
                <h1 class="text-blue-900 text-xl font-semibold">Jadwal Anda</h1>
            </div>

            <table
                class="text-xs min-w-[50%] w-full lg:min-w-[80%] bg-gray-50 lg:text-base border-separate rounded-lg border-2 animate-fade-in-down lg:animate-fade-in-left"
            >
                <thead>
                    <tr>
                        <th class="py-1 px-1 md:py-4 md:px-4">Sesi</th>
                        <th class="py-1 px-1 md:py-4 md:px-4">Senin</th>
                        <th class="py-1 px-1 md:py-4 md:px-4">Selasa</th>
                        <th class="py-1 px-1 md:py-4 md:px-4">Rabu</th>
                        <th class="py-1 px-1 md:py-4 md:px-4">Kamis</th>
                        <th class="py-1 px-1 md:py-4 md:px-4">Jumat</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr
                        v-for="item in sesiData"
                        :key="item.nama_sesi"
                        class="bg-gray-300"
                    >
                        <td class="py-1 px-1 md:py-4 md:px-4">
                            {{ item.nama_sesi }}
                        </td>
                        <td class="py-1 px-1 md:py-4 md:px-4">
                            <span v-for="value in jadwalSenin" :key="value">
                                <span v-if="value.sesi == item.nama_sesi">
                                    {{ value.mata_pelajaran_jadwal }}
                                </span>
                            </span>
                        </td>
                        <td class="py-1 px-1 md:py-4 md:px-4">
                            <span v-for="value in jadwalSelasa" :key="value">
                                <span v-if="value.sesi == item.nama_sesi">
                                    {{ value.mata_pelajaran_jadwal }}
                                </span>
                            </span>
                        </td>
                        <td class="py-1 px-1 md:py-4 md:px-4">
                            <span v-for="value in jadwalRabu" :key="value">
                                <span v-if="value.sesi == item.nama_sesi">
                                    {{ value.mata_pelajaran_jadwal }}
                                </span>
                            </span>
                        </td>
                        <td class="py-1 px-1 md:py-4 md:px-4">
                            <span v-for="value in jadwalKamis" :key="value">
                                <span v-if="value.sesi == item.nama_sesi">
                                    {{ value.mata_pelajaran_jadwal }}
                                </span>
                            </span>
                        </td>
                        <td class="py-1 px-1 md:py-4 md:px-4">
                            <span v-for="value in jadwalJumat" :key="value">
                                <span v-if="value.sesi == item.nama_sesi">
                                    {{ value.mata_pelajaran_jadwal }}
                                </span>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DefaultPage>
</template>

<script setup>
import DefaultPage from "../components/DefaultPage.vue";
import LoadingView from "../components/LoadingView.vue";
import { computed, ref } from "vue";
import store from "../store/index.js";

const loading = computed(() => store.state.sesi.loading);
const jadwalLoading = computed(() => store.state.currentJadwal.loading);
const sesiData = computed(() => store.state.sesi.data);

function jadwalSesi(value) {
    const jadwalData = computed(() =>
        store.state.currentJadwal.data.filter(
            (i) => (i.sesi === value) & (i.hari_jadwal === "Senin")
        )
    );
    return jadwal;
}

const jadwalSenin = computed(() =>
    store.state.currentJadwal.data.filter((i) => i.hari_jadwal === "Senin")
);

const jadwalSelasa = computed(() =>
    store.state.currentJadwal.data.filter((i) => i.hari_jadwal === "Selasa")
);

const jadwalRabu = computed(() =>
    store.state.currentJadwal.data.filter((i) => i.hari_jadwal === "Rabu")
);

const jadwalKamis = computed(() =>
    store.state.currentJadwal.data.filter((i) => i.hari_jadwal === "Kamis")
);

const jadwalJumat = computed(() =>
    store.state.currentJadwal.data.filter((i) => i.hari_jadwal === "Jumat")
);

store.dispatch("getSesi");
store.dispatch("getJadwalPage");
</script>
<style></style>
