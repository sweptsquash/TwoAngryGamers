import Vue from 'vue'
import Vuex from 'vuex'
import authentication from '@/Store/Modules/Authentication'
import user from '@/Store/Modules/User'
import editor from '@/Store/Modules/Editor'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        authentication,
        user,
        editor,
    },
    strict: debug,
})
