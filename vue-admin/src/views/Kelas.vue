<template>
    <DefaultPage>
        <LoadingView v-if="loading" />
        <div v-else>
            <div class="-mx-4 md:mx-0 flex justify-end">
                <div>
                    <router-link
                        :to="{ name: 'TambahKelas' }"
                        type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto"
                    >
                        Tambah Data
                    </router-link>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                        class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                    >
                        <input
                            type="text"
                            v-model="search"
                            placeholder="Cari Kelas"
                            class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full mb-2 shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
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
                                            Kelas
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Wali Kelas
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Jumlah Siswa
                                        </th>

                                        <th
                                            scope="col"
                                            class="relative py-3.5 pl-3 pr-4 sm:pr-6"
                                        >
                                            <span class="sr-only"
                                                >Ubah Data</span
                                            >
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="divide-y divide-gray-200 bg-white"
                                >
                                    <tr
                                        v-for="(person, itemIdx) in kelasData"
                                        :key="person.kode_kelas"
                                        class="animate-fade-in-down"
                                        :style="{
                                            animationDelay: `${itemIdx * 0.1}s`,
                                        }"
                                    >
                                        <td
                                            class="py-4 pl-4 pr-3 text-sm sm:pl-6"
                                        >
                                            <div class="text-gray-900 text-lg">
                                                {{ person.tingkat_kelas }}
                                                {{ person.jurusan_kelas }}
                                                {{ person.nomor_kelas }}
                                            </div>
                                            <div class="lg:hidden">
                                                <div class="text-blue-900">
                                                    Wali Kelas:
                                                    {{ person.nama_guru }}
                                                </div>
                                                <div>
                                                    Total Murid:
                                                    {{ person.total_murid }}
                                                </div>
                                                <div class="space-y-2 mt-2">
                                                    <button
                                                    @click.prevent="kosongkanKelas(person.kode_kelas)"
                                                            type="button"
                                                        class="bg-red-600 w-full text-white px-4 py-2 rounded-lg shadow-sm text-xs duration-200 hover:bg-red-900"
                                                    >
                                                        Kosongkan Kelas
                                                    </button>
                                                    <div
                                                        class="flex items-center space-x-2"
                                                    >
                                                        <router-link
                                                            :to="{
                                                                name: 'EditKelas',
                                                                params: {
                                                                    id: person.kode_kelas,
                                                                },
                                                            }"
                                                            class="bg-red-600 w-full text-white px-4 py-2 rounded-lg shadow-sm text-xs duration-200 hover:bg-red-900"
                                                        >
                                                            Ubah Data
                                                        </router-link>
                                                            <button type="button"  @click.prevent="deleteModal(person.kode_kelas)">
                                                            <DeleteCircleIcon
                                                                :size=35
                                                                class="text-red-600 hover:text-red-900 duration-200"
                                                            />
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-3 py-4 text-sm text-gray-500 hidden lg:table-cell"
                                        >
                                            {{ person.nama_guru }}
                                        </td>
                                        <td
                                            class="px-3 text-xs py-4 text-gray-500 hidden lg:table-cell"
                                        >
                                            {{ person.total_murid }}
                                        </td>

                                        <td
                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 hidden lg:table-cell"
                                        >
                                            <div
                                                class="space-x-2 items-center flex"
                                            >
                                                <button
                                                    @click.prevent="kosongkanKelas(person.kode_kelas)"
                                                    type="button"
                                                    class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-sm text-xs duration-200 hover:bg-red-900"
                                                >
                                                    Kosongkan Kelas
                                                </button>
                                                <router-link
                                                    :to="{
                                                        name: 'EditKelas',
                                                        params: {
                                                            id: person.kode_kelas,
                                                        },
                                                    }"
                                                    type="button"
                                                    class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-sm text-xs duration-200 hover:bg-red-900"
                                                >
                                                    Ubah Data
                                                </router-link>
                                                <button type="button" @click.prevent="deleteModal(person.kode_kelas)">
                                                    <DeleteCircleIcon
                                                        :size=30
                                                        class="text-red-600 hover:text-red-900 duration-200"
                                                    />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmView
                    :confirmation="confirmation"
                    @close="toggleConfirmation"
                >
                    <template v-slot:messageValue>
                        <div class="grid w-full">
                            Anda yakin akan menghapus data?
                        </div>
                    </template>
                    <template v-slot:icon>
                        <TrashIcon class="h-6 w-6 text-red-900"/>
                    </template>

                    <button
                        type="submit"
                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-900 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="deleteKelas(kode_kelas)"
                    >
                        Lanjut
                    </button>
                    <button
                        type="button"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-red-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="confirmation = false"
                    >
                        Cancel
                    </button>
                </ConfirmView>
        </div>
    </DefaultPage>
</template>
<script setup>
import DefaultPage from "../components/DefaultPage.vue";
import LoadingView from "../components/LoadingView.vue";
import AccountCircleIcon from "vue-material-design-icons/AccountCircle.vue";
import DeleteCircleIcon from "vue-material-design-icons/DeleteCircleOutline.vue";
import { computed, ref } from "vue";
import store from "../store/index.js";
import ConfirmView from "../components/ConfirmView.vue";
import { TrashIcon } from '@heroicons/vue/24/outline';

const alertMessage = ref("");
const confirmation = ref(false);
let kode_kelas = ref('')
function deleteModal(value) {
    confirmation.value = true
    kode_kelas.value = value
}
function kosongkanKelas(value) {
    store.dispatch("kosongkanKelas", value).then(
        store.dispatch("getKelas"));
  
}
function deleteKelas(value) {
    store.dispatch("deleteKelas", value).then(
        store.dispatch("getKelas"));
    store.commit("notify", {
        type: "success",
        message: "Data berhasil dihapus!"
    });
    confirmation.value = false
}
function toggleConfirmation() {
    confirmation.value = !confirmation.value;
}
let search = ref("");

const loading = computed(() => store.state.kelas.loading);
const kelasData = computed(() =>
    store.state.kelas.data.filter((i) =>
        i.jurusan_kelas.toLowerCase().includes(search.value.toLowerCase())
    )
);

store.dispatch("getKelas");
</script>
<style></style>
