<script setup>
import AppInputBasic from "./AppInputBasic.vue";

import StarOutline from "@/Icons/HeroIcons/StarOutline.vue";
import StarSolid from "@/Icons/HeroIcons/StarSolid.vue";
import HeartOutline from "@/Icons/HeroIcons/HeartOutline.vue";
import HeartSolid from "@/Icons/HeroIcons/HeartSolid.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { watch } from "vue";
import { reactive } from "vue";
import AppSelectBasic from "./AppSelectBasic.vue";

const props = defineProps({
    anime: Object,
});

const form = reactive({
    id: props.anime.id,
    status: props.anime.status,
    rewatch_count: props.anime.rewatch_count,
    score: props.anime.score,
});

function save() {
    router.put(route("saved-anime.update"), form, {
        preserveScroll: true,
    });
}

watch(props, () => {
    for (const key in form) {
        form[key] = props.anime[key];
    }
});
</script>

<template>
    <div
        id="drawer-saved-anime-details"
        class="fixed left-0 top-0 z-40 h-screen w-11/12 -translate-x-full overflow-y-auto bg-black/10 p-4 backdrop-blur-2xl transition-transform sm:w-[540px]"
        tabindex="-1"
        aria-labelledby="drawer-label"
    >
        <!-- <pre>{{ form }}</pre> -->

        <div v-if="anime">
            <div class="mb-10 flex">
                <!-- button save -->
                <button
                    @click.prevent="save"
                    class="flex items-center gap-2 rounded bg-indigo-800 stroke-white px-3 py-1 font-bold text-white/80 shadow-lg shadow-indigo-700/40 transition-all hover:text-white hover:brightness-125 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <svg
                        width="20"
                        height="20"
                        viewBox="0 0 20 20"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        stroke-width="1.5"
                        class="h-4 w-4"
                    >
                        <path
                            d="M5 1V4.4C5 4.96005 5 5.24008 5.10899 5.45399C5.20487 5.64215 5.35785 5.79513 5.54601 5.89101C5.75992 6 6.03995 6 6.6 6H13.4C13.9601 6 14.2401 6 14.454 5.89101C14.6422 5.79513 14.7951 5.64215 14.891 5.45399C15 5.24008 15 4.96005 15 4.4V2M15 19V12.6C15 12.0399 15 11.7599 14.891 11.546C14.7951 11.3578 14.6422 11.2049 14.454 11.109C14.2401 11 13.9601 11 13.4 11H6.6C6.03995 11 5.75992 11 5.54601 11.109C5.35785 11.2049 5.20487 11.3578 5.10899 11.546C5 11.7599 5 12.0399 5 12.6V19M19 7.32548V14.2C19 15.8802 19 16.7202 18.673 17.362C18.3854 17.9265 17.9265 18.3854 17.362 18.673C16.7202 19 15.8802 19 14.2 19H5.8C4.11984 19 3.27976 19 2.63803 18.673C2.07354 18.3854 1.6146 17.9265 1.32698 17.362C1 16.7202 1 15.8802 1 14.2V5.8C1 4.11984 1 3.27976 1.32698 2.63803C1.6146 2.07354 2.07354 1.6146 2.63803 1.32698C3.27976 1 4.11984 1 5.8 1H12.6745C13.1637 1 13.4083 1 13.6385 1.05526C13.8425 1.10425 14.0376 1.18506 14.2166 1.29472C14.4184 1.4184 14.5914 1.59135 14.9373 1.93726L18.0627 5.06274C18.4086 5.40865 18.5816 5.5816 18.7053 5.78343C18.8149 5.96237 18.8957 6.15746 18.9447 6.36154C19 6.59171 19 6.8363 19 7.32548Z"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                    Salvar
                </button>

                <button
                    type="button"
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
                        <div class="mx-4 mt-2 flex gap-2">
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
                                Status
                            </label>

                            <AppSelectBasic id="list" v-model="form.status">
                                <option
                                    v-for="(option, index) in usePage().props
                                        .saved_anime_status_list"
                                    :value="option"
                                    class="text-black"
                                >
                                    {{ index }}
                                </option>
                            </AppSelectBasic>
                        </div>

                        <div class="mt-6 flex flex-col gap-1 pl-4">
                            <label for="rewatched" class="text-white/50">
                                Vezes Reassistidas
                            </label>

                            <AppInputBasic
                                id="rewatched"
                                v-model="form.rewatch_count"
                                type="number"
                                min="0"
                                step="1"
                            />
                        </div>

                        <div class="mt-6 flex flex-col gap-1 pl-4">
                            <label for="rating" class="text-white/50">
                                Dê sua nota
                            </label>

                            <AppInputBasic
                                id="rating"
                                v-model="form.score"
                                type="number"
                                min="0"
                                step="1"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <h4
                    id="drawer-label"
                    class="inline-flex items-center text-3xl font-semibold text-white"
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
