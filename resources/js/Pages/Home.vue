<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";

import AppSimpleSearchBar from "@/Components/AppSimpleSearchBar.vue";
import PlusCircle from "@/Icons/HeroIcons/PlusCircle.vue";
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

        <div class="pt-12 pb-48">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg">
                <h3
                    class="px-6 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
                    id="top-10"
                >
                    # 10 Mais Populares
                </h3>
            </div>

            <div
                class="grid grid-cols-3 gap-4 px-6 mx-auto mt-6 mb-12 md:grid-cols-10 max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg"
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
                                :href="route('saved-anime.store')"
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
                    <div
                        class="bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg"
                    >
                        <div class="flex justify-between p-6 pb-0 lg:px-4">
                            <h3
                                class="font-semibold leading-tight text-gray-800 dark:text-gray-200"
                            >
                                <Link href="#" class="text-lg btn btn-link">
                                    Minha Lista
                                </Link>
                            </h3>

                            <Link href="#" class="text-xs btn btn-link">
                                Ver todas
                            </Link>
                        </div>

                        <div
                            class="grid grid-cols-2 gap-6 p-6 mx-auto md:grid-cols-5 max-w-7xl sm:px-6 lg:px-8 sm:rounded-lg"
                        >
                            <SavedAnimeCard
                                v-for="anime in saved_animes"
                                :anime="anime"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
