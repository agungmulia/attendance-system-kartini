<template>
    <DefaultPage pageHeading="X Multimedia 1">
        <LoadingView v-if="loading" />
        <div v-else>
            <div class="lg:w-[80%] flex justify-between items-center">
                <div class="grid">
                    <span class="text-xs text-red-600">Peringatan!</span>
                    <span class="text-xs text-gray-500"
                        >Izin harus disertai keterangan</span
                    >
                </div>
                <button
                    :class="[
                        hadiersemoea
                            ? 'px-2 py-2 bg-green-500 text-white rounded-lg mb-2'
                            : 'px-2 py-2 bg-gray-300 text-white rounded-lg mb-2',
                    ]"
                    type="button"
                    @click="funcHadirSemua"
                >
                    Hadir Semua
                </button>
            </div>

            <table class="table-auto w-full lg:w-[80%] border-2">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            scope="col"
                            class="py-3.5 pl-4 hidden lg:table-cell pr-3 text-left text-xs font-semibold text-gray-900 sm:pl-6"
                        >
                            Nama
                        </th>

                        <th
                            scope="col"
                            class="px-3 py-3.5 hidden lg:table-cell text-left text-xs font-semibold text-gray-900"
                        >
                            Hadir
                        </th>
                        <th
                            scope="col"
                            class="px-3 py-3.5 hidden lg:table-cell text-left text-xs font-semibold text-gray-900"
                        >
                            Izin
                        </th>
                        <th
                            scope="col"
                            class="px-3 py-3.5 hidden lg:table-cell text-left text-xs font-semibold text-gray-900"
                        >
                            Alpha
                        </th>
                        <th
                            scope="col"
                            class="relative hidden lg:table-cell py-3.5 pl-3 pr-4 sm:pr-6"
                        >
                            <span class="sr-only">Lihat Data</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr
                        v-for="(item, itemIdx) in model"
                        :key="item.nis_siswa"
                        :class="
                            itemIdx % 2 === 0
                                ? undefined
                                : 'bg-gray-50 animate-fade-in-down'
                        "
                        :style="{ animationDelay: `${itemIdx * 0.1}s` }"
                    >
                        <td
                            class="text-sm text-blue-900 px-2 lg:table-cell hidden"
                        >
                            <div>
                                {{ item.nama_siswa }}
                            </div>
                            <span
                                class="text-xs text-gray-500"
                                v-if="hariUpdate(item.updated_at)"
                                >Status Absen: {{ item.status_absensi }}</span
                            >
                        </td>

                        <td
                            v-for="value in absensiValue"
                            :key="value"
                            class="w-20 whitespace-nowrap hidden lg:table-cell py-2"
                        >
                            <div
                                @click="item.absen = value"
                                class="bg-gray-300 lg:w-full h-12 cursor-pointer rounded-lg"
                                :class="cekWarna(item.absen, value)"
                            ></div>
                        </td>

                        <td
                            class="whitespace-nowrap w-full py-4 pl-3 pr-4 text-xs grid font-medium sm:pr-6"
                        >
                            <span
                                class="text-blue-900 lg:hidden font-medium text-sm"
                                >{{ item.nama_siswa }}</span
                            >
                            <div v-if="hariUpdate(item.updated_at)">
                                <span
                                    class="text-gray-500 lg:hidden font-medium text-xs"
                                    >Status Absen:
                                    {{ item.status_absensi }}</span
                                >
                            </div>

                            <div
                                class="flex space-x-2 lg:hidden justify-center"
                            >
                                <div
                                    v-for="value in absensiValue"
                                    :key="value"
                                    class="w-14 whitespace-nowrap py-2"
                                >
                                    <div
                                        @click="item.absen = value"
                                        class="bg-gray-300 text-white grid justify-items-center py-4 lg:w-full h-12 cursor-pointer rounded-lg"
                                        :class="cekWarna(item.absen, value)"
                                    >
                                        {{ value }}
                                    </div>
                                </div>
                            </div>
                            <input
                                v-model="item.keterangan_absensi"
                                :disabled="item.absen != 'izin'"
                                type="text"
                                placeholder="keterangan absensi"
                                class="rounded-lg w-full text-sm border-gray-300 focus:border-red-700 focus:ring-red-700"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
            <button
                @click="absenFunction"
                class="mt-4 bg-red-700 text-white rounded-lg px-4 py-1"
            >
                Absen
            </button>

            <AlertView
                alert_message="Data tidak boleh ada yang kosong!"
                :alertActive="open"
                @close="toggleModal"
            />
        </div>
    </DefaultPage>
</template>

<script>
export default {
    methods: {
        cekWarna(val1, value) {
            if (val1 === value) {
                if (val1 == "hadir") {
                    return "bg-green-400";
                } else if (val1 == "izin") {
                    return "bg-yellow-500";
                } else if (val1 == "alpha") {
                    return "bg-red-500";
                } else {
                    return "bg-gray-400";
                }
            }
        },
    },
};
</script>

<script setup>
import DefaultPage from "../components/DefaultPage.vue";
import { MagnifyingGlassIcon } from "@heroicons/vue/20/solid";
import LoadingView from "../components/LoadingView.vue";
import AlertView from "../components/AlertView.vue";
import store from "../store/index.js";
import { useRoute, useRouter } from "vue-router";
import { computed, ref, watch } from "vue";

const route = useRoute();
const router = useRouter();

const absensiValue = ["hadir", "izin", "alpha"];

const loading = computed(() => store.state.siswa.loading);

store.dispatch("showSiswaByKelas", route.params.id);

let model = ref({
    nip_siswa: null,
    nama_siswa: null,
    status_absensi: null,
    absen: null,
    keterangan_absensi: null,
    updated_at: null,
});

let hadiersemoea = ref(false);

const open = ref(false);
function toggleModal() {
    open.value = !open.value;
}

function funcHadirSemua() {
    Object.keys(model.value).forEach(function (key) {
        model.value[key].absen = "hadir";
    });
}

function absensiKosong() {
    for (let key in model.value) {
        if (model.value[key].absen === null) {
            return true;
        }
    }
    return false;
}

function hariUpdate(value) {
    let lastUpdate = new Date(value);
    let hariIni = new Date();
    return hariIni.toDateString() == lastUpdate.toDateString();
}

let tableData = ref();

watch(
    () =>
        store.state.siswa.data.map((v) => ({
            ...v,
            absen: null,
            keterangan_absensi: "",
        })),
    (newVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
        };

        hadiersemoea = computed(() =>
            Object.values(model.value).every((el) => el.absen == "hadir")
        );

        tableData = {
            tabledata: model.value,
        };
    }
);

function absenFunction() {
    if (absensiKosong()) {
        toggleModal();
    } else store.dispatch("absen", { tableData: model.value }).then(
        store.dispatch("showSiswaByKelas", route.params.id)
    );
}
</script>
<style></style>
