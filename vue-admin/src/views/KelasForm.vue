<template>
    <DefaultPage>
        <LoadingView v-if="loading" />
        <div v-else>
            <div
                v-if="route.params.id"
                class="flex items-center justify-between"
            >
                <span class="text-blue-900 font-medium">Edit Data Kelas</span>
                <button
                    @click.prevent="confirmation = true"
                        type="button"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto"
                >
                    Hapus Data
                </button>
            </div>
            <div v-else class="flex items-center justify-between">
                <span class="text-blue-900 font-medium">Tambah Data Kelas</span>
            </div>
            <form @submit.prevent="tambahKelasConfirmation">
                <div
                    class="px-4 py-6 space-y-2 mt-4 bg-white rounded-lg shadow-sm"
                >
                    <div class="lg:flex lg:space-x-4 space-y-2 lg:space-y-0">
                        <!-- Tingkat Kelas -->
                        <div class="w-full">
                            <label
                                for="tingkat_kelas"
                                class="block text-sm text-gray-700"
                                >Tingkat Kelas<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <select
                                id="tingkat_kelas"
                                v-model="model.tingkat_kelas"
                                name="tingkat_kelas"
                                autocomplete="tingkat_kelas"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm text-sm border-gray-300 rounded-md"
                            >
                                <option>X</option>
                                <option>XI</option>
                                <option>XII</option>
                            </select>
                        </div>

                        <div class="w-full">
                            <label
                                for="jurusan_kelas"
                                class="block text-sm text-gray-700"
                                >Jurusan<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <select
                                id="jurusan_kelas"
                                v-model="model.jurusan_kelas"
                                name="jurusan_kelas"
                                autocomplete="jurusan_kelas"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm text-sm border-gray-300 rounded-md"
                            >
                                <option>Desain Komunikasi Visual</option>
                                <option>Mesin</option>
                                <option>Otomotif</option>
                                <option>Layanan Kesehatan</option>
                                <option>Akuntansi & Keuangan Lembaga</option>
                            </select>
                        </div>

                        <!-- Nomor Kelas -->
                        <div class="w-full">
                            <label
                                for="nomor_kelas"
                                class="block text-sm text-gray-700"
                                >Nomor Kelas<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                name="nomor_kelas"
                                id="nomor_kelas"
                                v-model="model.nomor_kelas"
                                autocomplete="nomor_kelas"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>
                    </div>

                    <span class="text-sm text-gray-500"
                        >Note: Pastikan data bertanda
                        <span class="text-red-600">*</span> tidak kosong!</span
                    >
                    <button
                        class="w-full py-2 text-white rounded-lg hover:bg-red-900 duration-200 bg-red-600"
                    >
                        <span v-if="route.params.id"> Edit Data </span>
                        <span v-else> Tambah Data </span>
                    </button>
                </div>
            </form>
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
                        @click="deleteKelas(route.params.id)"
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
            <ConfirmView
                        :confirmation="confirmationUpdate"
                        @close="toggleUpdateConfirmation"
                    >
                    <template v-slot:messageValue>
                        <div class="grid w-full">
                            Anda yakin akan mengubah data?
                        </div>
                    </template>
                    <template v-slot:icon>
                        <PencilIcon class="h-6 w-6 text-red-900"/>
                    </template>

                    <button
                        type="submit"
                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-900 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="updateKelas"
                    >
                        Lanjut
                    </button>
                    <button
                        type="button"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-red-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="confirmationUpdate = false"
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
import { UserCircleIcon } from "@heroicons/vue/20/solid";
import DeleteCircleIcon from "vue-material-design-icons/DeleteCircleOutline.vue";
import { computed, ref, watch } from "vue";
import store from "../store/index.js";
import { useRoute, useRouter } from "vue-router";
import ConfirmView from "../components/ConfirmView.vue";
import { TrashIcon,PencilIcon } from '@heroicons/vue/24/outline';
const router = useRouter();

let model = ref({
    kode_kelas: null,
    tingkat_kelas: null,
    jurusan_kelas: null,
    nomor_kelas: null,
});

const confirmation = ref(false);
const route = useRoute();
const confirmationUpdate = ref(false);

function toggleUpdateConfirmation() {
    confirmationUpdate.value = !confirmationUpdate.value;
}

function toggleConfirmation() {
    confirmation.value = !confirmation.value;
}

function tambahKelasConfirmation() {
    if (route.params.id) {
        confirmationUpdate.value = true
    } else {
        store.dispatch("tambahKelas", model.value).then(res => {
            if (res.request.status == 200) {
                router.push({
                    name: "Kelas",
                });
                store.commit("notify", {
                    type: "success",
                    message: 'Tambah data kelas berhasil!',
                });
            } else {
                store.commit("notify", {
                    type: "error",
                    message: res.response.data.message,
                });
            }
        });
    }
}

function updateKelas() {
    store.dispatch("updateKelas", model.value).then(res => {
        if (res.request.status == 200) {
            router.push({
                name: "Kelas",
            });
            store.commit("notify", {
                type: "success",
                message: 'Ubah data kelas berhasil!',
            });
        } else {
            confirmationUpdate.value = false
            store.commit("notify", {
                type: "error",
                message: res.response.data.message,
            });
        }
    });
}

function deleteKelas(value) {
    store.dispatch("deleteKelas", value).then(
        router.push({
            name: "Kelas",
        }));
    store.commit("notify", {
        type: "success",
        message: "Data berhasil dihapus!"
    });
    confirmation.value = false
}


if (route.params.id) {
    store.dispatch("showKelas", route.params.id);
}

const loading = computed(() => store.state.currentKelas.loading);

watch(
    () => store.state.currentKelas.data,
    (newVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
        };
    }
);
</script>
<style></style>
