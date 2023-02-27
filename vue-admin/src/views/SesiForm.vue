<template>
    <DefaultPage>
        <LoadingView v-if="loading" />
        <div v-else>
            <div
                v-if="route.params.id"
                class="flex items-center justify-between"
            >
                <span class="text-blue-900 font-medium">Edit Data Sesi</span>
                <button
                    @click.prevent="confirmation = true"
                        type="button"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto"
                >
                    Hapus Data
                </button>
            </div>
            <div v-else class="flex items-center justify-between">
                <span class="text-blue-900 font-medium">Tambah Data Sesi</span>
            </div>
            <form @submit.prevent="tambahSesiConfirmation">
                <div
                    class="px-4 py-6 space-y-2 mt-4 bg-white rounded-lg shadow-sm"
                >
                    <div class="lg:flex lg:space-x-4 space-y-2 lg:space-y-0">
                        <!-- Nama Sesi -->
                        <div class="w-full">
                            <label
                                for="nama_sesi"
                                class="block text-sm text-gray-700"
                                >Nama Sesi<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                name="nama_sesi"
                                id="nama_sesi"
                                v-model="model.nama_sesi"
                                autocomplete="nama_sesi"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>

                        <div class="w-full">
                            <!-- Jam Mulai Sesi -->
                            <div class="w-full">
                                <label
                                    for="jam_mulai_sesi"
                                    class="block text-sm text-gray-700"
                                    >Jam Mulai<span class="text-red-700"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="time"
                                    name="jam_mulai_sesi"
                                    id="jam_mulai_sesi"
                                    v-model="model.jam_mulai_sesi"
                                    autocomplete="jam_mulai_sesi"
                                    class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                                />
                            </div>
                        </div>

                        <div class="w-full">
                            <!-- Jam Selesai Sesi -->
                            <div class="w-full">
                                <label
                                    for="jam_mulai_sesi"
                                    class="block text-sm text-gray-700"
                                    >Jam Selesai<span class="text-red-700"
                                        >*</span
                                    ></label
                                >
                                <input
                                    type="time"
                                    name="jam_selesai"
                                    id="jam_selesai"
                                    v-model="model.jam_selesai_sesi"
                                    autocomplete="jam_selesai"
                                    class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                                />
                            </div>
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
                            @click="deleteSesi(route.params.id)"
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
                            @click="updateSesi"
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
import ConfirmView from "../components/ConfirmView.vue";
import AccountCircleIcon from "vue-material-design-icons/AccountCircle.vue";
import { UserCircleIcon } from "@heroicons/vue/20/solid";
import DeleteCircleIcon from "vue-material-design-icons/DeleteCircleOutline.vue";
import { computed, ref, watch } from "vue";
import store from "../store/index.js";
import { TrashIcon,PencilIcon } from '@heroicons/vue/24/outline';
import { useRoute, useRouter } from "vue-router";

const route = useRoute();

const router = useRouter();
const confirmation = ref(false);
const confirmationUpdate = ref(false);
if (route.params.id) {
    store.dispatch("showSesi", route.params.id);
}
let model = ref({
    nama_sesi: null,
    jam_mulai_sesi: null,
    jam_selesai_sesi: null,
});


function toggleUpdateConfirmation() {
    confirmationUpdate.value = !confirmationUpdate.value;
}

function toggleConfirmation() {
    confirmation.value = !confirmation.value;
}

function tambahSesiConfirmation() {
    if (route.params.id) {
        confirmationUpdate.value = true
    } else {
        store.dispatch("tambahSesi", model.value).then(() => {
            store.dispatch("getSesi");
            router.push({
                name: "Sesi",
            });
        });
    }
}

function updateSesi() {
    store.dispatch("updateSesi", model.value).then((data) => {
        router.push({
            name: "Sesi",
        });
    });
}

function deleteSesi(value) {
    store.dispatch("deleteSesi", value).then(
        router.push({
            name: "Sesi",
        }));
    store.commit("notify", {
        type: "success",
        message: "Data berhasil dihapus!"
    });
    confirmation.value = false
}
watch(
    () => store.state.currentSesi.data,
    (newVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
        };
    }
);

const loading = computed(() => store.state.currentSesi.loading);
</script>
<style></style>
