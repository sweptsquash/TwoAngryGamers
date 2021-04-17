import route from 'ziggy'
import { Ziggy } from '@/ziggy'
import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import Vue from 'vue'
import VueMeta from 'vue-meta'
import { BootstrapVue } from 'bootstrap-vue'
import moment from 'moment'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {
    faDiscord,
    faFacebookF,
    faGithub,
    faInstagram,
    faTwitch,
    faTwitter,
    faYoutube,
} from '@fortawesome/free-brands-svg-icons'
import {
    faCalendar,
    faComments,
    faDownload,
    faEye,
    faFilter,
    faInfo,
    faMinus,
    faPlus,
    faShoppingBag,
    faStar,
    faTimes,
    faTrash,
    faUserEdit,
    faUsers,
    faVideo,
} from '@fortawesome/free-solid-svg-icons'
import store from '@/Store'
require('@/bootstrap')
import '../sass/app.scss'

library.add(
    faCalendar,
    faComments,
    faDiscord,
    faDownload,
    faEye,
    faFacebookF,
    faFilter,
    faGithub,
    faInfo,
    faInstagram,
    faMinus,
    faPlus,
    faShoppingBag,
    faStar,
    faTimes,
    faTrash,
    faTwitch,
    faTwitter,
    faUsers,
    faUserEdit,
    faVideo,
    faYoutube,
)

moment.locale(window.navigator.userLanguage || window.navigator.language)

Vue.config.productionTip = false
Vue.use(plugin)
Vue.use(BootstrapVue)
Vue.use(VueMeta)
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.prototype.moment = moment

Vue.mixin({
    methods: {
        getFormatedDate: (date, format = 'DD/MM/YYYY hh:mm:ss') => {
            return moment(date).format(format)
        },
        formatNumber: (num) => {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        },
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
    },
})

InertiaProgress.init()

const el = document.getElementById('app')

new Vue({
    store,
    metaInfo: {
        titleTemplate: (title) => (title ? `${title} | Two Angry Gamers` : 'Two Angry Gamers'),
        link: [{ rel: 'canonical', href: 'https://www.twoangrygamers.tv' }],
        meta: [
            {
                property: 'og:title',
                content: 'Two Angry Gamers',
            },
            {
                name: 'twitter:title',
                content: 'Two Angry Gamers',
            },
            {
                property: 'og:url',
                content: 'https://www.twoangrygamers.tv',
            },
        ],
    },
    render: (h) =>
        h(App, {
            props: {
                initialPage: JSON.parse(el.dataset.page),
                resolveComponent: (name) =>
                    import(`@/Pages/${name}`).then((module) => module.default),
                resolveErrors: (page) => page.props.errors || {},
            },
        }),
}).$mount(el)
