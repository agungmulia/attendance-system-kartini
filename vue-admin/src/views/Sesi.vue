<template>
    <DefaultPage>
        <LoadingView v-if="loading" />
        <div v-else>
            <div class="-mx-4 md:mx-0 flex justify-end">
                <div>
                    <router-link
                        :to="{ name: 'TambahSesi' }"
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
                            placeholder="Cari Sesi"
                            class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full mb-2 shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                        <div
                            class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5 rounded-lg"
                        >
                            <table
                                class="table-auto w-full divide-y divide-gray-300"
                            >
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                        >
                                            Nama Sesi
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Jam Mulai
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Jam Selesai
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
                                        v-for="(person, itemIdx) in sesiData"
                                        :key="person.nama_sesi"
                                        class="animate-fade-in-down"
                                        :style="{
                                            animationDelay: `${itemIdx * 0.1}s`,
                                        }"
                                    >
                                        <td
                                            class="py-4 pl-4 pr-3 text-sm lg:text-lg sm:pl-6"
                                        >
                                            {{ person.nama_sesi }}
                                        </td>
                                        <td
                                            class="px-3 py-4 text-sm lg:text-lg text-gray-500"
                                        >
                                            {{ person.jam_mulai_sesi }}
                                        </td>
                                        <td
                                            class="px-3 text-sm lg:text-lg py-4 text-gray-500"
                                        >
                                            {{ person.jam_selesai_sesi }}
                                        </td>

                                        <td
                                            class="relative whitespace-nowrap py-4 px-10 text-right text-sm font-medium"
                                        >
                                            <div
                                                class="flex items-center space-x-2"
                                            >
                                                <router-link
                                                    :to="{
                                                        name: 'EditSesi',
                                                        params: {
                                                            id: person.id,
                                                        },
                                                    }"
                                                    type="button"
                                                    class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-sm text-xs duration-200 hover:bg-red-900"
                                                >
                                                    Ubah Data
                                                </router-link>
                                                <button type="button" @click.prevent="deleteModal(person.id)">
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
                            @click="deleteSesi(id_sesi)"
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

let id_sesi = ref('')
const alertMessage = ref("");
const updateConfirm = ref(false);
const confirmation = ref(false);
function deleteModal(value) {
    confirmation.value = true
    id_sesi.value = value
}
function deleteSesi(value) {
    store.dispatch("deleteSesi", value).then(
        store.dispatch("getSesi"));
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

const loading = computed(() => store.state.sesi.loading);
const sesiData = computed(() =>
    store.state.sesi.data.filter((i) =>
        i.nama_sesi.toLowerCase().includes(search.value.toLowerCase())
    )
);

store.dispatch("getSesi");
</script>
<style></style>
