const useScreen = function () {
    return {
        isMobile() {
            return screen.width <= 760;
        },
    };
};

export default useScreen;
