<template>
    <DefaultPage>
        <LoadingView v-if="loading" />
        <div v-else>
            <div class="-mx-4 md:mx-0 flex justify-end">
                <div>
                    <router-link
                        :to="{ name: 'TambahGuru' }"
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
                        <div class=" flex items-center mt-4 mb-2 space-x-2">
                            <input
                                type="text"
                                v-model="search"
                                placeholder="Cari Guru"
                                class="focus:ring-red-500 focus:border-red-500 block w-full shadow-sm  border-gray-300 rounded-md"
                            />
                            <button @click.prevent="cariGuru" type="button" class=" px-5 py-2 h-fit  bg-red-600 hover:bg-red-900 duration-200 rounded-lg text-white">Cari</button>
                        </div>
                        <div
                            class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5 rounded-lg"
                        >
                            <table
                                class="table-auto w-full divide-y divide-gray-300"
                            >
                                <thead
                                    class="bg-gray-50 hidden lg:table-header-group"
                                >
                                    <tr>
                                        <th
                                            scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                        >
                                            Nama
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Wali Kelas
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Tempat Tanggal Lahir
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Alamat
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Jenis Kelamin
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Nomor Telepon
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
                                        v-for="(person, itemIdx) in guruData.data"
                                        :key="person.nip_guru"
                                        class="animate-fade-in-down"
                                        :style="{
                                            animationDelay: `${itemIdx * 0.1}s`,
                                        }"
                                    >
                                        <td
                                            class="py-4 pl-4 pr-3 text-sm sm:pl-6"
                                        >
                                            <div class="flex items-center">
                                                <div
                                                    v-if="!person.foto_guru_url"
                                                    class="h-10 w-10 flex justify-center items-center"
                                                >
                                                    <AccountCircleIcon />
                                                </div>

                                                <div
                                                    v-else
                                                    class="h-10 w-10 flex-shrink-0"
                                                >
                                                    <img
                                                        class="h-10 w-10 rounded-full"
                                                        :src="person.foto_guru_url"
                                                        alt=""
                                                    />
                                                </div>
                                                <div class="ml-4">
                                                    <div
                                                        class="font-medium text-gray-900"
                                                    >
                                                        {{ person.nama_guru }}<span class=" text-blue-900">({{ person.nip_guru }})</span>
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{ person.email_guru }}
                                                    </div>
                                                    <div
                                                        class="text-xs text-green-500 lg:hidden"
                                                    >
                                                        {{
                                                            person.tingkat_kelas
                                                        }}
                                                        {{
                                                            person.jurusan_kelas
                                                        }}
                                                        {{ person.nomor_kelas }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid mt-2 lg:hidden">
                                                <div class="grid">
                                                    <span class="text-xs">
                                                        Alamat:</span
                                                    >
                                                    <span class="text-blue-900">
                                                        {{
                                                            person.alamat_guru
                                                        }}</span
                                                    >
                                                    <span class="text-xs">
                                                        Tempat Tanggal
                                                        Lahir:</span
                                                    >
                                                    <span class="text-blue-900">
                                                        {{
                                                            person.tempat_lahir_guru
                                                        }},
                                                        {{
                                                            new Date(
                                                                person.tanggal_lahir_guru
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
                                                    <span class="text-xs">
                                                        Nomor Telepon:</span
                                                    >
                                                    <span class="text-blue-900">
                                                        {{
                                                            person.no_telp_guru
                                                        }}</span
                                                    >
                                                </div>
                                                <div
                                                    class="flex mt-2 items-center space-x-2"
                                                >
                                                    <router-link
                                                        :to="{
                                                            name: 'EditGuru',
                                                            params: {
                                                                id: person.nip_guru,
                                                            },
                                                        }"
                                                        class="bg-red-600 duration-200 hover:bg-red-900 text-white w-full rounded-lg px-4 py-2"
                                                    >
                                                        Ubah Data
                                                    </router-link>
                                                    <button type="button" @click.prevent="deleteModal(person.nip_guru)">
                                                        <DeleteCircleIcon
                                                            :size=35
                                                            class="text-red-600 hover:text-red-900 duration-200"
                                                        />
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-3 py-4 text-sm text-gray-500 hidden lg:table-cell"
                                        >
                                            <div class="text-gray-900 text-xs">
                                                {{ person.tingkat_kelas }}
                                                {{ person.jurusan_kelas }}
                                                {{ person.nomor_kelas }}
                                            </div>
                                        </td>
                                        <td
                                            class="px-3 text-xs py-4 hidden lg:table-cell"
                                        >
                                            {{ person.tempat_lahir_guru }},
                                            {{
                                                new Date(
                                                    person.tanggal_lahir_guru
                                                ).toLocaleDateString("id-ID", {
                                                    day: "numeric",
                                                    month: "long",
                                                    year: "numeric",
                                                })
                                            }}
                                        </td>
                                        <td
                                            class="px-3 text-xs py-4 text-gray-500 hidden lg:table-cell"
                                        >
                                            {{ person.alamat_guru }}
                                        </td>
                                        <td
                                            class="px-3 py-4 text-sm text-gray-500 hidden lg:table-cell"
                                        >
                                            {{ person.jenis_kelamin_guru }}
                                        </td>
                                        <td
                                            class="px-3 py-4 text-sm text-gray-500 hidden lg:table-cell"
                                        >
                                            {{ person.no_telp_guru }}
                                        </td>
                                        <td
                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 hidden lg:table-cell"
                                        >
                                            <div
                                                class="flex items-center space-x-2"
                                            >
                                                <router-link
                                                    :to="{
                                                        name: 'EditGuru',
                                                        params: {
                                                            id: person.nip_guru,
                                                        },
                                                    }"
                                                    class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-sm text-xs duration-200 hover:bg-red-900"
                                                    >Ubah Data</router-link
                                                >
                                                <button
                                                @click.prevent="deleteModal(person.nip_guru)"
                                                 type="button">
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
                        <div class="flex justify-center mt-5">
                            <nav
                            class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination"
                            >
                            <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
                            <a
                                v-for="(link, i) of guruData.links"
                                :key="i"
                                :disabled="!link.url"
                                href="#"
                                @click="getForPage($event, link)"
                                aria-current="page"
                                class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                                :class="[
                                    link.active
                                        ? 'z-10 bg-indigo-50 border-red-500 text-red-600'
                                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                    i === 0 ? 'rounded-l-md bg-gray-100 text-gray-700' : '',
                                    i === guruData.links.length - 1 ? 'rounded-r-md' : '',
                                ]"
                                v-html="link.label"
                            >
                            </a>
                            </nav>
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
                        @click="deleteGuru(nip_guru)"
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
import ConfirmView from "../components/ConfirmView.vue";
import LoadingView from "../components/LoadingView.vue";
import AccountCircleIcon from "vue-material-design-icons/AccountCircle.vue";
import DeleteCircleIcon from "vue-material-design-icons/DeleteCircleOutline.vue";
import { computed, ref } from "vue";
import {TrashIcon} from '@heroicons/vue/24/outline';
import store from "../store/index.js";

const alertMessage = ref("");
const updateConfirm = ref(false);
const confirmation = ref(false);
function toggleConfirmation() {
    confirmation.value = !confirmation.value;
}
let search = ref("");


let nip_guru = ref('')
const loading = computed(() => store.state.guru.loading);
function deleteModal(value){
    confirmation.value = true
    nip_guru.value = value
}
function deleteGuru(value){
    store.dispatch("deleteGuru",value).then(
        store.dispatch("getGuru"));
        store.commit("notify", {
            type: "success",
            message: "Data berhasil dihapus!"
        });
        confirmation.value = false
}
function getForPage(ev, link) {
    ev.preventDefault();
    if (!link.url || link.active) {
        return;
    }
    store.dispatch("getGuru", { url: link.url });
}
function cariGuru(){
    store.dispatch("searchFilterGuru", search.value);

}
store.dispatch("getGuru");
const guruData = computed(() =>
    store.state.guru
);
</script>
<style></style>
