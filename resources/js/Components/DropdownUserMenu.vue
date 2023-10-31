<script setup>
import { onMounted } from "vue";
import { Link } from "@inertiajs/vue3";
import { initFlowbite } from "flowbite";

import BrushOutline from "@/Icons/HeroIcons/BrushOutline.vue";
import LanguageOutline from "@/Icons/HeroIcons/LanguageOutline.vue";
import GoOutOutline from "@/Icons/HeroIcons/GoOutOutline.vue";
import GoInOutline from "@/Icons/HeroIcons/GoInOutline.vue";
import PencilSquare from "@/Icons/HeroIcons/PencilSquare.vue";

onMounted(() => initFlowbite());
</script>

<template>
    <div
        id="dropdownUserMenu"
        class="z-30 hidden w-fit min-w-[280px] divide-y divide-gray-100"
        aria-labelledby="dropdownUserMenuButton"
    >
        <div
            class="rounded-lg border border-white/20 bg-transparent bg-gradient-to-b from-black/20 to-white/10 px-4 py-2 shadow backdrop-blur"
        >
            <div
                v-if="$page.props.auth.user"
                class="flex flex-col gap-1 divide-y divide-white/20"
            >
                <div>
                    <div>
                        <button
                            href="#"
                            class="flex w-full items-center gap-2 rounded px-4 py-3 hover:bg-white/5 hover:backdrop-blur disabled:text-gray-500"
                            disabled
                        >
                            <BrushOutline class="stroke-gray-500" />

                            <div class="text-sm font-bold">
                                Personalizar Tema
                            </div>
                        </button>
                    </div>

                    <div>
                        <button
                            href="#"
                            class="flex w-full items-center gap-2 rounded px-4 py-3 text-white hover:bg-white/5 hover:backdrop-blur disabled:text-gray-500"
                            disabled
                        >
                            <LanguageOutline class="stroke-gray-500" />

                            <div class="text-sm font-bold">
                                Idioma dos Títulos
                            </div>
                        </button>
                    </div>
                </div>

                <div>
                    <Link
                        :href="route('logout')"
                        class="mt-1 flex items-center gap-2 rounded px-4 py-3 hover:bg-white/5 hover:backdrop-blur"
                        method="post"
                        as="button"
                    >
                        <GoOutOutline />

                        <div class="text-sm font-bold text-white">Sair</div>
                    </Link>
                </div>
            </div>

            <div v-else>
                <Link
                    :href="route('login')"
                    class="flex items-center gap-2 rounded px-4 py-3 hover:bg-white/5 hover:backdrop-blur"
                >
                    <GoInOutline />

                    <div class="text-sm font-bold text-white">Login</div>
                </Link>

                <Link
                    :href="route('register')"
                    class="flex items-center gap-2 rounded px-4 py-3 hover:bg-white/5 hover:backdrop-blur"
                >
                    <PencilSquare class="h-5 w-5" />

                    <div class="text-sm font-bold text-white">Register</div>
                </Link>
            </div>
        </div>
    </div>
</template>
