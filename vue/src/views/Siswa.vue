<template>
    <LoadingView v-if="loading" />
    <div v-else class="md:pl-80 bg-gray-100 flex flex-col flex-1">
        <div
            class="sticky top-0 bg-white z-10 md:hidden px-4 sm:pl-3 py-4 shadow-md"
        >
            <div
                class="flex items-center justify-between text-lg text-blue-900 font-bold"
            >
                <div class="flex items-center">
                    <button
                        type="button"
                        class="-ml-4 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-xl hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-900"
                        @click="sidebarOpen = true"
                    >
                        <span class="sr-only">Open sidebar</span>
                        <Bars3Icon class="h-6 w-6" />
                    </button>
                    <span>Profil</span>
                </div>
                <router-link
                    :to="{ name: 'Profil' }"
                    class="hover:text-blue-800 duration-300"
                    type="button"
                >
                </router-link>
            </div>
        </div>
        <main class="flex-1 pb-6">
            <div>
                <div
                    class="py-6 text-blue-900 bg-white px-10 lg:px-8 shadow-md hidden md:flex justify-between"
                >
                    <span class="font-bold text-xl"> Profil </span>
                </div>
                <div class="max-w-7 pt-6  gap-y-4 px-10 lg:px-8 ">
                    <div class="lg:flex lg:justify-center  lg:space-x-4">
                        <div class="grid lg:w-full">
                            <div
                                class="py-4 grid rounded-t-lg shadow-sm bg-white px-6"
                            >
                                <div class="grid justify-items-center">
                                    <img
                                        class="w-40 h-40 mb-4 rounded-full"
                                        v-if="model.foto_siswa_url"
                                        :src="model.foto_siswa_url"
                                    />

                                    <UserCircleIcon
                                        v-else
                                        class="text-gray-300 h-40 w-40"
                                    />
                                </div>
                                <div class="grid">
                                    <span class="text-blue-900 font-medium text-xl"
                                        >{{ model.nama_siswa }}
                                        <span class="text-green-600"
                                            >({{ model.nis_siswa }})</span
                                        >
                                    </span>
                                    <div>
                                        <span class="text-gray-400"
                                            >{{ model.tingkat_kelas }}
                                            {{ model.jurusan_kelas }}
                                            {{ model.nomor_kelas }}</span
                                        >
                                        <div>
                                            <span class="text-blue-400">{{
                                                model.jenis_kelamin_siswa
                                            }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="py-4 px-6 rounded-b-lg shadow-sm bg-gray-200"
                            >
                                <div>
                                    <span class="text-xs"
                                        >Tempat, Tanggal Lahir:</span
                                    >
                                    <div class="text-md text-blue-900">
                                        <span
                                            >{{ model.tempat_lahir_siswa }},
                                            {{
                                                new Date(
                                                    model.tanggal_lahir_siswa
                                                ).toLocaleDateString("id-ID", {
                                                    day: "numeric",
                                                    month: "long",
                                                    year: "numeric",
                                                })
                                            }}</span
                                        >
                                    </div>
                                </div>
                                <div>
                                    <span class="text-xs">Alamat:</span>
                                    <div>
                                        <span class="text-md text-blue-900">{{
                                            model.alamat_siswa
                                        }}</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-xs">Email:</span>
                                    <div>
                                        <span class="text-blue-900">{{
                                            model.email_siswa
                                        }}</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-xs">No Telp:</span>
                                    <div>
                                        <span class="text-blue-900">{{
                                            model.no_telp_siswa
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-80 py-6 lg:py-0">
                            <div
                                class="bg-white h-full rounded-lg shadow-sm px-4 py-4 text-blue-900 font-medium text-md lg:text-lg"
                            >
                                <span class="">Persentase Kehadiran</span>
                                <Doughnut
                                    class="cursor-pointer"
                                    :data="chartData"
                                    :ootion="chartOption"
                                />
                                <div class="text-xs text-gray-400 text-center mt-2">
                                    Note: Apabila kehadiran dibawah 75% maka siswa
                                    tidak bisa mengikuti ujian
                                </div>
                                <div
                                    v-if="
                                        ((chartData.datasets[0].data[0] + (0.5 * chartData.datasets[0].data[1])) /
                                            totalValue() * 100) > 75
                                    "
                                    class="py-4 grid justify-items-center"
                                >
                                    <span
                                        class="bg bg-green-500 py-2 px-4 rounded-lg text-white text-lg"
                                        >Bisa Mengikuti Ujian</span
                                    >
                                </div>
                                <div v-else class="py-4 grid justify-items-center">
                                    <span
                                        class="bg bg-red-500 py-2 px-4 rounded-lg text-white text-md mg:text-lg"
                                        >Tidak Bisa Mengikuti Ujian</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-7 mt-6  px-10 py-6 bg-white rounded-lg">
                        <span>Cari History Presensi Berdasarkan Tahun Ajaran</span>
                        <div class="w-full flex gap-x-4">
                                <select
                                    v-model="tahun_presensi"
                                    id="hari_jadwal"
                                    name="hari_jadwal"
                                    placeholder="Tahun Ajaran"
                                    autocomplete="hari_jadwal"
                                    class="focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm text-sm border-gray-300 rounded-md"
                                >
                                    <option v-for="(item, index) in dataTahunAjaran" :key="index">{{ item }}</option>
                                </select>
                                <button class="bg-red-700 text-white rounded-lg px-8 py-1" @click="cariPresensiSiswa" type="button">Cari</button>
                            </div>
                        <LoadingView v-if="PresensiSiswaLoading" class="h-80"/>
                        <div v-if="Object.keys(dataPresensiSiswa).length !== 0 && !PresensiSiswaLoading" class="bg-white mt-4 rounded-lg py-4">
                            <table class="table-auto  w-full border">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900"
                                            >
                                                Status Presensi
                                            </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900"
                                        >
                                            Keterangan
                                        </th>

                                        <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900"
                                            >
                                                Tanggal
                                            </th>
                                        
                               
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <tr
                                        v-for="(item, itemIdx) in dataPresensiSiswa"
                                        :key="item.nis_siswa"
                                        :class="itemIdx % 2 === 0
                                                ? 'animate-fade-in-down'
                                                : 'bg-gray-50 animate-fade-in-down'
                                            "
                                        :style="{ animationDelay: `${itemIdx * 0.1}s` }"
                                    >
                                    <td
                                                class="whitespace-nowrap px-3 py-4 text-xs text-gray-500"
                                            >
                                                {{ item.status_presensi }}
                                            </td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-xs text-gray-500"
                                        >
                                            <span v-if="item.keterangan_presensi">{{ item.keterangan_presensi }}</span>
                                            <span v-else>Tidak ada keterangan</span>
                                        </td>
                                         <td
                                                class="whitespace-nowrap px-3 py-4 text-xs text-gray-500"
                                            >
                                                {{ new Date(
                                                    item.updated_at
                                                ).toLocaleDateString("id-ID", {
                                                    day: "numeric",
                                                    month: "long",
                                                    year: "numeric",
                                                                                                    }) }}
                                            </td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>
    </div>
</template>
<script>
export default {
    data() {
        return {
            chartOption: {
                responsive: true,
                maintainAspectRatio: false,
            },
        };
    },
    computed: {},
};
</script>

<script setup>
import LoadingView from "../components/LoadingView.vue";
import { Doughnut } from "vue-chartjs";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { sharedConstant } from "../utils";
import { Bars3Icon } from "@heroicons/vue/24/outline";
import { UserCircleIcon } from "@heroicons/vue/20/solid";
import store from "../store/index.js";
import { useRoute, useRouter } from "vue-router";
import { computed, ref, watch } from "vue";

const sidebarOpen = sharedConstant;

ChartJS.register(ArcElement, Tooltip, Legend);
const route = useRoute();
const router = useRouter();

let tahun_presensi = ref()

const loading = computed(() => store.state.currentSiswa.loading);
const dataSiswa = computed(() => store.state.currentSiswa.data);
const dataTahunAjaran = computed(() => store.state.tahunAjaranPresensi.data);
const dataPresensiSiswa = computed(() => store.state.presensiSiswa.data);
const PresensiSiswaLoading = computed(() => store.state.presensiSiswa.loading);
watch(
    () => store.state.currentSiswa.data,
    (newVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
        };
        chartData.value.datasets[0].data[0] = model.value.total_hadir_presensi;
        chartData.value.datasets[0].data[1] = model.value.total_izin_presensi;
        chartData.value.datasets[0].data[2] = model.value.total_alpha_presensi;
    }
);
let model = ref({
    foto_siswa_url: null,
    nama_siswa: null,
    jenis_kelamin_siswa: null,
    email_siswa: null,
    no_telp_siswa: null,
    alamat_siswa: null,
    jenis_kelamin_guru: null,
    total_hadir_presensi: null,
    total_izin_presensi: null,
    total_alpha_presensi: null,
});

let chartData = ref({
    labels: ["Hadir", "Izin", "Alpha"],
    datasets: [
        {
            backgroundColor: ["#41B883", "#E46651", "#DD1B16"],
            data: [0, 0, 0],
        },
    ],
});

function totalValue() {
    return this.chartData.datasets[0].data.reduce(
        (acc, value) => acc + value,
        0
    );
}

function cariPresensiSiswa(){
    store.dispatch("keteranganPresensiById", [route.params.id, tahun_presensi.value]).then(res => {
        if (res.request.status == 200) {
            store.commit("notify", {
                type: "success",
                message: 'Data presensi ditemukan!',
            });
        } else {
            store.commit("notify", {
                type: "error",
                message: res.response.data.message,
            });
        }
    });
}

store.dispatch("showSiswa", route.params.id);
store.dispatch("kosongkanPresensi");
store.dispatch("getTahunAjaranPresensi", route.params.id);
</script>
<style></style>
