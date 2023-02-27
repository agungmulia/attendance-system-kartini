<template>
    <DefaultPage>
        <LoadingView v-if="loading" />
        <div v-else>
            <div
                v-if="route.params.id"
                class="flex items-center justify-between"
            >
                <span class="text-blue-900 font-medium">Edit Data Guru</span>
                <button
                    type="button"
                    @click.prevent="confirmation = true"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto"
                >
                    Hapus Data
                </button>
            </div>
            <div v-else class="flex items-center justify-between">
                <span class="text-blue-900 font-medium">Tambah Data Guru</span>
            </div>
            <form @submit.prevent="tambahGuruConfirmation">
                <div
                    class="px-4 py-6 space-y-2 mt-4 bg-white rounded-lg shadow-sm"
                >
                    <!-- Foto -->
                    <div>
                        <label
                            for="foto_guru"
                            class="block text-sm text-gray-700"
                            >Foto</label
                        >
                        <div class="flex items-center">
                            <img
                                class="rounded-full w-14 h-14"
                                v-if="model.foto_guru_url"
                                :src="model.foto_guru_url"
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
                                for="nip_guru"
                                class="block text-sm text-gray-700"
                                >Nomor Induk Pengajar<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                name="nip_guru"
                                id="nip_guru"
                                v-model="model.nip_guru"
                                autocomplete="nip_guru"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>

                        <!-- Nama -->
                        <div class="w-full">
                            <label
                                for="nama_guru"
                                class="block text-sm text-gray-700"
                                >Nama<span class="text-red-700">*</span></label
                            >
                            <input
                                type="text"
                                name="nama_guru"
                                id="nama_guru"
                                v-model="model.nama_guru"
                                autocomplete="nama_guru"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>
                    </div>

                    <div class="lg:flex lg:space-x-4 space-y-2 lg:space-y-0">
                        <!-- Alamat -->
                        <div class="lg:w-full">
                            <label
                                for="alamat_guru"
                                class="block text-sm text-gray-700"
                                >Alamat<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <textarea
                                type="text"
                                name="alamat_guru"
                                id="alamat_guru"
                                v-model="model.alamat_guru"
                                autocomplete="alamat_guru"
                                class="mt-1 lg:h-28 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>

                        <div class="lg:w-full space-y-2">
                            <!-- Jenis Kelamin -->
                            <div>
                                <label
                                    for="jenis_kelamin_guru"
                                    class="block text-sm text-gray-700"
                                    >Jenis Kelamin<span class="text-red-700"
                                        >*</span
                                    ></label
                                >
                                <select
                                    id="jenis_kelamin_guru"
                                    v-model="model.jenis_kelamin_guru"
                                    name="jenis_kelamin_guru"
                                    autocomplete="jenis_kelamin_guru"
                                    class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm text-sm border-gray-300 rounded-md"
                                >
                                    <option>Laki-laki</option>
                                    <option>Perempuan</option>
                                </select>
                            </div>

                            <!-- Wali Kelas -->
                            <div>
                                <label
                                    for="wali_kelas"
                                    class="block text-sm text-gray-700"
                                    >Wali Kelas</label
                                >
                                <select
                                    id="wali_kelas"
                                    v-model="model.kode_kelas"
                                    name="wali_kelas"
                                    autocomplete="wali_kelas"
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
                                for="tempat_lahir"
                                class="block text-sm text-gray-700"
                                >Tempat Lahir<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                name="tempat_lahir"
                                id="tempat_lahir"
                                v-model="model.tempat_lahir_guru"
                                autocomplete="tempat_lahir"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>
                        <!-- Tanggal Lahir -->
                        <div class="lg:w-full">
                            <label
                                for="tanggal_lahir_guru"
                                class="block text-sm text-gray-700"
                                >Tanggal Lahir<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <input
                                type="date"
                                name="tanggal_lahir_guru"
                                id="tanggal_lahir_guru"
                                v-model="model.tanggal_lahir_guru"
                                autocomplete="tanggal_lahir_guru"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>
                    </div>
                    <div class="lg:flex lg:space-x-4 space-y-2 lg:space-y-0">
                        <!-- Email -->
                        <div class="lg:w-full">
                            <label
                                for="email_guru"
                                class="block text-sm text-gray-700"
                                >Email<span class="text-red-700">*</span></label
                            >
                            <input
                                type="text"
                                name="email_guru"
                                id="email_guru"
                                v-model="model.email_guru"
                                autocomplete="email_guru"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>
                        <!-- No Telp -->
                        <div class="lg:w-full">
                            <label
                                for="no_telp_guru"
                                class="block text-sm text-gray-700"
                                >Nomor Telepon<span class="text-red-700"
                                    >*</span
                                ></label
                            >
                            <input
                                type="text"
                                name="no_telp_guru"
                                id="no_telp_guru"
                                v-model="model.no_telp_guru"
                                autocomplete="no_telp_guru"
                                class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-400 rounded-lg"
                            />
                        </div>
                    </div>
                    <span class="text-sm text-gray-500"
                        >Note: Pastikan data bertanda
                        <span class="text-red-600">*</span> tidak kosong!</span
                    >
                    <button
                    type="submit"
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
                        @click="deleteGuru(route.params.id)"
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
                    @click="updateGuru"
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
function deleteGuru(value) {
    store.dispatch("deleteGuru", value).then(
        router.push({
            name: "Guru",
        }));
    store.commit("notify", {
        type: "success",
        message: "Data berhasil dihapus!"
    });
    confirmation.value = false
}

const route = useRoute();

const router = useRouter();

let model = ref({
    foto_guru: null,
    foto_guru_url: null,
    nama_guru: null,
    nip_guru: null,
    tingkat_kelas: null,
    jurusan_kelas: null,
    nomor_kelas: null,
    kode_kelas: null,
    alamat_guru: null,
    tempat_lahir_guru: null,
    tanggal_lahir_guru: null,
    jenis_kelamin_guru: null,
    email_guru: null,
    no_telp_guru: null,
    password_guru: null,
});

if (route.params.id) {
    store.dispatch("cariGuru", route.params.id);
}
const loading = computed(() => store.state.currentGuru.loading);

store.dispatch("getKelas");
const kelasData = computed(() => store.state.kelas.data);
function onImageChoose(ev) {
    const file = ev.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
        model.value.foto_guru = reader.result;

        model.value.foto_guru_url = reader.result;

    };
    reader.readAsDataURL(file);
}

function tambahGuruConfirmation(){
    if(route.params.id){
        confirmationUpdate.value = true
    }else{
        store.dispatch("tambahGuru", model.value).then(() => {
            store.dispatch("getGuru");
            router.push({
                name: "Guru",
            });
        });
    }
}

function updateGuru(){
    store.dispatch("updateGuru", model.value).then((data) => {
        router.push({
            name: "Guru",
        });
    });
}
watch(
    () => store.state.currentGuru.data,
    (newVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
        };
    }
);
</script>
<style></style>
