<template>
    <DefaultPage pageHeading="XI Multimedia 1">
        <LoadingView v-if="kelasLoading" />
        <div v-else>
            <div v-if="kelasData.length != 0">
                <div class="pb-4">
                    <h1 class="text-blue-900 text-xl font-semibold">
                        Kelas Anda
                    </h1>
                </div>
                <table class="table-auto lg:w-[80%] w-full border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-900 sm:pl-6"
                            >
                                Nama
                            </th>
                            <th
                                scope="col"
                                class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900"
                            >
                                Hadir
                            </th>
                            <th
                                scope="col"
                                class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900"
                            >
                                Izin
                            </th>
                            <th
                                scope="col"
                                class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900"
                            >
                                Alpha
                            </th>
                            <th
                                scope="col"
                                class="relative py-3.5 pl-3 pr-4 sm:pr-6"
                            >
                                <span class="sr-only">Lihat Data</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr
                            v-for="(item, itemIdx) in kelasData"
                            :key="item.nis_siswa"
                            :class="
                                itemIdx % 2 === 0
                                    ? 'animate-fade-in-down'
                                    : 'bg-gray-50 animate-fade-in-down'
                            "
                            :style="{ animationDelay: `${itemIdx * 0.1}s` }"
                        >
                            <td class="text-xs px-4">
                                {{ item.nama_siswa }}
                            </td>
                            <td
                                class="whitespace-nowrap px-3 py-4 text-xs text-gray-500"
                            >
                                {{ item.total_hadir_presensi }}
                            </td>
                            <td
                                class="whitespace-nowrap px-3 py-4 text-xs text-gray-500"
                            >
                                {{ item.total_izin_presensi }}
                            </td>
                            <td
                                class="whitespace-nowrap px-3 py-4 text-xs text-gray-500"
                            >
                                {{ item.total_alpha_presensi }}
                            </td>
                            <td
                                class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-xs font-medium sm:pr-6"
                            >
                                <router-link
                                    :to="{
                                        name: 'Siswa',
                                        params: { id: item.nis_siswa },
                                    }"
                                    class="text-indigo-600 flex space-x-2 hover:text-indigo-900"
                                >
                                    <MagnifyingGlassIcon class="h-4 w-4" />
                                    <span class="hidden md:flex"
                                        >Lihat Data</span
                                    ></router-link
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button
                    type="button"
                    @click="getPDF"
                    class="mt-4 bg-red-700 text-white rounded-lg px-4 py-1"
                >
                    Cetak
                </button>
            </div>
            <div
                class="w-full bg-white shadow-sm flex justify-center py-8 rounded-lg text-gray-400"
                v-else
            >
                Data kelas tidak ditemukan, Hubungi Admin apabila ada kesalahan!
            </div>
        </div>
    </DefaultPage>
</template>

<script setup>
import DefaultPage from "../components/DefaultPage.vue";
import { MagnifyingGlassIcon } from "@heroicons/vue/20/solid";
import LoadingView from "../components/LoadingView.vue";
import { computed } from "vue";
import store from "../store/index.js";

function getPDF() {
    store.dispatch("getPDF");
}

const kelasLoading = computed(() => store.state.kelas.loading);
const kelasData = computed(() => store.state.kelas.data);

store.dispatch("getKelasAnda");
</script>
<style></style>
