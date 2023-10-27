<script setup>
import { Head } from "@inertiajs/vue3";

import NewAuthLayout from "@/Layouts/NewAuthLayout.vue";
import AnimeSavedFilterSelect from "@/Components/AnimeSavedFilterSelect.vue";
import Ellipsis from "@/Icons/HeroIcons/Ellipsis.vue";

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

    <NewAuthLayout>
        <!-- <button
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            type="button"
            data-drawer-target="drawer-example"
            data-drawer-show="drawer-example"
            aria-controls="drawer-example"
        >
            Show drawer
        </button> -->

        <div class="mt-16 ml-12">
            <h2 class="pb-3 text-2xl border-b border-white">Minha Lista</h2>

            <div class="flex gap-8">
                <div class="flex items-center gap-2 mt-6">
                    <label
                        for="orderBy"
                        class="block text-sm font-medium dark:text-white min-w-fit"
                    >
                        ORDENAR POR:
                    </label>

                    <AnimeSavedFilterSelect
                        id="orderBy"
                        :options="[{ label: 'Todos', value: '' }]"
                    />
                </div>

                <div class="flex items-center gap-2 mt-6">
                    <label
                        for="gender"
                        class="flex items-center gap-2 text-sm font-medium dark:text-white min-w-fit"
                    >
                        GÊNEROS:

                        <AnimeSavedFilterSelect
                            id="gender"
                            :options="[{ label: 'Todos', value: '' }]"
                        />
                    </label>
                </div>
            </div>

            <div class="mt-6">
                <div class="w-fit">
                    <p>{{ animes.data[1].title }}</p>

                    <img
                        class="w-40 h-60"
                        :src="animes.data[1].images.webp.image_url"
                        alt=""
                    />

                    <div class="flex items-center">
                        <button class="bg-[#1D0D80] w-7 h-8 rounded-bl-lg">
                            -
                        </button>

                        <input
                            class="flex-1 w-16 bg-[#140A4F] border-none h-8"
                            type="text"
                        />

                        <button class="bg-[#1D0D80] w-7 h-8">+</button>

                        <button
                            class="flex items-center justify-center h-8 bg-[#4712DD] rounded-br-lg w-7"
                        >
                            <Ellipsis />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- <p>{{ animes }}</p> -->
    </NewAuthLayout>
</template>
