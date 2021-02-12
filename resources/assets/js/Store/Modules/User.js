import Vue from 'vue'
import {
    USER_UPDATE,
    USER_CHECK_SUBSCRIPTION,
    USER_CHECK_FOLLOWING,
    USER_LOGOUT,
} from '@/Store/Actions/User'
import { AUTH_SUCCESS, AUTH_EXPIRED, AUTH_LOGOUT } from '@/Store/Actions/Authentication'

export default {
    state: () => ({
        user: {
            id: null,
            name: null,
            isFollowing: false,
            isSubscribed: false,
        },
    }),
    mutations: {
        [USER_UPDATE]: (state, user) => {
            state.user = user
        },
        [USER_LOGOUT]: (state) => {
            window.twitchAPI.defaults.headers.common['Authorization'] = null

            state.user = {
                id: null,
                name: null,
                isFollowing: false,
                isSubscribed: false,
            }
        },
    },
    actions: {
        [USER_UPDATE]: ({ commit, dispatch }) => {
            let userData = localStorage.getItem('userToken')

            if (userData !== undefined && userData !== null && userData !== '') {
                userData = JSON.parse(userData)

                if (
                    Vue.prototype.moment(userData.expires).toDate() >
                    Vue.prototype.moment().toDate()
                ) {
                    window.twitchAPI.defaults.headers.common['Authorization'] =
                        'OAuth ' + userData.token

                    window.twitchAPI
                        .get('/')
                        .then((response) => {
                            if (
                                response.data.token.valid === true &&
                                response.data.token.client_id === '5xrjahdm6fo4zkob8xl6to1hu0q8mci'
                            ) {
                                commit(USER_UPDATE, {
                                    id: response.data.token.user_id,
                                    name: response.data.token.user_name,
                                    isFollowing: false,
                                    isSubscribed: false,
                                })

                                dispatch(USER_CHECK_FOLLOWING)
                                dispatch(USER_CHECK_SUBSCRIPTION)

                                commit(AUTH_SUCCESS, userData.token)
                            } else {
                                dispatch(AUTH_LOGOUT)
                            }
                        })
                        .catch(() => {
                            dispatch(AUTH_EXPIRED)
                        })
                } else {
                    dispatch(AUTH_EXPIRED)
                }
            } else {
                dispatch(AUTH_EXPIRED)
            }
        },
        [USER_CHECK_SUBSCRIPTION]: ({ state, commit }) => {
            if (state.user.id !== null) {
                window.twitchAPI
                    .get('/users/' + state.user.id + '/subscriptions/56964879')
                    .then(() => {
                        commit(USER_UPDATE, {
                            ...state.user,
                            isSubscribed: true,
                        })
                    })
                    .catch(() => {})
            }
        },
        [USER_CHECK_FOLLOWING]: ({ state, commit }) => {
            if (state.user.id !== null) {
                window.twitchAPI
                    .get('/users/' + state.user.id + '/follows/channels/56964879')
                    .then(() => {
                        commit(USER_UPDATE, {
                            ...state.user,
                            isFollowing: true,
                        })
                    })
                    .catch(() => {})
            }
        },
    },
    getters: {
        getUser: (state) => state.user,
    },
}
