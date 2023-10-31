<script setup>
import { Link } from "@inertiajs/vue3";

import PlusCircle from "@/Icons/HeroIcons/PlusCircle.vue";
import ButtonChangeEp from "./ButtonChangeEp.vue";

const props = defineProps({ anime: Object });
</script>

<template>
    <div class="flex w-40 flex-col justify-end rounded-xl">
        <p
            class="line-clamp-3 w-full p-1 text-center text-xs font-black text-white"
        >
            {{ anime.title }}
        </p>

        <img class="h-64 w-40" :src="anime.images.webp.image_url" alt="" />

        <div class="flex w-full items-center">
            <Link
                class="flex h-8 w-8 w-full items-center justify-center rounded-b-lg bg-[#1D0D80] hover:brightness-150"
                method="post"
                as="button"
                :href="route('saved-anime.store')"
                :data="{ mal_id: anime.mal_id }"
            >
                <PlusCircle />
            </Link>
        </div>
    </div>

    <!-- <pre>{{ anime }}</pre> -->
</template>
