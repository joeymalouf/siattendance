// vue.config.js
module.exports = {
    publicPath: process.env.NODE_ENV === 'production'
      ? '/~jmm-admin/dist/'
      : '/'
  }