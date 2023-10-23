<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";

import AppSimpleSearchBar from "@/Components/AppSimpleSearchBar.vue";
import AnimeCard from "@/Components/AnimeCard.vue";
import useUrl from "@/Composables/useUrl";

const props = defineProps({
    animes: Object,
});

const params = useUrl().params;
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
                >
                    Home
                </h2>

                <AppSimpleSearchBar />
            </div>
        </template>

        <div class="pt-12 pb-48">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg">
                <h3
                    class="px-6 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
                >
                    Você pesquisou:

                    <span class="font-normal"> "{{ params.q }}" </span>
                </h3>
            </div>

            <div
                class="grid grid-cols-2 gap-4 px-6 mx-auto mt-6 mb-12 sm:grid-cols-6 max-w-7xl sm:px-6 md:px-8 sm:rounded-lg"
            >
                <AnimeCard
                    v-for="anime in animes.data"
                    :key="anime.id"
                    :anime="anime"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
