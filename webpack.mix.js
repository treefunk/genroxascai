const path = require('path')
const mix = require('laravel-mix')
// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix.config.vue.esModule = true

mix
  .js('resources/js/app.js', 'public/js')
  .js('resources/js/appbackend.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/appbackend.scss', 'public/css')
  .styles('resources/css/fontawesome-free/css/all.min.css','public/css/fontawesome.css')
  .sourceMaps()
  .disableNotifications()
  .copyDirectory('resources/js/public', 'public/js') // for stand alone third party libs in backend
  .copyDirectory('resources/css/public', 'public/css') // for stand alone third party libs in backend
  .copyDirectory('resources/images', 'public/images') 
  .copyDirectory('resources/sounds', 'public/sounds') 

if (mix.inProduction()) {
  mix.version()

  mix.extract([
    'vue',
    'vform',
    'axios',
    'vuex',
    'jquery',
    'popper.js',
    'vue-i18n',
    'vue-meta',
    'js-cookie',
    'bootstrap',
    'vue-router',
    'sweetalert2',
    'vuex-router-sync',
    '@fortawesome/vue-fontawesome',
    '@fortawesome/fontawesome-svg-core'
  ])
}

mix.webpackConfig({
  plugins: [
    // new BundleAnalyzerPlugin()
  ],
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '~': path.join(__dirname, './resources/js')
    }
  },
  output: {
    chunkFilename: 'js/[name].[chunkhash].js',
    publicPath: mix.config.hmr ? '//localhost:8080' : '/'
  }
})

