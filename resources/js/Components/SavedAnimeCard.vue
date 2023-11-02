<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

import useDebounce from "@/Composables/useDebounce";
import useUrl from "@/Composables/useUrl";
import { useSelectedAnimeStore } from "@/Stores/useSelectedAnimeStore.js";
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
const selected_anime_store = useSelectedAnimeStore();
let drawer_anime_details = null;

const openAnimeDetails = async (clicked_anime) => {
    selected_anime_store.selected_anime = clicked_anime;

    if (!drawer_anime_details) {
        drawer_anime_details = new Drawer(
            document.getElementById("drawer-saved-anime-details")
        );
    }

    drawer_anime_details.show();
};

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
    console.log(new_link.value);
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
    <div class="flex w-44 flex-col justify-end rounded-xl" :title="anime.title">
        <p
            class="z-10 line-clamp-3 w-full p-1 text-center text-xs font-black text-white"
        >
            {{ anime.title }}
        </p>

        <button
            class="outline outline-2 outline-transparent focus:shadow-xl focus:shadow-indigo-600 focus:outline-2 focus:outline-indigo-600"
            @click="openAnimeDetails(anime)"
        >
            <img
                class="min-w-96 object-cover"
                :src="anime.image_cover_url"
                :alt="`Capa do anime ${anime.title}`"
            />
        </button>

        <div class="flex w-full items-center">
            <ButtonChangeEp
                class="flex h-8 w-8 items-center justify-center rounded-bl-lg bg-[#1D0D80]"
                @click="decreaseSavedAnimeEpisode(anime)"
                as="button"
                v-once
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
                v-once
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
                class="z-20 hidden w-64 max-w-full divide-y divide-gray-300/20 rounded-lg border border-white/20 bg-black/50 p-3 shadow backdrop-blur-xl"
                aria-labelledby="dropdownNotificationButton"
            >
                <div
                    class="mb-2 flex flex-col items-center justify-between gap-1"
                    v-if="anime.links"
                >
                    <div class="flex w-full gap-1" v-for="link in anime.links">
                        <a
                            :href="link"
                            target="_blank"
                            class="md w-full rounded-lg p-2 text-sm font-black text-gray-100 hover:bg-black/30 hover:text-indigo-600"
                        >
                            <div class="flex items-center gap-2">
                                <ArrowTopRightSquare class="h-4 w-4" />

                                {{ useUrl().domain(link) }}
                            </div>
                        </a>

                        <button
                            type="button"
                            @click="removeLink(anime.id, link)"
                            class="hover:red-600 flex flex-1 items-center gap-2 rounded-lg border border-red-600 p-2 text-sm font-black text-red-600 hover:bg-red-600 hover:text-white hover:shadow-lg hover:shadow-red-600/50 focus:outline-none focus:ring-red-600"
                        >
                            <TrashBasic class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <form @submit.prevent="addLink">
                    <div
                        class="700 flex items-center justify-between gap-1 py-2"
                    >
                        <input
                            v-model="new_link"
                            type="text"
                            placeholder="Cole seu link..."
                            class="block flex-1 rounded-lg border border-white/10 bg-transparent bg-gradient-to-b from-white/10 to-black/10 p-2 text-sm text-white placeholder-white/30 focus:border-white/40 focus:ring-white/40"
                        />

                        <button
                            type="submit"
                            class="flex h-10 w-10 items-center justify-center rounded-lg border border-indigo-700 text-center text-sm font-black text-indigo-700 hover:bg-indigo-600 hover:text-white hover:shadow-lg hover:shadow-indigo-700/80"
                        >
                            <PlusCircle class="h-4 w-4" />
                        </button>
                    </div>
                </form>

                <div class="700 flex items-center justify-between gap-1 pt-2">
                    <button
                        type="button"
                        @click.prevent="removeAnime"
                        class="hover:red-600 flex flex-1 items-center gap-2 rounded-lg border border-red-600 p-2 text-sm font-black text-red-600 hover:bg-red-600 hover:text-white hover:shadow-lg hover:shadow-red-600/50 focus:outline-none focus:ring-red-600"
                    >
                        <TrashBasic class="h-4 w-4" />

                        <span>Remover anime</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
