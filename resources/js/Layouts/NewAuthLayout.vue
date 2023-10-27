<script setup>
import { computed, watch, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

import AppHeader from "@/Components/AppHeader.vue";
import AnimeDetailsDrawer from "@/Components/AnimeDetailsDrawer.vue";

const flash = computed(() => usePage().props.flash);
const toast = useToast();

function triggerFlash() {
    const types = Object.keys(flash.value);

    types.forEach((type) => {
        if (flash.value[type] !== null) {
            toast(flash.value[type], { type });
            flash.value[type] = null;
        }
    });
}

onMounted(triggerFlash);
watch(flash, triggerFlash);
</script>

<template>
    <div class="min-h-screen bg-fixed inset-0 bg-[url('/bg.png')]">
        <!-- <div
            class="absolute bg-fixed inset-0 bg-[url('/bg.png')] bg-top -z-10"
        ></div> -->

        <AppHeader />

        <div class="pt-[74px] z-10">
            <slot />
        </div>
    </div>

    <!-- <AnimeDetailsDrawer /> -->
</template>
