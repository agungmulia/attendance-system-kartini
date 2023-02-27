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
                            <span
                                v-for="value in jadwalSenin"
                                :key="value.sesi"
                            >
                                <span v-if="value.nama_sesi == item.nama_sesi">
                                    {{ value.mata_pelajaran_jadwal }}
                                </span>
                            </span>
                        </td>
                        <td class="py-1 px-1 md:py-4 md:px-4">
                            <span
                                v-for="value in jadwalSelasa"
                                :key="value.sesi"
                            >
                                <span v-if="value.sesi == item.id">
                                    {{ value.mata_pelajaran_jadwal }}
                                </span>
                            </span>
                        </td>
                        <td class="py-1 px-1 md:py-4 md:px-4">
                            <span v-for="value in jadwalRabu" :key="value.sesi">
                                <span v-if="value.sesi == item.id">
                                    {{ value.mata_pelajaran_jadwal }}
                                </span>
                            </span>
                        </td>
                        <td class="py-1 px-1 md:py-4 md:px-4">
                            <span
                                v-for="value in jadwalKamis"
                                :key="value.sesi"
                            >
                                <span v-if="value.sesi == item.id">
                                    {{ value.mata_pelajaran_jadwal }}
                                </span>
                            </span>
                        </td>
                        <td class="py-1 px-1 md:py-4 md:px-4">
                            <span
                                v-for="value in jadwalJumat"
                                :key="value.sesi"
                            >
                                <span v-if="value.sesi == item.id">
                                    {{ value.mata_pelajaran_jadwal }}
                                </span>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table
                class="rounded-lg animate-fade-in-left border-2 border-separate mt-5 border-gray-500"
            >
                <thead>
                    <tr>
                        <th class="py-1 px-1 md:py-4 md:px-4 text-sm">Sesi</th>
                        <th class="py-1 px-1 md:py-4 md:px-4 text-sm">
                            Jam Mulai
                        </th>
                        <th class="py-1 px-1 md:py-4 md:px-4 text-sm">
                            Jam Selesai
                        </th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="value in sesiData" :key="value.nama_sesi">
                        <td
                            class="py-1 px-1 md:py-4 md:px-4 border text-sm border-gray-600"
                        >
                            {{ value.nama_sesi }}
                        </td>
                        <td
                            class="py-1 px-1 md:py-4 md:px-4 border text-sm border-gray-600"
                        >
                            {{ value.jam_mulai_sesi }}
                        </td>
                        <td
                            class="py-1 px-1 md:py-4 md:px-4 border text-sm border-gray-600"
                        >
                            {{ value.jam_selesai_sesi }}
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

const jadwalTes = computed(() => store.state.currentJadwal.data);

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
