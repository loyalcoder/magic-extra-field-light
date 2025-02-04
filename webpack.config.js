const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
    entry: {
        'admin': './src/admin/index.js',
        'admin-style': './src/admin/scss/admin.scss', 
        'frontend': './src/index.js',
        'style': './src/scss/style.scss'
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'assets/dist')
    },
    externals: {
        jquery: 'jQuery'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'postcss-loader',
                    'sass-loader'
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css'
        })
    ],
    mode: process.env.NODE_ENV === 'production' ? 'production' : 'development'
};
