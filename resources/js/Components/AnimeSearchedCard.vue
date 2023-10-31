<script setup>
import { Link } from "@inertiajs/vue3";

import PlusCircle from "@/Icons/HeroIcons/PlusCircle.vue";

const props = defineProps({ anime: Object });
</script>

<template>
    <div
        class="flex flex-col w-40 shadow-xl rounded-xl bg-base-200"
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
                class="w-full h-[260px] object-cover"
                :src="anime.images.webp.image_url"
            />
        </figure>

        <div class="flex flex-col items-center justify-between !p-2 card-body">
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
</template>
