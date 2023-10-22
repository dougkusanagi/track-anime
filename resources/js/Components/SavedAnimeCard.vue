<script setup>
import { router, useForm } from "@inertiajs/vue3";
import debounce from "@/Composables/debounce.js";

import Ellipsis from "@/Icons/HeroIcons/Ellipsis.vue";
import ArrowTopRightSquare from "@/Icons/HeroIcons/ArrowTopRightSquare.vue";
import TrashBasic from "@/Icons/HeroIcons/TrashBasic.vue";

const props = defineProps({ anime: Object });
const update_link_form = useForm({
    id: props.anime.id,
    link: props.anime.link,
});

function updateSavedAnimeEpisode(saved_anime, episode_count) {
    debounce(() => {
        router.put(
            route("saved-anime.save-episode"),
            {
                saved_anime,
                episode_count,
            },
            {
                preserveScroll: true,
            }
        );
    }, 700);
}

function updateSavedAnimeLink() {
    debounce(() => {
        router.put(route("saved-anime.update-link"), update_link_form, {
            preserveScroll: true,
        });
    }, 700);
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
                    class="w-full h-[260px] object-cover"
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

                    <!-- <button
                        class="btn btn-square btn-outline btn-primary btn-sm join-item"
                    >
                        +
                    </button> -->

                    <div class="dropdown dropdown-end">
                        <label
                            tabindex="0"
                            class="!rounded-tr-none btn btn-primary btn-square btn-sm join-item"
                        >
                            <Ellipsis class="w-6 h-6" />
                        </label>

                        <ul
                            tabindex="0"
                            class="p-2 shadow dropdown-content menu bg-base-100 rounded-box w-52"
                        >
                            <li class="z-40">
                                <a :href="anime.link ?? '#'" target="_blank">
                                    <ArrowTopRightSquare class="w-5 h-5" />

                                    Assistir
                                </a>
                            </li>

                            <li>
                                <form @submit.prevent="updateSavedAnimeLink">
                                    <div
                                        class="flex gap-2"
                                        title="Cole o link do seu site de animes preferido..."
                                    >
                                        <input
                                            class="w-full max-w-xs input input-sm input-bordered"
                                            type="text"
                                            placeholder="Cole seu link"
                                            v-model="update_link_form.link"
                                        />

                                        <button
                                            class="btn btn-square btn-sm btn-outline btn-primary"
                                            title="Editar Link"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="w-6 h-6"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
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

                                    Remover da lista
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
