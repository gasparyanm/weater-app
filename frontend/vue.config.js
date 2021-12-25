module.exports = {
    devServer: {
        proxy: {
            '^/api': {
                target: process.env.VUE_APP_PROXY_BACKEND_URL,
                changeOrigin: true,
                pathRewrite: {
                    '^/api': '/api/'
                },
            }
        }
    }
}