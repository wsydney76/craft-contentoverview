// Support Test
const supportsContainerQueries = "container" in document.documentElement.style;

// Conditional Import
if (!supportsContainerQueries) {
    import("https://cdn.skypack.dev/container-query-polyfill");
}