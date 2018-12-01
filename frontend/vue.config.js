module.exports = {
    // proxy API requests to Valet during development
    devServer: {
        proxy: "http://localhost:8000"
    },

    // output built static files to Laravel's public dir.
    outputDir: "../public",

    // modify the location of the generated HTML file.
    indexPath:
        process.env.NODE_ENV === "production"
            ? "../resources/views/index.blade.php"
            : "index.html"
};
