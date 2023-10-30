<script setup>
import { Head } from "@inertiajs/vue3";

import NewAuthLayout from "@/Layouts/NewAuthLayout.vue";

import AnimeSavedFilterSelect from "@/Components/AnimeSavedFilterSelect.vue";
import HomeFilterSelect from "@/Components/HomeFilterSelect.vue";
import SavedAnimeCard from "@/Components/SavedAnimeCard.vue";

const props = defineProps({
    animes: Object,
    saved_animes: {
        type: Array,
        default: [],
    },
});
</script>

<template>
    <Head title="Home" />

    <NewAuthLayout>
        <!-- <pre>{{ saved_animes }}</pre> -->

        <div class="ml-6 mt-16 sm:ml-12">
            <h2
                class="border-b-2 border-white/40 pb-2 text-lg font-black text-white/80"
            >
                Minha Lista
            </h2>

            <div class="mt-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:gap-4">
                    <HomeFilterSelect>
                        <label
                            for="orderBy"
                            class="block w-24 min-w-fit text-sm font-medium text-white/50"
                        >
                            Pesquisar:
                        </label>

                        <input
                            id="q"
                            type="text"
                            class="block flex-1 appearance-none rounded border-none bg-transparent p-2 py-1 text-sm font-bold text-white outline-none focus:ring-transparent disabled:text-white/30 disabled:placeholder:font-bold disabled:placeholder:text-white/30 sm:w-44"
                            placeholder="Nome do Anime..."
                            disabled
                        />
                    </HomeFilterSelect>

                    <HomeFilterSelect>
                        <label
                            for="orderBy"
                            class="block w-24 min-w-fit text-sm font-medium text-white/50"
                        >
                            Ordenar por:
                        </label>

                        <AnimeSavedFilterSelect
                            id="orderBy"
                            :options="[{ label: 'Alfabético', value: '' }]"
                            disabled
                        />
                    </HomeFilterSelect>

                    <HomeFilterSelect>
                        <label
                            for="gender"
                            class="block w-24 min-w-fit text-sm font-medium text-white/50"
                        >
                            Gêneros:
                        </label>

                        <AnimeSavedFilterSelect
                            id="gender"
                            :options="[{ label: 'Todos', value: '' }]"
                            disabled
                        />
                    </HomeFilterSelect>
                </div>
            </div>

            <div class="mt-6 max-w-full">
                <div class="flex gap-4 overflow-x-auto py-2">
                    <SavedAnimeCard
                        v-for="anime in saved_animes"
                        :anime="anime"
                        :key="anime.id"
                    />
                </div>
            </div>
        </div>

        <!-- <p>{{ animes }}</p> -->
    </NewAuthLayout>
</template>
