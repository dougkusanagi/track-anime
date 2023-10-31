<script setup>
import { Link, router } from "@inertiajs/vue3";

import PlusCircle from "@/Icons/HeroIcons/PlusCircle.vue";
import { useToast } from "vue-toastification";

const props = defineProps({ anime: Object, already_on_list: Boolean });
const toast = useToast();

function addToList() {
    if (props.already_on_list) {
        toast("Este anime já está na sua lista.");
        return;
    }

    router.post(route("saved-anime.store"), { mal_id: props.anime.mal_id });
}
</script>

<template>
    <div class="flex w-40 flex-col justify-end rounded-xl">
        <p
            class="line-clamp-3 w-full p-1 text-center text-xs font-black text-white"
        >
            {{ anime.title }}
        </p>

        <img
            class="h-64 w-40 object-cover"
            :class="already_on_list ? 'brightness-50' : ''"
            :src="anime.images.webp.large_image_url"
            alt=""
        />

        <div class="flex w-full items-center">
            <button
                as="button"
                @click="addToList"
                class="flex h-8 w-full items-center justify-center rounded-b-lg hover:brightness-150"
                :class="
                    already_on_list
                        ? 'brightness-50 hover:bg-gray800 bg-gray-600'
                        : 'bg-[#1D0D80]'
                "
            >
                <PlusCircle />
            </button>
        </div>
    </div>

    <!-- <pre>{{ anime }}</pre> -->
</template>
