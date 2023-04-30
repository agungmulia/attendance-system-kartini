<template>
    <DefaultPage>
        <LoadingView v-if="loading" />
        <div v-else>
            <div
                v-if="route.params.id"
                class="flex items-center justify-between"
            >
                <span class="text-blue-900 font-medium">Edit Data Jadwal</span>
                <button
                    @click.prevent="confirmation = true"
                        type="button"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto"
                >
                    Hapus Data
                </button>
            </div>
            <div v-else class="flex items-center justify-between">
                <span class="text-blue-900 font-medium"
                    >Tambah Data Jadwal</span
                >
            </div>
            <form @submit.prevent="tambahJadwalConfirmation">
                <div
                    class="px-4 py-6 space-y-2 mt-4 bg-white rounded-lg shadow-sm"
                >
                    <div class="lg:flex lg:space-x-4 space-y-2 lg:space-y-0">
                        <!-- Mata Pelajaran Jadwal -->
                        <div class="w-full">
                            <label
                                for="mata_pelajaran_jadwal"
                                class="block text-sm text-gray-700"
                                >Mata Pelajaran Jadwal<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                name="mata_pelajaran_jadwal"
                                id="mata_pelajaran_jadwal"
                                v-model="model.mata_pelajaran_jadwal"
                                autocomplete="mata_pelajaran_jadwal"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>

                        <!-- Hari -->
                        <div class="w-full">
                            <label
                                for="hari_jadwal"
                                class="block text-sm text-gray-700"
                                >Hari<span class="text-red-700">*</span></label
                            >
                            <select
                                id="hari_jadwal"
                                v-model="model.hari_jadwal"
                                name="hari_jadwal"
                                autocomplete="hari_jadwal"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm text-sm border-gray-300 rounded-md"
                            >
                                <option>Senin</option>
                                <option>Selasa</option>
                                <option>Rabu</option>
                                <option>Kamis</option>
                                <option>Jumat</option>
                            </select>
                        </div>
                    </div>

                    <div class="lg:flex lg:space-x-4 space-y-2 lg:space-y-0">
                        <!-- Guru -->
                        <div class="w-full">
                            <label
                                for="nip_guru"
                                class="block text-sm text-gray-700"
                                >Guru<span class="text-red-700">*</span></label
                            >
                            <select
                                id="nip_guru"
                                v-model="model.nip_guru"
                                name="nip_guru"
                                autocomplete="nip_guru"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm text-sm border-gray-300 rounded-md"
                            >
                                <option
                                    v-for="item in guruData"
                                    v-bind:key="item.nip_guru"
                                    :value="item.nip_guru"
                                >
                                    {{ item.nama_guru }}
                                </option>
                            </select>
                        </div>

                        <!-- Kelas -->
                        <div class="w-full">
                            <label
                                for="kode_kelas"
                                class="block text-sm text-gray-700"
                                >Kelas<span class="text-red-700">*</span></label
                            >
                            <select
                                id="kode_kelas"
                                v-model="model.kode_kelas"
                                name="kode_kelas"
                                autocomplete="kode_kelas"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm text-sm border-gray-300 rounded-md"
                            >
                                <option
                                    v-for="item in kelasData"
                                    v-bind:key="item.kode_kelas"
                                    :value="item.kode_kelas"
                                >
                                    {{ item.tingkat_kelas }}
                                    {{ item.jurusan_kelas }}
                                    {{ item.nomor_kelas }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <!-- Sesi -->
                    <div>
                        <label for="sesi" class="block text-sm text-gray-700"
                            >Sesi<span class="text-red-700">*</span></label
                        >
                        <select
                            id="sesi"
                            v-model="model.sesi"
                            name="sesi"
                            autocomplete="sesi"
                            class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm text-sm border-gray-300 rounded-md"
                        >
                            <option
                                v-for="item in sesiData"
                                v-bind:key="item.id"
                                :value="item.id"
                            >
                                {{ item.nama_sesi }} (
                                {{ item.jam_mulai_sesi }}-
                                {{ item.jam_selesai_sesi }})
                            </option>
                        </select>
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
                            @click="deleteJadwal(route.params.id)"
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
                                @click="updateJadwal"
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

const route = useRoute();

const router = useRouter();
let model = ref({
    kode_jadwal: null,
    mata_pelajaran_jadwal: null,
    hari_jadwal: null,
    nip_guru: null,
    nama_guru: null,
    nama_sesi: null,
    sesi:null,
    jam_mulai_sesi: null,
    jam_selesai_sesi: null,
    tingkat_kelas: null,
    jurusan_kelas: null,
    nomor_kelas: null,
});
const confirmation = ref(false);
const confirmationUpdate = ref(false);
function toggleConfirmation() {
    confirmation.value = !confirmation.value;
}

function toggleUpdateConfirmation() {
    confirmationUpdate.value = !confirmationUpdate.value;
}

function tambahJadwalConfirmation() {
    if (route.params.id) {
        confirmationUpdate.value = true
    } else {
        store.dispatch("tambahJadwal", model.value).then(res => {
            if (res.request.status == 200) {
                router.push({
                    name: "Jadwal",
                });
                store.commit("notify", {
                    type: "success",
                    message: 'Tambah data jadwal berhasil!',
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

function updateJadwal() {
    store.dispatch("updateJadwal", model.value).then(res => {
        if (res.request.status == 200) {
            router.push({
                name: "Jadwal",
            });
            store.commit("notify", {
                type: "success",
                message: 'Ubah data jadwal berhasil!',
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


if (route.params.id) {
    store.dispatch("showJadwal", route.params.id);
}

store.dispatch("getKelas");
const kelasData = computed(() => store.state.kelas.data);

store.dispatch("getGuru");
const guruData = computed(() => store.state.guru.data);

const sesiData = computed(() => store.state.sesi.data);

store.dispatch("getSesi");

function deleteJadwal(value) {
    store.dispatch("deleteJadwal", value).then(
        router.push({
            name: "Jadwal",
        }));
    store.commit("notify", {
        type: "success",
        message: "Data berhasil dihapus!"
    });
    confirmation.value = false
}

watch(
    () => store.state.currentJadwal.data,
    (newVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
        };
    }
);

const loading = computed(() => store.state.currentJadwal.loading);
</script>
<style></style>
