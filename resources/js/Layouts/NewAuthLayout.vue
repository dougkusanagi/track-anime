<script setup>
import { computed, watch, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toastification";

import AppHeader from "@/Components/AppHeader.vue";
import AnimeDetailsDrawer from "@/Components/AnimeDetailsDrawer.vue";

import { useSelectedAnime } from "@/Stores/useSelectedAnime";

const flash = computed(() => usePage().props.flash);
const toast = useToast();

const selected_anime_store = useSelectedAnime();

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
    <AnimeDetailsDrawer :anime="selected_anime_store.selected_anime" />

    <div class="inset-0 min-h-screen bg-[url('/bg.png')] bg-fixed pb-16">
        <AppHeader />

        <div class="z-10 pt-[74px]">
            <slot />
        </div>
    </div>
</template>
