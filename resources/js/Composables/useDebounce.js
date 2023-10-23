// Debounce
let timeoutId;
export default function useDebounce(callback, delay) {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(callback, delay);
}
