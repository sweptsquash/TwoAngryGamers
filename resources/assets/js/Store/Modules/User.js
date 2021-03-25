import Vue from 'vue'
import {
    USER_UPDATE,
    USER_CHECK_SUBSCRIPTION,
    USER_CHECK_FOLLOWING,
    USER_CHECK_ROLES,
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
            permissions: [],
        },
    }),
    mutations: {
        [USER_UPDATE]: (state, user) => {
            state.user = user
        },
        [USER_LOGOUT]: (state) => {
            let userData = localStorage.getItem('userToken')

            if (userData !== undefined && userData !== null && userData !== '') {
                userData = JSON.parse(userData)

                window.axios.post(
                    'https://id.twitch.tv/oauth2/revoke?client_id=5xrjahdm6fo4zkob8xl6to1hu0q8mci&token=' +
                        userData.token,
                    [],
                )
            }

            state.user = {
                id: null,
                name: null,
                isFollowing: false,
                isSubscribed: false,
                permissions: [],
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

                    window.axios
                        .get('https://id.twitch.tv/oauth2/validate', {
                            headers: {
                                ...window.axios.defaults.headers.common,
                                Authorization: 'OAuth ' + userData.token,
                            },
                        })
                        .then((response) => {
                            if (response.data.client_id === '5xrjahdm6fo4zkob8xl6to1hu0q8mci') {
                                commit(USER_UPDATE, {
                                    id: response.data.user_id,
                                    name: response.data.login,
                                    isFollowing: false,
                                    isSubscribed: false,
                                    permissions: [],
                                })

                                dispatch(USER_CHECK_FOLLOWING)
                                dispatch(USER_CHECK_SUBSCRIPTION)
                                dispatch(USER_CHECK_ROLES)

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
        [USER_CHECK_ROLES]: ({ state, commit }) => {
            if (state.user.id !== null) {
                window.axios
                    .post('/editor/me', {
                        uuid: state.user.id,
                    })
                    .then((response) => {
                        commit(USER_UPDATE, {
                            ...state.user,
                            permissions: response.data.data.role.permissions,
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
