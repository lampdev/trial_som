module.exports = {
  // proxy API requests to Valet during development
  devServer: {
    /* historyApiFallback: true,
    noInfo: true,
    port: 8080, */
    overlay: true,
    public: 'videoreviews.test',
    proxy: {
      '/api/*': {
        target: 'http://videoreviews.test:80',
        ws: true,
        changeOrigin: true
      }
    },
    watchOptions: {
      poll: true
    }
  },

  // output built static files to Laravel's public dir.
  // note the "build" script in package.json needs to be modified as well.
  outputDir: '../public',

  // modify the location of the generated HTML file.
  // make sure to do this only in production.
  indexPath: process.env.NODE_ENV === 'production'
    ? '../resources/views/index.blade.php'
    : 'index.html'
}
