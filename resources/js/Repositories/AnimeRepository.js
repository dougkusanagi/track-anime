import axios from "axios";

export function getAnimeDetails(anime) {
    return new Promise(async (resolve) => {
        const { data } = await axios.get(route("anime-details", anime.mal_id));

        resolve(data);
    });
}
