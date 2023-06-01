<template>
    <DefaultPage>
        <template v-slot:header>
            <span class=" font-bold text-xl text-blue-900">Data Siswa</span>
        </template>
        <LoadingView v-if="loading || keteranganAbsensiLoading"/>
        <div v-else class="space-y-4 lg:space-y-0 md:flex md:space-x-4">
         <div
            class="bg-white md:w-[50%] lg:w-[30%] px-4 py-4   rounded-lg shadow-md  text-blue-900 font-medium text-md lg:text-lg"
        >
            <div v-if="hariUpdate(model.updated_at)">Presensi Hari Ini: <span class=" text-gray-500">{{ model.status_presensi }}</span></div>
            <span class="">Persentase Kehadiran</span>
            <Doughnut
                class="cursor-pointer"
                :data="chartData"
                :option="chartOption"
            />
            <div class="text-xs text-gray-400 text-center mt-2">
                Note: Apabila kehadiran dibawah 75% maka siswa
                tidak bisa mengikuti ujian
            </div>
            <div
                v-if="
                    (chartData.datasets[0].data[0] + (0.5 * chartData.datasets[0].data[1]) /
                        totalValue()) *
                    100 >
                    75
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
        <div class="shadow-md w-full  px-5 py-5 bg-white rounded-lg">
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
                                        <option v-for="(item, index) in tahunAjaranData" :key="index">{{ item }}</option>
                                    </select>
                                    <button class="bg-red-700 text-white rounded-lg px-8 py-1" @click="cariPresensiSiswa" type="button">Cari</button>
                                </div>
                            <LoadingView v-if="presensiLoading" class="h-80"/>
                            <div v-if="Object.keys(dataPresensi).length !== 0 && !presensiLoading"  class="bg-white mt-4 rounded-lg py-4">
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
                                            v-for="(item, itemIdx) in dataPresensi"
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
    </DefaultPage>
</template>

<script setup>
import { PencilIcon } from "@heroicons/vue/24/solid";
import DefaultPage from "../components/DefaultPage.vue";
import LoadingView from "../components/LoadingView.vue";
import AlertView from "../components/AlertView.vue";
import { Doughnut } from "vue-chartjs";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { computed, ref,watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import store from "../store/index.js";
ChartJS.register(ArcElement, Tooltip, Legend);

let chartOption = ref ({
    responsive: true,
        maintainAspectRatio: false,
});
let tahun_presensi = ref()
const route = useRoute();
const router = useRouter();
store.dispatch("getDataAbsen");
store.dispatch("getTahunAjaranPresensi");
store.dispatch("kosongkanPresensi");

const tahunAjaranData = computed(() => store.state.tahunAjaranPresensi.data)
const dataPresensi = computed(()=> store.state.presensiSiswa.data)
const presensiLoading = computed(()=> store.state.presensiSiswa.loading)
const absenData = computed(() =>store.state.absen.data);
const loading = computed(() =>store.state.absen.loading);

let model = ref({
    updated_at:null,
    status_presensi:null,
    total_hadir_presensi: null,
    total_izin_presensi: null,
    total_alpha_presensi: null,
});
watch(
    () => store.state.absen.data[0],
    (newVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
        };
        chartData.value.datasets[0].data[0] = model.value.total_hadir_presensi;
        chartData.value.datasets[0].data[1] = model.value.total_izin_presensi;
        chartData.value.datasets[0].data[2] = model.value.total_alpha_presensi;
    }
);
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
function cariPresensiSiswa() {
    store.dispatch("presensiSiswa", tahun_presensi.value).then(res => {
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
function hariUpdate(value) {
    let lastUpdate = new Date(value);
    let hariIni = new Date();
    return hariIni.toDateString() == lastUpdate.toDateString();
}
</script>
<style></style>
