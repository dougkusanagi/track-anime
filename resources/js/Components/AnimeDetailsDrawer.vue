<script setup>
import AppInputBasic from "./AppInputBasic.vue";

const props = defineProps({
    anime: Object,
});
</script>

<template>
    <!-- drawer component -->
    <div
        id="drawer-saved-anime-details"
        class="fixed left-0 top-0 z-40 h-screen w-11/12 -translate-x-full overflow-y-auto bg-white/5 p-4 backdrop-blur-2xl transition-transform sm:w-[540px]"
        tabindex="-1"
        aria-labelledby="drawer-label"
    >
        <h5
            id="drawer-label"
            class="mb-4 inline-flex items-center text-base font-semibold text-white"
        >
            {{ anime.title }}
        </h5>

        <button
            type="button"
            data-drawer-hide="drawer-saved-anime-details"
            aria-controls="drawer-saved-anime-details"
            class="absolute right-2.5 top-2.5 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-white hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
        >
            <svg
                class="h-3 w-3"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 14"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                />
            </svg>

            <span class="sr-only">Close menu</span>
        </button>

        <!-- <pre>{{ anime }}</pre> -->

        <div class="flex">
            <img :src="anime.image_cover_url" alt="" />

            <div class="flex w-full flex-col justify-between">
                <div
                    class="grid w-full grid-cols-3 items-center divide-x-2 divide-white/20"
                >
                    <span class="flex justify-center">2023</span>

                    <div class="flex justify-center">
                        <div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-6 w-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"
                                />
                            </svg>
                        </div>

                        <div class="hidden">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="h-6 w-6"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-6 w-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                                />
                            </svg>
                        </div>

                        <div class="hidden">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="h-6 w-6"
                            >
                                <path
                                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="mt-6 flex flex-col gap-1 px-4">
                        <label for="" class="text-white">Lista</label>
                        <AppInputBasic />
                    </div>

                    <div class="mt-6 flex flex-col gap-1 px-4">
                        <label for="" class="text-white">Reassistido</label>
                        <AppInputBasic />
                    </div>

                    <div class="mt-6 flex flex-col gap-1 px-4">
                        <label for="" class="text-white">Dê sua nota</label>
                        <AppInputBasic />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
