<script setup>
import { Head } from "@inertiajs/vue3";

import NewAuthLayout from "@/Layouts/NewAuthLayout.vue";
import { Link } from "@inertiajs/vue3";

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

        <div class="mt-16 ml-6 sm:ml-12">
            <h2
                class="pb-2 text-lg font-black border-b-2 border-white/40 text-white/80"
            >
                Minha Lista
            </h2>

            <div v-if="$page.props.user">
                <div class="mt-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:gap-4">
                        <HomeFilterSelect>
                            <label
                                for="orderBy"
                                class="block w-24 text-sm font-medium min-w-fit text-white/50"
                            >
                                Pesquisar:
                            </label>

                            <input
                                id="q"
                                type="text"
                                class="flex-1 block p-2 py-1 text-sm font-bold text-white bg-transparent border-none rounded outline-none appearance-none focus:ring-transparent disabled:text-white/30 disabled:placeholder:font-bold disabled:placeholder:text-white/30 sm:w-44"
                                placeholder="Nome do Anime..."
                                disabled
                            />
                        </HomeFilterSelect>

                        <HomeFilterSelect>
                            <label
                                for="orderBy"
                                class="block w-24 text-sm font-medium min-w-fit text-white/50"
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
                                class="block w-24 text-sm font-medium min-w-fit text-white/50"
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

                <div class="max-w-full mt-6">
                    <div class="flex gap-4 py-2 overflow-x-auto">
                        <SavedAnimeCard
                            v-for="anime in saved_animes"
                            :anime="anime"
                            :key="anime.id"
                        />
                    </div>
                </div>
            </div>

            <div v-else>
                <div class="mt-6">
                    <Link> Logue ou cadastre-se para ver seus animes </Link>
                </div>
            </div>
        </div>

        <!-- <p>{{ animes }}</p> -->
    </NewAuthLayout>
</template>
