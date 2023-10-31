<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

import useDebounce from "@/Composables/useDebounce";
import useUrl from "@/Composables/useUrl";
import { useSelectedAnime } from "@/Stores/useSelectedAnime.js";

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

const new_link = ref("");
const selected_anime_store = useSelectedAnime();
let drawer_anime_details = null;

const openAnimeDetails = async (clicked_anime) => {
    const anime_details = await axios.get(
        route("anime-details", clicked_anime.mal_id)
    );

    clicked_anime.detail = anime_details.data;
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
        alert("URL inválida");
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
    <div class="flex flex-col rounded-xl">
        <p
            class="z-10 w-full p-1 text-xs font-black text-center text-white card-title line-clamp-3"
        >
            {{ anime.title }}
        </p>

        <button
            class="outline outline-2 outline-transparent focus:shadow-xl focus:shadow-indigo-600 focus:outline-2 focus:outline-indigo-600"
            @click="openAnimeDetails(anime)"
        >
            <img
                class="object-cover min-w-96"
                :src="anime.image_cover_url"
                alt=""
            />
        </button>

        <div class="flex items-center w-full">
            <ButtonChangeEp
                class="flex h-8 w-8 items-center justify-center rounded-bl-lg bg-[#1D0D80]"
                @click="decreaseSavedAnimeEpisode(anime)"
            >
                <Minus />
            </ButtonChangeEp>

            <input
                class="h-8 w-16 flex-1 border-none bg-[#140A4F] text-center text-sm font-medium focus:ring-white/20"
                type="text"
                placeholder="ex: 8"
                :value="anime.episode_count"
                @input="updateSavedAnimeEpisode(anime, $event.target.value)"
            />

            <ButtonChangeEp @click="increaseSavedAnimeEpisode(anime)">
                <Plus />
            </ButtonChangeEp>

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
                class="z-20 hidden w-64 max-w-full p-3 border divide-y rounded-lg shadow divide-gray-300/20 border-white/20 bg-black/50 backdrop-blur-xl"
                aria-labelledby="dropdownNotificationButton"
            >
                <div
                    class="flex flex-col items-center justify-between gap-1 mb-2"
                >
                    <div class="flex w-full gap-1" v-for="link in anime.links">
                        <a
                            :href="link"
                            target="_blank"
                            class="w-full p-2 text-sm font-black text-gray-100 rounded-lg md hover:bg-black/30 hover:text-indigo-600"
                        >
                            <div class="flex items-center gap-2">
                                <ArrowTopRightSquare class="w-4 h-4" />
                                link
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
