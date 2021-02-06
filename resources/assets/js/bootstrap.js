window._ = require('lodash')
window.axios = require('axios')

window.axios.defaults.baseURL = '/api'

window.axios.defaults.headers.common = {
    ...window.axios.defaults.headers.common,
    Accept: 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
}
