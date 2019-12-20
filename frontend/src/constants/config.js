// auth.js
export const config = {
  appName: process.env.VUE_APP_TITLE,
  locale: process.env.VUE_APP_LOCALE,
  locales: {
    en: 'EN',
    'zh-CN': '中文',
    es: 'ES'
  },
  githubAuth: process.env.VUE_APP_GITHUB_CLIENT_ID
}
