<template>
    <div class="md:pl-80 bg-gray-100 flex flex-col flex-1">
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
            <LoadingView v-if="guruLoading" />
            <div v-else>
                <div
                    class="py-6 text-blue-900 bg-white px-10 lg:px-8 shadow-md hidden md:flex justify-between"
                >
                    <span class="font-bold text-xl"> Profil </span>
                </div>
                <div class="max-w-7 pt-6 px-10 lg:px-8 animate-fade-in-left">
                    <div class="grid lg:flex lg:space-x-4">
                        <div
                            class="py-2 grid lg:w-fit lg:justify-between rounded-lg shadow-sm bg-white px-4"
                        >
                            <div>
                                <div
                                    class="grid lg:px-4 justify-items-center lg:flex items-center lg:space-x-4"
                                >
                                    <div class="grid">
                                        <img
                                            class="w-40 h-40 rounded-full"
                                            v-if="model.foto_guru_url"
                                            :src="model.foto_guru_url"
                                        />

                                        <UserCircleIcon
                                            v-else
                                            class="text-gray-300 h-40 w-40"
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
                                    <div class="grid">
                                        <span
                                            class="text-blue-900 font-medium text-xl"
                                            >{{ model.nama_guru }}
                                            <span class="text-green-600"
                                                >({{ model.nip_guru }})</span
                                            >
                                        </span>

                                        <span class="text-gray-400"
                                            >{{ model.tingkat_kelas }}
                                            {{ model.jurusan_kelas }}
                                            {{ model.nomor_kelas }}
                                        </span>

                                        <span class="text-blue-400">{{
                                            model.jenis_kelamin_guru
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-white rounded-lg shadow-sm py-4 px-4"
                            >
                                <div class="grid">
                                    <div>
                                        <div>
                                            <label
                                                for="tempat_tanggal_lahir"
                                                class="block text-sm font-medium text-gray-700"
                                                >Tempat & Tanggal Lahir:</label
                                            >
                                            <div
                                                class="text-blue-900 font-medium"
                                            >
                                                <span
                                                    >{{
                                                        model.tempat_lahir_guru
                                                    }},
                                                    {{
                                                        new Date(
                                                            model.tanggal_lahir_guru
                                                        ).toLocaleDateString(
                                                            "id-ID",
                                                            {
                                                                day: "numeric",
                                                                month: "long",
                                                                year: "numeric",
                                                            }
                                                        )
                                                    }}</span
                                                >
                                            </div>
                                        </div>
                                        <div>
                                            <label
                                                for="alamat"
                                                class="block text-sm font-medium text-gray-700"
                                                >Alamat:</label
                                            >
                                            <div class="mt-1">
                                                <textarea
                                                    v-model="model.alamat_guru"
                                                    id="about"
                                                    name="about"
                                                    rows="3"
                                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                />
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <span
                                                class="text-blue-900 text-lg font-medium"
                                                >{{ model.email_guru }}</span
                                            >
                                        </div>

                                        <div>
                                            <label
                                                for="first-name"
                                                class="block text-sm font-medium text-gray-700"
                                                >No Telp:</label
                                            >
                                            <input
                                                type="text"
                                                v-model="model.no_telp_guru"
                                                name="no_telp"
                                                id="no_telp"
                                                autocomplete="no_telp"
                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500"
                                    >Note: Update hanya untuk beberapa data di
                                    dalam input termasuk foto profil</span
                                >
                                <button
                                    @click.prevent="confirmation = true"
                                    class="mt-4 bg-red-700 hover:bg-red-600 duration-200 px-6 py-2 w-full text-white rounded-lg"
                                >
                                    Ubah Profil
                                </button>
                            </div>
                            <ConfirmView
                                :confirmation="confirmation"
                                @close="toggleConfirmation"
                            >
                                <template v-slot:messageValue>
                                    <div class="grid w-full">
                                        <img
                                            class="w-40 h-40 rounded-full"
                                            v-if="model.foto_guru_url"
                                            :src="model.foto_guru_url"
                                        />
                                        <label class="text-sm text-gray-400"
                                            >Alamat:</label
                                        >
                                        <span>{{ model.alamat_guru }}</span>
                                        <label class="text-sm text-gray-400"
                                            >No Telp:</label
                                        >
                                        <span>{{ model.no_telp_guru }} </span>
                                    </div>
                                </template>

                                <button
                                    type="submit"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-900 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                    @click="updateProfileGuru"
                                >
                                    Lanjut
                                </button>
                                <button
                                    type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                    @click="confirmation = false"
                                >
                                    Cancel
                                </button>
                            </ConfirmView>
                        </div>

                        <form class="mt-8 lg:mt-0">
                            <div
                                class="py-4 grid lg:justify-between space-y-4 rounded-lg shadow-sm bg-white px-4"
                            >
                                <div class="lg:flex">
                                    <div class="w-full">
                                        <label
                                            for="password_lama"
                                            class="block text-sm font-medium text-gray-700"
                                            >Password lama</label
                                        >
                                        <input
                                            v-model="
                                                passwordValue.password_lama
                                            "
                                            :type="passwordLama"
                                            name="passwordLama"
                                            id="passwordLama"
                                            autocomplete="passwordLama"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                        />
                                        <div class="flex items-center">
                                            <button
                                                type="button"
                                                class="text-xs mt-1 space-x-2 flex items-center"
                                                @click="lihatPasswordLama"
                                            >
                                                <EyeOffIcon
                                                    :size="20"
                                                    v-if="
                                                        passwordLama ===
                                                        'password'
                                                    "
                                                />
                                                <EyeOpenIcon
                                                    :size="20"
                                                    v-else
                                                />
                                                <span> Lihat Password </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="w-full pt-4 lg:pt-0 lg:ml-6">
                                        <div class="w-full">
                                            <label
                                                for="password_baru"
                                                class="block text-sm font-medium text-gray-700"
                                                >Password Baru</label
                                            >
                                            <input
                                                v-model="
                                                    passwordValue.password_baru
                                                "
                                                :type="passwordBaru"
                                                name="passwordBaru"
                                                id="passwordBaru"
                                                autocomplete="passwordBaru"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            />
                                            <div class="flex items-center">
                                                <button
                                                    type="button"
                                                    class="text-xs mt-1 space-x-2 flex items-center"
                                                    @click="lihatPasswordBaru"
                                                >
                                                    <EyeOffIcon
                                                        :size="20"
                                                        v-if="
                                                            passwordBaru ===
                                                            'password'
                                                        "
                                                    />
                                                    <EyeOpenIcon
                                                        :size="20"
                                                        v-else
                                                    />
                                                    <span>
                                                        Lihat Password
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="w-full mt-4">
                                            <label
                                                for="konfirmasi_password_baru"
                                                class="block text-sm font-medium text-gray-700"
                                                >Konfirmasi Password Baru</label
                                            >
                                            <input
                                                v-model="
                                                    passwordValue.password_baru_confirmation
                                                "
                                                :type="konfirmasiPasswordBaru"
                                                name="konfirmasiPasswordBaru"
                                                id="konfirmasiPasswordBaru"
                                                autocomplete="konfirmasiPasswordBaru"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            />
                                            <div class="flex items-center">
                                                <button
                                                    type="button"
                                                    class="text-xs mt-1 space-x-2 flex items-center"
                                                    @click="
                                                        lihatPasswordBaruKonfirmasi
                                                    "
                                                >
                                                    <EyeOffIcon
                                                        :size="20"
                                                        v-if="
                                                            konfirmasiPasswordBaru ===
                                                            'password'
                                                        "
                                                    />
                                                    <EyeOpenIcon
                                                        :size="20"
                                                        v-else
                                                    />
                                                    <span>
                                                        Lihat Password
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    @click="
                                        checkPasswordBaru(
                                            passwordValue.password_baru,
                                            passwordValue.password_baru_confirmation,
                                            passwordValue.password_lama
                                        )
                                    "
                                    class="mt-4 bg-red-700 hover:bg-red-600 duration-200 px-2 py-2 text-white rounded-lg"
                                >
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <AlertView
            :alert_message="alertMessage"
            :alertActive="open"
            @close="toggleModal"
        />
    </div>
</template>

<script setup>
import LoadingView from "../components/LoadingView.vue";
import ConfirmView from "../components/ConfirmView.vue";
import { sharedConstant } from "../utils";
import AlertView from "../components/AlertView.vue";
import { Bars3Icon } from "@heroicons/vue/24/outline";
import { UserCircleIcon } from "@heroicons/vue/20/solid";
import { ref, computed, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import store from "../store/index.js";
import EyeOpenIcon from "vue-material-design-icons/Eye.vue";
import EyeOffIcon from "vue-material-design-icons/EyeOff.vue";

const route = useRoute();

const router = useRouter();

const guruLoading = computed(() => store.state.currentGuru.loading);

const passwordLama = ref("password");
const passwordBaru = ref("password");
const konfirmasiPasswordBaru = ref("password");

function onImageChoose(ev) {
    const file = ev.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
        model.value.foto_guru = reader.result;

        model.value.foto_guru_url = reader.result;
    };
    reader.readAsDataURL(file);
}

function lihatPasswordLama() {
    passwordLama.value =
        passwordLama.value === "password" ? "text" : "password";
}

function lihatPasswordBaru() {
    passwordBaru.value =
        passwordBaru.value === "password" ? "text" : "password";
}
function lihatPasswordBaruKonfirmasi() {
    konfirmasiPasswordBaru.value =
        konfirmasiPasswordBaru.value === "password" ? "text" : "password";
}

function checkPasswordBaru(value1, value2, value3) {
    return value1 != null && value2 != null && value3 != null
        ? value1 != value2
            ? toggleModal("Konfirmasi Password Anda Dengan Benar!")
            : updatePassword()
        : toggleModal("Password Tidak Boleh Kosong!");
}

let updateMessage = ref();

function updatePassword() {
    store.dispatch("updatePassword", passwordValue.value);
}

function updateProfileGuru() {
    confirmation.value = false;
    store.dispatch("updateProfile", model.value);
}

const open = ref(false);
const confirmation = ref(false);
const lanjutConfirm = ref(false);
const updateConfirm = ref(false);
const alertMessage = ref("");

function toggleConfirmation() {
    confirmation.value = !confirmation.value;
}

function toggleModal(value) {
    open.value = !open.value;
    alertMessage.value = value;
}

let passwordValue = ref({
    password_lama: null,
    password_baru: null,
    password_baru_confirmation: null,
});

let model = ref({
    foto_guru: null,
    foto_guru_url: null,
    nama_guru: null,
    nip_guru: null,
    alamat_guru: null,
    jenis_kelamin_guru: null,
    email_guru: null,
    no_telp_guru: null,
    password_guru: null,
});

watch(
    () => store.state.currentGuru.data,
    (newVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
        };
    }
);

const sidebarOpen = sharedConstant;

store.dispatch("getGuruProfile");
</script>
<script>
export default {
    data() {
        return {
            guru: [],
        };
    },
};
</script>
<style></style>
