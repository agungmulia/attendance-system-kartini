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
                    <div class="grid">
                        <form>
                            <div
                                class="py-4 grid lg:flex lg:w-[70%] lg:justify-between space-y-1 rounded-lg shadow-sm bg-white px-4"
                            >
                                <div class="grid lg:w-[50%]">
                                    <span
                                        class="text-blue-900 font-medium text-xl"
                                        >{{ model.nama_guru }}
                                        <span class="text-green-600"
                                            >({{ model.nip_guru }})</span
                                        >
                                    </span>
                                    <span class="text-gray-400"
                                        >XI Multimedia 1</span
                                    >
                                    <span class="text-blue-400">{{
                                        model.jenis_kelamin_guru
                                    }}</span>
                                    <div>
                                        <label
                                            for="alamat"
                                            class="block text-sm font-medium text-gray-700"
                                            >Alamat:</label
                                        >
                                        <div class="mt-1">
                                            <textarea
                                                id="about"
                                                name="about"
                                                rows="3"
                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                                :value="model.alamat_guru"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-5 md:pt-0">
                                    <span
                                        class="text-blue-900 text-lg font-medium"
                                        >{{ model.email_guru }}</span
                                    >

                                    <div>
                                        <label
                                            for="first-name"
                                            class="block text-sm font-medium text-gray-700"
                                            >No Telp:</label
                                        >
                                        <input
                                            type="text"
                                            name="no_telp"
                                            id="no_telp"
                                            :value="model.no_telp_guru"
                                            autocomplete="no_telp"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                        />
                                    </div>
                                </div>
                            </div>
                            <button
                                class="mt-4 bg-red-700 hover:bg-red-600 duration-200 px-2 py-2 text-white rounded-lg"
                            >
                                Simpan
                            </button>
                        </form>
                        <form class="mt-8">
                            <div
                                class="py-4 grid lg:flex lg:w-[50%] lg:justify-between space-y-1 rounded-lg shadow-sm bg-white px-4"
                            >
                                <div class="w-full">
                                    <label
                                        for="password_lama"
                                        class="block text-sm font-medium text-gray-700"
                                        >Password lama</label
                                    >
                                    <input
                                        :type="passwordLama"
                                        name="passwordLama"
                                        id="passwordLama"
                                        autocomplete="passwordLama"
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
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
                                                    passwordLama === 'password'
                                                "
                                            />
                                            <EyeOpenIcon :size="20" v-else />
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
                                            type="password"
                                            name="passwordBaru"
                                            id="passwordBaru"
                                            autocomplete="passwordBaru"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                        />
                                        <div class="flex items-center">
                                            <button
                                                type="button"
                                                class="text-xs mt-1 space-x-2 flex items-center"
                                                @click="lihatPasswordFunc"
                                            >
                                                <EyeOffIcon
                                                    :size="20"
                                                    v-if="
                                                        passwordType ===
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
                                    <div class="w-full mt-4">
                                        <label
                                            for="konfirmasi_password_baru"
                                            class="block text-sm font-medium text-gray-700"
                                            >Konfirmasi Password Baru</label
                                        >
                                        <input
                                            type="password"
                                            name="konfirmasiPasswordBaru"
                                            id="konfirmasiPasswordBaru"
                                            autocomplete="konfirmasiPasswordBaru"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                        />
                                        <div class="flex items-center">
                                            <button
                                                type="button"
                                                class="text-xs mt-1 space-x-2 flex items-center"
                                                @click="lihatPasswordFunc"
                                            >
                                                <EyeOffIcon
                                                    :size="20"
                                                    v-if="
                                                        passwordType ===
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
                                </div>
                            </div>
                            <button
                                class="mt-4 bg-red-700 hover:bg-red-600 duration-200 px-2 py-2 text-white rounded-lg"
                            >
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import LoadingView from "../components/LoadingView.vue";
import { sharedConstant } from "../utils";
import { Bars3Icon } from "@heroicons/vue/24/outline";
import { ref, computed, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import store from "../store/index.js";
import EyeOpenIcon from "vue-material-design-icons/Eye.vue";
import EyeOffIcon from "vue-material-design-icons/EyeOff.vue";

const route = useRoute();

const router = useRouter();

const guruLoading = computed(() => store.state.currentGuru.loading);

const passwordLama = ref("password");

function lihatPasswordLama() {
    passwordLama.value =
        passwordLama.value === "password" ? "text" : "password";
}

let model = ref({
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
            ...JSON.parse(JSON.stringify(newVal[0])),
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
