<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import debounce from "@/Composables/debounce.js";

import AppSimpleSearchBar from "@/Components/AppSimpleSearchBar.vue";
import PlusCircle from "@/Icons/HeroIcons/PlusCircle.vue";
import Ellipsis from "@/Icons/HeroIcons/Ellipsis.vue";
import ArrowTopRightSquare from "@/Icons/HeroIcons/ArrowTopRightSquare.vue";
import TrashBasic from "@/Icons/HeroIcons/TrashBasic.vue";
import PencilSquare from "@/Icons/HeroIcons/PencilSquare.vue";

const props = defineProps({
  animes: Object,
  saved_animes: {
    type: Array,
    default: [],
  },
});

function updateSavedAnimeEpisode(saved_anime, episode_count) {
  debounce(() => {
    router.put(
      route("saved-animes.save-episode"),
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

function updateSavedAnimeLink(form) {
  const form_data = new FormData(form);
  const id = form_data.get("id") || null;
  const link = form_data.get("link") || null;

  debounce(() => {
    router.put(
      route("saved-animes.update-link"),
      {
        id,
        link,
      },
      {
        preserveScroll: true,
      }
    );
  }, 700);
}

function removeAnime(id) {
  router.delete(
    route("saved-animes.destroy"),
    {
      id,
    },
    {
      preserveScroll: true,
    }
  );
}
</script>

<template>
  <Head title="Home" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2
          class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
        >
          Home
        </h2>

        <AppSimpleSearchBar />
      </div>
    </template>

    <div class="pt-12 pb-32">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg">
        <h3
          class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
          id="top-10"
        >
          # 10 Mais Populares
        </h3>
      </div>

      <div
        class="grid grid-cols-10 gap-4 px-6 mx-auto mt-6 mb-12 max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg"
      >
        <div
          class="shadow-xl card card-compact bg-base-200"
          v-for="anime in animes.data"
          :title="anime.title"
          :key="anime.id"
        >
          <div>
            <div
              class="absolute flex flex-col justify-end group-hover:justify-between w-full bottom-[48px] p-2 h-36"
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
          </div>

          <figure>
            <img
              class="w-full h-[170px] object-cover"
              :src="anime.images.webp.image_url"
            />
          </figure>

          <div
            class="flex flex-col items-center justify-between !p-2 card-body"
          >
            <div class="min-w-full card-actions">
              <Link
                method="post"
                as="button"
                :href="route('saved-animes.store')"
                :data="{ mal_id: anime.mal_id }"
                class="flex-1 col-span-1 btn btn-square btn-outline btn-primary btn-sm"
                title="Adicionar à lista"
              >
                <PlusCircle class="w-5 h-5" />
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
            <div class="flex justify-between p-6 pb-0 lg:px-4">
              <h3
                class="font-semibold leading-tight text-gray-800 dark:text-gray-200"
              >
                <Link href="#" class="text-lg btn btn-link"> Minha Lista </Link>
              </h3>

              <Link href="#" class="text-xs btn btn-link"> Ver todas </Link>
            </div>

            <div
              class="grid grid-cols-5 gap-6 p-6 mx-auto max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg"
            >
              <div
                class="shadow-xl group card card-compact bg-base-200"
                v-for="anime in saved_animes"
                :title="anime.title"
              >
                <div>
                  <div
                    class="absolute flex flex-col justify-end w-full bottom-[50px] p-2 h-36"
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

                <div class="!p-2 card-body">
                  <div class="min-w-full card-actions">
                    <div class="min-w-full join">
                      <input
                        class="w-full max-w-xs input input-sm join-item"
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

                      <button
                        class="btn btn-square btn-outline btn-primary btn-sm"
                      >
                        +
                      </button>

                      <div class="dropdown dropdown-end">
                        <label
                          tabindex="0"
                          class="btn btn-primary btn-square btn-sm join-item"
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
                            <form
                              @submit.prevent="
                                updateSavedAnimeLink($event.target)
                              "
                            >
                              <div
                                class="flex"
                                title="Cole o link do seu site de animes preferido..."
                              >
                                <input
                                  type="hidden"
                                  name="id"
                                  :value="anime.id"
                                />

                                <input
                                  class="w-full max-w-xs input input-sm"
                                  type="text"
                                  placeholder="Cole seu link"
                                  name="link"
                                  :value="anime.link"
                                />

                                <button title="Editar Link">
                                  <PencilSquare class="w-5 h-5" />
                                </button>
                              </div>
                            </form>
                          </li>

                          <li>
                            <button
                              class="text-red-500"
                              @click.prevent="removeAnime(anime.id)"
                            >
                              <TrashBasic class="w-5 h-5" />

                              Remover
                            </button>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
