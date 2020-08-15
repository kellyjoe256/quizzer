module.exports = {
    runtimeCompiler: true,
    configureWebpack: {
        module: {
            rules: [
                {
                    test: /.html$/,
                    loader: 'vue-template-loader',
                    exclude: /index.html/,
                },
            ],
        },
    },
    transpileDependencies: ['vuex-module-decorators'],
};
