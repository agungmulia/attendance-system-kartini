<template>
    <DefaultPage>
        <LoadingView v-if="loading" />
        <div v-else>
            <div
                v-if="route.params.id"
                class="flex items-center justify-between"
            >
                <span class="text-blue-900 font-medium">Edit Data Siswa</span>
                <button
                    type="button"
                    @click.prevent = "confirmation = true"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto"
                >
                    Hapus Data
                </button>
            </div>
            <div v-else class="flex items-center justify-between">
                <span class="text-blue-900 font-medium">Tambah Data Siswa</span>
            </div>
            <form @submit.prevent="tambahSiswaConfirmation">
                <div
                    class="px-4 py-6 space-y-2 mt-4 bg-white rounded-lg shadow-sm"
                >
                    <!-- Foto -->
                    <div>
                        <label
                            for="foto_siswa"
                            class="block text-sm  text-gray-700"
                            >Foto</label
                        >
                        <div class="flex items-center">
                            <img
                                class="rounded-full w-14 h-14"
                                v-if="model.foto_siswa_url"
                                :src="model.foto_siswa_url"
                            />

                            <UserCircleIcon
                                v-else
                                class="text-gray-300 w-14 h-14"
                            />

                            <button
                                type="button"
                                class="relative overflow-hidden bg-red-700 hover:bg-red-600 duration-200 py-2 px-4 my-2 border rounded-lg shaddow-md text-sm leading-4 font-medium text-white focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            >
                                <input
                                    @change="onImageChoose"
                                    type="file"
                                    class="absolute left-0 top-0 right-0 bottom-0 w-full h-full opacity-0 cursor-pointer"
                                />Ganti Foto
                            </button>
                        </div>
                    </div>

                    <div class="lg:flex lg:space-x-4 space-y-2 lg:space-y-0">
                        <!-- NIP -->
                        <div class="w-full">
                            <label
                                for="nip_siswa"
                                class="block text-sm text-gray-700"
                                >Nomor Induk Siswa<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                name="nip_siswa"
                                id="nip_siswa"
                                v-model="model.nis_siswa"
                                autocomplete="nip_siswa"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>

                        <!-- Nama -->
                        <div class="w-full">
                            <label
                                for="nama_siswa"
                                class="block text-sm text-gray-700"
                                >Nama<span class="text-red-700">*</span></label
                            >
                            <input
                                type="text"
                                name="nama_siswa"
                                id="nama_siswa"
                                v-model="model.nama_siswa"
                                autocomplete="nama_siswa"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>
                    </div>

                    <div class="lg:flex lg:space-x-4 space-y-2 lg:space-y-0">
                        <!-- Alamat -->
                        <div class="lg:w-full">
                            <label
                                for="alamat_siswa"
                                class="block text-sm text-gray-700"
                                >Alamat<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <textarea
                                type="text"
                                name="alamat_siswa"
                                id="alamat_siswa"
                                v-model="model.alamat_siswa"
                                autocomplete="alamat_siswa"
                                class="mt-1 lg:h-28 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>

                        <div class="lg:w-full space-y-2">
                            <!-- Jenis Kelamin -->
                            <div>
                                <label
                                    for="jenis_kelamin_siswa"
                                    class="block text-sm text-gray-700"
                                    >Jenis Kelamin<span class="text-red-700"
                                        >*</span
                                    ></label
                                >
                                <select
                                    id="jenis_kelamin_siswa"
                                    v-model="model.jenis_kelamin_siswa"
                                    name="jenis_kelamin_siswa"
                                    autocomplete="jenis_kelamin_siswa"
                                    class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm text-sm border-gray-300 rounded-md"
                                >
                                    <option>Laki-laki</option>
                                    <option>Perempuan</option>
                                </select>
                            </div>

                            <!--  Kelas -->
                            <div>
                                <label
                                    for="kode_kelas"
                                    class="block text-sm text-gray-700"
                                    >Kelas</label
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
                    </div>
                    <div class="lg:flex lg:space-x-4 space-y-2 lg:space-y-0">
                        <!-- Tempat Lahir -->
                        <div class="lg:w-full">
                            <label
                                for="tempat_lahir_siswa"
                                class="block text-sm text-gray-700"
                                >Tempat Lahir<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                name="tempat_lahir_siswa"
                                id="tempat_lahir_siswa"
                                v-model="model.tempat_lahir_siswa"
                                autocomplete="tempat_lahir_siswa"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>
                        <!-- Tanggal Lahir -->
                        <div class="lg:w-full">
                            <label
                                for="tanggal_lahir_siswa"
                                class="block text-sm text-gray-700"
                                >Tanggal Lahir<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <input
                                type="date"
                                name="tanggal_lahir_siswa"
                                id="tanggal_lahir_siswa"
                                v-model="model.tanggal_lahir_siswa"
                                autocomplete="tanggal_lahir_siswa"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>
                    </div>

                    <div class="lg:flex lg:space-x-4 space-y-2 lg:space-y-0">
                        <!-- Email -->
                        <div class="lg:w-full">
                            <label
                                for="email_siswa"
                                class="block text-sm text-gray-700"
                                >Email<span class="text-red-700">*</span></label
                            >
                            <input
                                type="text"
                                name="email_siswa"
                                id="email_siswa"
                                v-model="model.email_siswa"
                                autocomplete="email_siswa"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>
                        <!-- No Telp -->
                        <div class="lg:w-full">
                            <label
                                for="no_telp_siswa"
                                class="block text-sm text-gray-700"
                                >Nomor Telepon<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                name="no_telp_siswa"
                                id="no_telp_siswa"
                                v-model="model.no_telp_siswa"
                                autocomplete="no_telp_siswa"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>

                        <!-- Nomor Telepon Orang Tua -->
                                <div class="w-full">
                                    <label
                                        for="no_telp_orang_tua"
                                        class="block text-sm text-gray-700"
                                        >Nomor Telepon Orang Tua<span class="text-red-700"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        name="no_telp_orang_tua"
                                        id="tempat_lahir_siswa"
                                        v-model="model.no_telp_orang_tua"
                                        autocomplete="no_telp_orang_tua"
                                        class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                                    />
                                </div>
                    </div>
                    <div v-if="route.params.id" class="flex space-x-4">
                        <!-- Hadir Siswa -->
                        <div>
                            <label
                                for="total_hadir_presensi"
                                class="block text-sm text-gray-700"
                                >Hadir</label
                            >
                            <input
                                type="text"
                                name="hadir_siswa"
                                id="hadir_siswa"
                                disabled
                                v-model="model.total_hadir_presensi"
                                autocomplete="total_hadir_presensi"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>

                        <!-- Izin Siswa -->
                        <div>
                            <label
                                for="total_izin_presensi"
                                class="block text-sm text-gray-700"
                                >Izin</label
                            >
                            <input
                                type="text"
                                name="izin_siswa"
                                id="izin_siswa"
                                v-model="model.total_izin_presensi"
                                disabled
                                autocomplete="total_izin_presensi"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>

                        <!-- Alpha Siswa -->
                        <div>
                            <label
                                for="total_alpha_presensi"
                                class="block text-sm text-gray-700"
                                >Alpha</label
                            >
                            <input
                                type="text"
                                name="alpha_siswa"
                                id="alpha_siswa"
                                disabled
                                v-model="model.total_alpha_presensi"
                                autocomplete="total_alpha_presensi"
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
                            @click="deleteSiswa(route.params.id)"
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
                        @click="updateSiswa"
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

const alertMessage = ref("");
const updateConfirm = ref(false);
const confirmation = ref(false);
const confirmationUpdate = ref(false);
function toggleUpdateConfirmation() {
    confirmationUpdate.value = !confirmationUpdate.value;
}
function toggleConfirmation() {
    confirmation.value = !confirmation.value;
}
const route = useRoute();

const router = useRouter();

store.dispatch("getKelas");
const kelasData = computed(() => store.state.kelas.data);

let model = ref({
    foto_siswa: null,
    foto_siswa_url: null,
    nama_siswa: null,
    nip_siswa: null,
    tingkat_kelas: null,
    jurusan_kelas: null,
    nomor_kelas: null,
    kode_kelas: null,
    tempat_lahir_siswa: null,
    tanggal_lahir_siswa: null,
    no_telp_orang_tua: null,
    alamat_siswa: null,
    jenis_kelamin_siswa: null,
    email_siswa: null,
    no_telp_siswa: null,
    password_siswa: null,
    total_hadir_presensi: null,
    total_izin_presensi: null,
    total_alpha_presensi: null,
});

let kelas = ref("");

if (route.params.id) {
    store.dispatch("showSiswa", route.params.id);
}

const loading = computed(() => store.state.currentSiswa.loading);

function tambahSiswaConfirmation() {
    if (route.params.id) {
        confirmationUpdate.value = true
    } else {
        store.dispatch("tambahSiswa", model.value).then(res => {
            if (res.request.status == 200) {
                router.push({
                    name: "Siswa",
                });
                store.commit("notify", {
                    type: "success",
                    message: 'Tambah data siswa berhasil!',
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

function updateSiswa() {
    store.dispatch("updateSiswa", model.value).then(res => {
        if (res.request.status == 200) {
            router.push({
                name: "Siswa",
            });
            store.commit("notify", {
                type: "success",
                message: 'Ubah data siswa berhasil!',
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

function deleteSiswa(value) {
    store.dispatch("deleteSiswa", value).then(
        router.push({
            name: "Siswa",
        })
    );
    store.commit("notify", {
        type: "success",
        message: "Data berhasil dihapus!"
    });
    confirmation.value = false
}

function onImageChoose(ev) {
    const file = ev.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
        model.value.foto_siswa = reader.result;

        model.value.foto_siswa_url = reader.result;

    };
    reader.readAsDataURL(file);
}

watch(
    () => store.state.currentSiswa.data,
    (newVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
        };

    }
);
</script>
<style></style>
