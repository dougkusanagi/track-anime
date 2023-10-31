<script setup>
import { computed, watch, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

import AppHeader from "@/Components/AppHeader.vue";
import AnimeDetailsDrawer from "@/Components/AnimeDetailsDrawer.vue";

import { useSelectedAnimeStore } from "@/Stores/useSelectedAnimeStore";

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
    <AnimeDetailsDrawer />

    <div
        class="inset-0 min-h-screen overflow-hidden bg-[url('/bg.png')] bg-cover bg-fixed pb-16"
    >
        <!-- black overlay on top at 30% opacity at filter multiply -->

        <div class="z-10 pt-[74px]">
            <slot />
        </div>
        <AppHeader />
    </div>
</template>
