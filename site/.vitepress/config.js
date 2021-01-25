const { getPosts } = require('./getPosts');

module.exports = {
    lang: 'en',
    title: 'Logic & Trick',
    description: 'Logic & Trick blog',

    head: [
      [ 'link', { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' } ]
    ],
    
    themeConfig: {
        logo: 'lnt_logo_2013.png'
    },

    customData: {
      posts: getPosts()
    }
};