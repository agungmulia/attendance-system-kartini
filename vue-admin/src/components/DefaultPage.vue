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
                    <span>Hello, Administrator</span>
                </div>
            </div>
        </div>
        <main class="flex-1">
            <div>
                <div
                    class="py-6 text-blue-900 bg-white px-10 lg:px-8 shadow-md hidden md:flex justify-between"
                >
                    <span class="font-bold text-xl">
                        Hello, Administrator
                    </span>
                </div>
                <div class="max-w-7 pt-4 px-10 lg:px-8">
                    <div>
                        <!-- Replace with your content -->
                        <div>
                            <slot></slot>
                        </div>
                        <!-- /End replace -->
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup>
import { sharedConstant } from "../utils";
import store from "../store/index.js";
import {
    Dialog,
    DialogOverlay,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";

import { Bars3Icon } from "@heroicons/vue/24/outline";

import { ref, computed, watch } from "vue";

import AccountCircleIcon from "vue-material-design-icons/AccountCircle.vue";

const sidebarOpen = sharedConstant;

const dataUser = {
    nama_guru: "Agung Mulia Eko Putra",
    jenis_kelamin_guru: "Laki-laki",
};

const props = defineProps({
    pageHeading: String,
});

const userData = computed(() => store.state.user.data);
store.dispatch("getUser");
function userSigned() {
    if (dataUser.jenis_kelamin_guru == "Laki-laki") {
        return "Mr " + dataUser.nama_guru;
    } else {
        return "Mrs " + dataUser.nama_guru;
    }
}
</script>
<style></style>
