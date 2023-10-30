import { defineStore } from "pinia";
import { ref } from "vue";

export const useSelectedAnime = defineStore("selectedAnime", () => {
    const selected_anime = ref(null);
    // const name = ref("Eduardo");
    // const doubleCount = computed(() => count.value * 2);
    // function increment() {
    //     count.value++;
    // }

    return { selected_anime };
});
