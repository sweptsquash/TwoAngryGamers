window._ = require('lodash')
window.axios = require('axios')

window.axios.defaults.baseURL = '/api'

window.axios.defaults.headers.common = {
    ...window.axios.defaults.headers.common,
    Accept: 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
}

window.twitchAPI = window.axios.create({
    baseURL: 'https://api.twitch.tv/kraken',
    headers: {
        'Client-ID': '5xrjahdm6fo4zkob8xl6to1hu0q8mci',
        Accept: 'application/vnd.twitchtv.v5+json',
    },
})
