module.exports = {
    api: {
        output: {
            mode: "single",
            target: "./resources/js/api.ts",
            client: "react-query",
            httpClient: "fetch",
            mock: false,
            override: {
                fetch: {
                    includeHttpResponseReturnType: false,
                },
            },
        },
        input: "./api.yaml",
    },
};
