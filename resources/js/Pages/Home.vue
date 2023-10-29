<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import axios from "axios";
import { Drawer } from "flowbite";

import NewAuthLayout from "@/Layouts/NewAuthLayout.vue";

import AnimeSavedFilterSelect from "@/Components/AnimeSavedFilterSelect.vue";
import AppInputBasic from "@/Components/AppInputBasic.vue";
import HomeFilterSelect from "@/Components/HomeFilterSelect.vue";
import AnimeDetailsDrawer from "@/Components/AnimeDetailsDrawer.vue";

import Ellipsis from "@/Icons/HeroIcons/Ellipsis.vue";
import PlusCircle from "@/Icons/HeroIcons/PlusCircle.vue";
import ArrowTopRightSquare from "@/Icons/HeroIcons/ArrowTopRightSquare.vue";
import TrashBasic from "@/Icons/HeroIcons/TrashBasic.vue";

const props = defineProps({
    animes: Object,
    saved_animes: {
        type: Array,
        default: [],
    },
});

const drawer_anime_details_ref = ref(null);

const anime_with_detail = ref(null);

let drawer_anime_details = null;

const openAnimeDetails = async (clicked_anime) => {
    const anime_details = await axios.get(
        route("anime-details", clicked_anime.mal_id)
    );

    clicked_anime.detail = anime_details.data;
    anime_with_detail.value = clicked_anime;

    if (!drawer_anime_details) {
        drawer_anime_details = new Drawer(drawer_anime_details_ref);
    }
};
</script>

<template>
    <Head title="Home" />

    <NewAuthLayout>
        <AnimeDetailsDrawer
            ref="drawer_anime_details"
            :anime="anime_with_detail"
        />

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
                <div class="flex items-end gap-4 overflow-x-auto py-2">
                    <div
                        class="flex w-40 flex-col rounded-xl"
                        v-for="anime in saved_animes"
                    >
                        <p
                            class="card-title z-10 line-clamp-3 w-full p-1 text-center text-xs font-black text-white"
                        >
                            {{ anime.title }}
                        </p>

                        <button
                            class="outline outline-2 outline-transparent focus:shadow-xl focus:shadow-indigo-600 focus:outline-2 focus:outline-indigo-600"
                            data-drawer-target="drawer-saved-anime-details"
                            data-drawer-show="drawer-saved-anime-details"
                            aria-controls="drawer-saved-anime-details"
                            @click="openAnimeDetails(anime)"
                        >
                            <img
                                class="h-60 w-full object-cover"
                                :src="anime.image_cover_url"
                                alt=""
                            />
                        </button>

                        <div class="flex w-full items-center">
                            <button
                                class="flex h-8 w-8 items-center justify-center rounded-bl-lg bg-[#1D0D80]"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-6 w-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M18 12H6"
                                    />
                                </svg>
                            </button>

                            <input
                                class="h-8 w-16 flex-1 border-none bg-[#140A4F] text-center text-sm font-medium focus:ring-white/20"
                                placeholder="ex: 8"
                                type="text"
                                v-model="anime.episode_count"
                            />

                            <button
                                class="flex h-8 w-8 items-center justify-center bg-[#1D0D80]"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-6 w-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 6v12m6-6H6"
                                    />
                                </svg>
                            </button>

                            <button
                                id="dropdownNotificationButton"
                                data-dropdown-toggle="dropdownSavedAnimeCard-{{ anime.id }}"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-br-lg bg-[#4712DD] text-center text-sm font-medium text-white hover:text-gray-900 focus:outline-none"
                                type="button"
                            >
                                <Ellipsis />
                            </button>

                            <!-- Dropdown menu -->
                            <div
                                id="dropdownSavedAnimeCard-{{ anime.id }}"
                                class="z-20 hidden w-64 max-w-full divide-y divide-gray-300/20 rounded-lg border border-white/20 bg-black/50 p-3 shadow backdrop-blur-xl"
                                aria-labelledby="dropdownNotificationButton"
                            >
                                <div
                                    class="mb-2 flex flex-col items-center justify-between gap-1"
                                >
                                    <a
                                        v-for="link in anime.links"
                                        :href="link"
                                        target="_blank"
                                        class="md w-full rounded-lg p-2 text-sm font-black text-gray-100 hover:bg-black/30 hover:text-indigo-600"
                                    >
                                        <div class="flex items-center gap-2">
                                            <ArrowTopRightSquare
                                                class="h-4 w-4"
                                            />
                                            link
                                        </div>
                                    </a>
                                </div>

                                <div
                                    class="700 flex items-center justify-between gap-1 py-2"
                                >
                                    <AppInputBasic
                                        placeholder="Cole seu link"
                                    />

                                    <button
                                        type="button"
                                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-indigo-700 text-center text-sm font-black text-indigo-700 hover:bg-indigo-600 hover:text-white hover:shadow-lg hover:shadow-indigo-700/80"
                                    >
                                        <PlusCircle class="h-4 w-4" />
                                    </button>
                                </div>
                                <div
                                    class="700 flex items-center justify-between gap-1 pt-2"
                                >
                                    <button
                                        type="button"
                                        class="hover:red-600 flex flex-1 items-center gap-2 rounded-lg border border-red-600 p-2 text-sm font-black text-red-600 hover:bg-red-600 hover:text-white hover:shadow-lg hover:shadow-red-600/50 focus:outline-none focus:ring-red-600"
                                    >
                                        <TrashBasic class="h-4 w-4" />
                                        <span>Remover anime</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <p>{{ animes }}</p> -->
    </NewAuthLayout>
</template>
