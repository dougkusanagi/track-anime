<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

import useDebounce from "@/Composables/useDebounce";
import useUrl from "@/Composables/useUrl";
import { useToast } from "vue-toastification";

import ButtonChangeEp from "@/Components/ButtonChangeEp.vue";

import ArrowTopRightSquare from "@/Icons/HeroIcons/ArrowTopRightSquare.vue";
import Ellipsis from "@/Icons/HeroIcons/Ellipsis.vue";
import PlusCircle from "@/Icons/HeroIcons/PlusCircle.vue";
import TrashBasic from "@/Icons/HeroIcons/TrashBasic.vue";
import Minus from "@/Icons/HeroIcons/Minus.vue";
import Plus from "@/Icons/HeroIcons/Plus.vue";

const props = defineProps({
    anime: Object,
});

const toast = useToast();
const new_link = ref("");

function updateSavedAnimeEpisode(anime, episode_count) {
    useDebounce(() => {
        router.put(
            route("saved-anime.save-episode"),
            { anime, episode_count },
            { preserveScroll: true }
        );
    }, 700);
}

function increaseSavedAnimeEpisode(anime) {
    anime.episode_count += 1;
    updateSavedAnimeEpisode(anime, anime.episode_count);
}

function decreaseSavedAnimeEpisode(anime) {
    anime.episode_count -= 1;
    updateSavedAnimeEpisode(anime, anime.episode_count);
}

function addLink() {
    if (!useUrl().isUrl(new_link.value)) {
        new_link.value = "";
        toast.error("URL inválida");
        return;
    }

    router.put(
        route("saved-anime.update-link"),
        {
            id: props.anime.id,
            new_link: new_link.value,
        },
        {
            preserveScroll: true,
        }
    );

    new_link.value = "";
}

function removeLink(anime, link) {
    router.put(
        route("saved-anime.delete-link", { anime }),
        { link },
        { preserveScroll: true }
    );
}

function removeAnime() {
    router.delete(route("saved-anime.destroy", props.anime.id), {
        preserveScroll: true,
    });
}
</script>

<template>
    <div class="flex flex-col justify-end w-44 rounded-xl" :title="anime.title">
        <p
            class="z-10 w-full p-1 text-xs font-black text-center text-white line-clamp-3"
        >
            {{ anime.title }}
        </p>

        <button
            class="outline outline-2 outline-transparent focus:shadow-xl focus:shadow-indigo-600 focus:outline-2 focus:outline-indigo-600"
            @click="$emit('changeSelectedAnime', anime)"
        >
            <img
                class="object-cover min-w-96"
                :src="anime.image_cover_url"
                :alt="`Capa do anime ${anime.title}`"
            />
        </button>

        <div class="flex items-center w-full">
            <ButtonChangeEp
                class="flex h-8 w-8 items-center justify-center rounded-bl-lg bg-[#1D0D80]"
                @click="decreaseSavedAnimeEpisode(anime)"
                as="button"
            >
                <Minus />
            </ButtonChangeEp>

            <input
                class="h-8 w-16 flex-1 border-none bg-[#140A4F] px-1 text-center text-sm font-medium focus:ring-white/20"
                type="text"
                placeholder="ex: 8"
                :value="anime.episode_count"
                @input="updateSavedAnimeEpisode(anime, $event.target.value)"
            />

            <ButtonChangeEp
                @click="increaseSavedAnimeEpisode(anime)"
                as="button"
            >
                <Plus />
            </ButtonChangeEp>

            <button
                id="dropdownNotificationButton"
                :data-dropdown-toggle="`dropdownSavedAnimeDropdown-${anime.id}`"
                class="inline-flex h-8 w-8 items-center justify-center rounded-br-lg bg-[#4712DD] text-center text-sm font-medium text-white hover:brightness-125 focus:outline-none"
                type="button"
            >
                <Ellipsis />
            </button>

            <!-- Dropdown menu -->
            <div
                :id="`dropdownSavedAnimeDropdown-${anime.id}`"
                class="z-20 hidden w-64 max-w-full p-3 border divide-y rounded-lg shadow divide-gray-300/20 border-white/20 bg-black/50 backdrop-blur-xl"
                aria-labelledby="dropdownNotificationButton"
            >
                <div
                    class="flex flex-col items-center justify-between gap-1 mb-2"
                    v-if="anime.links"
                >
                    <div class="flex w-full gap-1" v-for="link in anime.links">
                        <a
                            :href="link"
                            target="_blank"
                            class="w-full p-2 text-sm font-black text-gray-100 rounded-lg md hover:bg-black/30 hover:text-indigo-600"
                        >
                            <div class="flex items-center gap-2">
                                <ArrowTopRightSquare class="w-4 h-4" />

                                {{ useUrl().domain(link) }}
                            </div>
                        </a>

                        <button
                            type="button"
                            @click="removeLink(anime.id, link)"
                            class="flex items-center flex-1 gap-2 p-2 text-sm font-black text-red-600 border border-red-600 rounded-lg hover:red-600 hover:bg-red-600 hover:text-white hover:shadow-lg hover:shadow-red-600/50 focus:outline-none focus:ring-red-600"
                        >
                            <TrashBasic class="w-4 h-4" />
                        </button>
                    </div>
                </div>

                <form @submit.prevent="addLink">
                    <div
                        class="flex items-center justify-between gap-1 py-2 700"
                    >
                        <input
                            v-model="new_link"
                            type="text"
                            placeholder="Cole seu link..."
                            class="flex-1 block p-2 text-sm text-white bg-transparent border rounded-lg border-white/10 bg-gradient-to-b from-white/10 to-black/10 placeholder-white/30 focus:border-white/40 focus:ring-white/40"
                        />

                        <button
                            type="submit"
                            class="flex items-center justify-center w-10 h-10 text-sm font-black text-center text-indigo-700 border border-indigo-700 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-lg hover:shadow-indigo-700/80"
                        >
                            <PlusCircle class="w-4 h-4" />
                        </button>
                    </div>
                </form>

                <div class="flex items-center justify-between gap-1 pt-2 700">
                    <button
                        type="button"
                        @click.prevent="removeAnime"
                        class="flex items-center flex-1 gap-2 p-2 text-sm font-black text-red-600 border border-red-600 rounded-lg hover:red-600 hover:bg-red-600 hover:text-white hover:shadow-lg hover:shadow-red-600/50 focus:outline-none focus:ring-red-600"
                    >
                        <TrashBasic class="w-4 h-4" />

                        <span>Remover anime</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
