const useUrl = function () {
    return {
        params: Object.fromEntries(new URLSearchParams(location.search)),
        domain: (url) => (url ? new URL(url).hostname : window.location.host),
        isUrl: (url) => {
            try {
                return Boolean(new URL(url));
            } catch {
                return false;
            }
        },
    };
};

export default useUrl;
