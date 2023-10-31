<script setup>
import AppInputBasic from "./AppInputBasic.vue";

import StarOutline from "@/Icons/HeroIcons/StarOutline.vue";
import StarSolid from "@/Icons/HeroIcons/StarSolid.vue";
import HeartOutline from "@/Icons/HeroIcons/HeartOutline.vue";
import HeartSolid from "@/Icons/HeroIcons/HeartSolid.vue";

const props = defineProps({
    anime: {
        type: Object,
        default: {},
    },
});
</script>

<template>
    <!-- <pre>{{ anime }}</pre> -->

    <div
        id="drawer-saved-anime-details"
        class="fixed left-0 top-0 z-40 h-screen w-11/12 -translate-x-full overflow-y-auto bg-white/5 p-4 backdrop-blur-2xl transition-transform sm:w-[540px]"
        tabindex="-1"
        aria-labelledby="drawer-label"
    >
        <div v-if="anime">
            <div class="mb-10">
                <button
                    type="button"
                    data-drawer-hide="drawer-saved-anime-details"
                    aria-controls="drawer-saved-anime-details"
                    class="absolute right-2.5 top-2.5 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-white hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                >
                    <svg
                        class="h-3 w-3"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 14 14"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                        />
                    </svg>
                    <span class="sr-only">Close menu</span>
                </button>
            </div>

            <!-- <pre>{{ anime.details }}</pre> -->

            <div class="flex">
                <img :src="anime.details.images.webp.image_url" alt="" />

                <div class="flex flex-1 flex-col justify-between">
                    <div
                        class="grid w-full grid-cols-3 items-center divide-x-2 divide-white/20"
                    >
                        <span
                            class="flex justify-center text-lg font-black text-white"
                        >
                            {{ anime.details.year }}
                        </span>

                        <div class="flex items-center justify-center gap-1">
                            <StarOutline class="hidden" />

                            <StarSolid class="fill-yellow-400" />

                            <span class="text-lg font-black text-white">
                                {{ anime.details.score }}
                            </span>
                        </div>

                        <div class="flex justify-center">
                            <HeartSolid class="hidden" />

                            <HeartOutline class="text-red-600" />
                        </div>
                    </div>

                    <div>
                        <div class="mx-4 flex gap-2">
                            <span
                                class="rounded-lg border border-emerald-600/80 bg-emerald-600/50 px-2 py-1 text-xs font-bold"
                                v-if="anime.details.airing"
                            >
                                Em Exibição
                            </span>

                            <span
                                class="rounded-lg border border-teal-600/80 bg-teal-600/50 px-2 py-1 text-xs font-bold"
                                v-else
                            >
                                Finalizado
                            </span>
                        </div>

                        <div class="mt-6 flex flex-col gap-1 pl-4">
                            <label for="list" class="text-white/50">
                                Lista
                            </label>

                            <select
                                id="list"
                                class="rounded-lg border-white/10 bg-white/10 p-2 text-sm text-white placeholder-white/30 focus:border-white/40 focus:ring-white/40"
                            >
                                <option value="">Assistindo</option>
                            </select>
                        </div>

                        <div class="mt-6 flex flex-col gap-1 pl-4">
                            <label for="rewatched" class="text-white/50">
                                Vezes Reassistidas
                            </label>

                            <AppInputBasic
                                id="rewatched"
                                v-model="anime.rewatch_count"
                                type="number"
                                min="0"
                            />
                        </div>

                        <div class="mt-6 flex flex-col gap-1 pl-4">
                            <label for="rating" class="text-white/50">
                                Dê sua nota
                            </label>

                            <AppInputBasic
                                id="rating"
                                type="number"
                                min="0"
                                max="10"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <h4
                    id="drawer-label"
                    class="inline-flex items-center text-4xl font-semibold text-white"
                >
                    {{ anime.details.title }}
                </h4>

                <div class="mt-6 flex flex-col">
                    <span class="text-sm text-white/40"> Gêneros: </span>

                    <div class="mt-2">
                        <span
                            class="mr-2 rounded-lg border border-white/10 bg-white/5 px-2 py-1 text-xs text-white/80"
                            v-for="genre in anime.details.genres"
                        >
                            {{ genre.name }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 flex flex-col">
                    <span class="text-sm text-white/40">Temporada:</span>

                    <div class="mt-2">
                        <span class="mr-2 text-white/80">
                            {{ anime.details.season }}
                        </span>
                    </div>
                </div>

                <p class="mt-6 text-lg text-white">
                    {{ anime.details.synopsis }}
                </p>
            </div>
        </div>
    </div>
</template>
