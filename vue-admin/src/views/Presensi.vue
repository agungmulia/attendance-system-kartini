<template>
    <DefaultPage>
        <div class=" bg-white rounded-lg px-4 py-4 shadow-sm">
            <form @submit.prevent="cariPresensi">
                <div class=" lg:flex lg:space-x-6 space-y-2 lg:space-y-0">
                <div class="w-full">
                    <label
                        for="nama_siswa"
                        class="block text-sm text-gray-700"
                        >Nama Siswa<span class="text-red-700">*</span></label
                    >
                    <input
                        type="text"
                        name="nama_siswa"
                        id="nama_siswa"
                        v-model="model.nama_siswa"
                        autocomplete="nama_siswa"
                        class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg"
                    />
                </div>
                <div class=" w-full lg:flex space-y-2 lg:space-y-0 lg:space-x-2">
                    <div class="w-full">
                        <label
                            for="tanggal_mulai_presensi"
                            class="block text-sm text-gray-700"
                            >Tanggal Mulai<span class="text-red-700">*</span></label
                        >
                        <input
                            type="date"
                            name="tanggal_mulai_presensi"
                            id="tanggal_mulai_presensi"
                            v-model="model.tanggal_mulai_presensi"
                            autocomplete="tanggal_mulai_presensi"
                            class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg"
                        />
                    </div>
                    <div class="w-full">
                        <label
                            for="tanggal_selesai_presensi"
                            class="block text-sm text-gray-700"
                            >Tanggal Selesai<span class="text-red-700">*</span></label
                        >
                        <input
                            type="date"
                            name="tanggal_selesai_presensi"
                            id="tanggal_selesai_presensi"
                            v-model="model.tanggal_selesai_presensi"
                            autocomplete="tanggal_selesai_presensi"
                            class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg"
                        />
                    </div>
                </div>
                </div>
                <button class=" mt-2 bg-red-600 text-white w-full lg:w-fit px-8 py-2 rounded-lg shadow-sm text-sm duration-200 hover:bg-red-900" type="submit">Cari</button>
            </form>
        </div>
    <div  class=" bg-white rounded-lg px-4 mt-4 shadow-sm py-4"> 
        <div v-if="!presensiData.loading" >
            <div v-if="presensiData.data.length != 0">
                <div
                    class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5 rounded-lg"
                >
                    <table
                        class="table-auto w-full divide-y divide-gray-300"
                    >
                        <thead
                            class="bg-gray-50 hidden lg:table-header-group"
                        >
                            <tr>
                                <th
                                    scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                >
                                    Nama Siswa
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Status Kehadiran
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Keterangan
                                </th>
                                <th
                                    scope="col"
                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Tanggal
                                </th>
                            
                            </tr>
                        </thead>
                        <tbody
                            class="divide-y divide-gray-200 bg-white"
                        >
                            <tr
                                v-for="(item, itemIdx) in presensiData.data"
                                :key="item.id"
                                class="animate-fade-in-down"
                                :style="{
                                    animationDelay: `${itemIdx * 0.1}s`,
                                }"
                            >
                                <td
                                    class="py-4 pl-4 pr-3 text-sm  sm:pl-6"
                                >
                                    <span class="lg:hidden"
                                        >Nama Siswa:
                                    </span>
                                    <span class="text-blue-900">{{
                                        item.nama_siswa
                                    }}</span>
                                    <div class="lg:hidden">
                                        <div
                                            class="text-gray-900 text-sm"
                                        >
                                            <span>Status Kehadiran: </span>
                                            <span class="text-blue-900">
                                                {{
                                                    item.status_presensi
                                                }}
                                            </span>
                                        </div>
                                        <div>
                                            <span>Keterangan: </span>
                                            <span v-if="item.keterangan_presensi"
                                                class="text-blue-900"
                                                >{{
                                                    item.keterangan_presensi
                                                }}</span
                                            >
                                            <span v-else
                                                    class="text-blue-900"
                                                    >Tidak Ada Keterangan</span
                                                >
                                        </div>
                                        <div>
                                            <span
                                                >Tanggal:
                                            </span>
                                            <span
                                                class="text-blue-900"
                                                >
                                                {{
                                                    new Date(
                                                        item.updated_at
                                                    ).toLocaleDateString(
                                                        "id-ID",
                                                        {
                                                            day: "numeric",
                                                            month: "long",
                                                            year: "numeric",
                                                        }
                                                    )
                                                }}
                                                </span
                                            >
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="px-3 py-4 text-sm lg:text-lg text-gray-500 hidden lg:table-cell"
                                >
                                    <div class="text-sm">
                                        {{ item.status_presensi }}
                                    </div>
                                </td>
                                <td
                                    class="px-3 text-sm py-4 hidden lg:table-cell"
                                >
                                    <span v-if="item.keterangan_presensi">{{ item.keterangan_presensi }}</span>
                                    <span v-else>Tidak ada keterangan</span>
                                </td>
                                <td
                                    class="px-3 text-sm py-4 hidden lg:table-cell"
                                >
                                    {{
                                        new Date(
                                            item.updated_at
                                        ).toLocaleDateString(
                                            "id-ID",
                                            {
                                                day: "numeric",
                                                month: "long",
                                                year: "numeric",
                                            }
                                        )
                                    }}
                                </td>
                            
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="mt-2">
                    <tr class=" text-green-500">
                        <td>
                            Total Hadir
                        </td>
                        <td>: </td>
                        <td>{{ presensiData.total_hadir }}</td>
                    </tr>
                    <tr class=" text-yellow-500">
                        <td>
                            Total izin
                        </td>
                        <td>: </td>
                        <td> {{ presensiData.total_izin }}</td>
                    </tr>
                    <tr class=" text-red-500">
                        <td>
                            Total Alpha
                        </td>
                        <td>: </td>
                        <td> {{ presensiData.total_alpha }}</td>
                    </tr>
                </table>
            </div>
            <div v-else>Data Tidak Ditemukan</div>
        </div>
        <LoadingView v-else  class=" h-80"/>
        </div>
    </DefaultPage>
</template>
<script setup>
import DefaultPage from "../components/DefaultPage.vue";
import { computed, ref } from "vue";
import store from "../store/index.js";
import LoadingView from "../components/LoadingView.vue";

const presensiData = computed(() =>
    store.state.presensi
);

let model = ref({
    nama_siswa: null,
    tanggal_mulai_presensi:null,
    tanggal_selesai_presensi:null
});

store.dispatch("kosongkanPresensi");

function cariPresensi() {
    store.dispatch("cariPresensi", model.value).then(res => {
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
</script>
<style lang="">
    
</style>