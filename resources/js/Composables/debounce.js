// Debounce
let timeoutId;
export default function debounce(callback, delay) {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(callback, delay);
}
