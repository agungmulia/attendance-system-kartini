<template>
    <DefaultPage pageHeading="Kelas Anda">
        <LoadingView v-if="jadwalLoading" />
        <div v-else>
            <div v-if="Object.keys(jadwalData).length != 0">
                <div class="pb-4">
                    <h1 class="text-blue-900 text-xl font-semibold">
                        Jadwal Anda
                    </h1>
                </div>

                <div class="grid lg:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-8">
                    <div
                        v-for="(item, ind) in jadwalData"
                        :key="item.nama_kelas"
                        class="shadow-md rounded-xl animate-fade-in-down"
                        :style="{ animationDelay: `${ind * 0.1}s` }"
                    >
                        <div :class="cekJurusan(item.jurusan_kelas)">
                            <div class="grid">
                                <span class="text-xl font-semibold">
                                    {{
                                        item.tingkat_kelas +
                                        " " +
                                        item.jurusan_kelas +
                                        " " +
                                        item.nomor_kelas
                                    }}
                                </span>
                                <span class="text-blue-900 font-medium">{{
                                    item.mata_pelajaran_jadwal
                                }}</span>
                                <span>Wali Kelas: {{ item.nama_guru }}</span>
                                <span class="text-green-600"
                                    >{{ item.hari_jadwal }},
                                    {{ item.nama_sesi }}</span
                                >
                                <span class="text-gray-400 text-sm"
                                    >{{ item.total_murid }} Murid</span
                                >
                            </div>
                        </div>
                        <div
                            class="bg-gray-100 hover:bg-gray-200 duration-200 w-full px-4 py-2 rounded-b-xl"
                        >
                            <button
                                class="text-lg flex items-center text-blue-900 hover:text-blue-800"
                                @click="
                                    cek_today(item.hari_jadwal, item.kode_kelas)
                                "
                            >
                                <PencilIcon class="h-4 w-6" />
                                Absen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <div
                    class="w-full flex justify-center py-8 bg-white shadow-sm border rounded-lg"
                >
                    <span class="text-gray-400">Jadwal Anda Kosong!</span>
                </div>
            </div>
        </div>

        <AlertView
            alert_message="Waktu absen anda tidak Sesuai"
            :alertActive="today"
            @close="toggleModal"
        />
    </DefaultPage>
</template>

<script setup>
import { PencilIcon } from "@heroicons/vue/24/solid";
import DefaultPage from "../components/DefaultPage.vue";
import LoadingView from "../components/LoadingView.vue";
import AlertView from "../components/AlertView.vue";
import { computed, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import store from "../store/index.js";

const jadwalLoading = computed(() => store.state.jadwal.loading);
const jadwalData = computed(() => store.state.jadwal.data);

const route = useRoute();

const router = useRouter();

const today = ref(false);

function toggleModal() {
    today.value = !today.value;
}

function cek_today(value, value2) {
    if (hari() != value) {
        router.push({
            name: "Absensi",
            params: { id: value2 },
        });
    } else {
        return toggleModal();
    }
}

store.dispatch("getJadwal");

function cekJurusan(value) {
    if (value == "Desain Komunikasi Visual") {
        return "w-full bg-cyan-400 rounded-t-xl px-4 py-2 bg-opacity-25";
    } else if (value == "Akuntansi & Keuangan Lembaga") {
        return "w-full bg-yellow-400 rounded-t-xl px-4 py-2 bg-opacity-25";
    } else if (value == "Mesin") {
        return "w-full bg-green-400 rounded-t-xl px-4 py-2 bg-opacity-25";
    } else if (value == "Layanan Kesehatan") {
        return "w-full bg-pink-400 rounded-t-xl px-4 py-2 bg-opacity-25";
    } else {
        return "w-full bg-red-400 rounded-t-xl px-4 py-2 bg-opacity-25";
    }
}

function hari() {
    var a = new Date();
    return a.toLocaleDateString("id-ID", { weekday: "long" });
}
</script>
<style></style>
