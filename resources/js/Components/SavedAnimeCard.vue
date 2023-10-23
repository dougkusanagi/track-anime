<script setup>
import { router, useForm } from "@inertiajs/vue3";
import useDebounce from "@/Composables/useDebounce.js";
import useUrl from "@/Composables/useUrl";

import Ellipsis from "@/Icons/HeroIcons/Ellipsis.vue";
import ArrowTopRightSquare from "@/Icons/HeroIcons/ArrowTopRightSquare.vue";
import TrashBasic from "@/Icons/HeroIcons/TrashBasic.vue";
import PlusCircle from "@/Icons/HeroIcons/PlusCircle.vue";

const props = defineProps({ anime: Object });
const links_form = useForm({
    id: props.anime.id,
    new_link: "",
});

function updateSavedAnimeEpisode(anime, episode_count) {
    useDebounce(() => {
        router.put(
            route("saved-anime.save-episode"),
            { anime, episode_count },
            { preserveScroll: true }
        );
    }, 700);
}

function addLink() {
    if (!useUrl().isUrl(links_form.new_link)) {
        links_form.new_link = "";
        alert("URL inválida");
        return;
    }

    router.put(route("saved-anime.update-link"), links_form, {
        preserveScroll: true,
    });

    links_form.new_link = "";
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
    <div class="shadow-xl group card card-compact">
        <div>
            <div
                class="absolute flex flex-col justify-end w-full bottom-[35px] p-2 h-36"
            >
                <h4
                    class="z-10 text-xs font-black text-center text-white card-title line-clamp-3"
                >
                    {{ anime.title }}
                </h4>

                <div
                    class="absolute inset-0 opacity-80 bg-gradient-to-t from-black via-black to-transparent"
                ></div>
            </div>

            <figure>
                <img
                    class="w-full h-[240px] lg:h-[320px]"
                    :src="anime.image_cover_url"
                />
            </figure>
        </div>

        <div>
            <div class="min-w-full card-actions">
                <div class="min-w-full join">
                    <input
                        class="w-full max-w-xs rounded-tl-none input input-sm join-item"
                        type="number"
                        min="0"
                        placeholder="Episodio"
                        :value="anime.episode_count"
                        @change.prevent="
                            updateSavedAnimeEpisode(anime, $event.target.value)
                        "
                        @input="
                            updateSavedAnimeEpisode(anime, $event.target.value)
                        "
                    />

                    <div class="dropdown dropdown-end">
                        <label
                            tabindex="0"
                            class="!rounded-tr-none btn btn-primary btn-square btn-sm join-item"
                        >
                            <Ellipsis class="w-6 h-6" />
                        </label>

                        <ul
                            tabindex="0"
                            class="p-2 shadow dropdown-content menu bg-base-100 rounded-box"
                        >
                            <li v-for="link in anime.links">
                                <div
                                    class="flex justify-between gap-4"
                                    title="Cole o link do seu site de animes preferido..."
                                    :key="link"
                                >
                                    <a
                                        :href="link ?? '#'"
                                        target="_blank"
                                        class="flex items-center gap-1"
                                    >
                                        <ArrowTopRightSquare class="w-3 h-3" />

                                        {{ useUrl().domain(link) }}
                                    </a>

                                    <button
                                        class="text-red-500 btn btn-square btn-sm btn-outline"
                                        title="Remover Link"
                                        @click="removeLink(anime.id, link)"
                                    >
                                        <TrashBasic class="w-5 h-5" />
                                    </button>
                                </div>
                            </li>

                            <li>
                                <form @submit.prevent="addLink">
                                    <div
                                        class="flex gap-2"
                                        title="Cole o link do seu site de animes preferido..."
                                    >
                                        <input
                                            class="w-40 max-w-xs input input-sm input-bordered"
                                            type="text"
                                            placeholder="Cole seu link"
                                            v-model="links_form.new_link"
                                        />

                                        <button
                                            class="btn btn-square btn-sm btn-outline btn-primary"
                                            title="Adicionar Link"
                                        >
                                            <PlusCircle class="w-5 h-5" />
                                        </button>
                                    </div>
                                </form>
                            </li>

                            <li>
                                <button
                                    class="text-red-500"
                                    @click.prevent="removeAnime"
                                >
                                    <TrashBasic class="w-5 h-5" />

                                    Remover anime
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
