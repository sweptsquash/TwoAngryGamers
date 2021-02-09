<template>
    <b-navbar toggleable="lg" fixed="top">
        <b-container>
            <inertia-link :href="route('homepage')" class="navbar-brand">
                <img :src="logo" alt="Two Angry Gamers" />
            </inertia-link>
            <b-navbar-toggle target="nav-collapse" />
            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav class="ml-auto">
                    <li class="nav-item">
                        <inertia-link
                            :href="route('about')"
                            :class="{ 'nav-link': true, active: route().current('about') }"
                        >
                            <font-awesome-icon :icon="['fas', 'info']" />
                            About
                        </inertia-link>
                    </li>
                    <li class="nav-item">
                        <inertia-link
                            :href="route('subperks')"
                            :class="{ 'nav-link': true, active: route().current('subperks') }"
                        >
                            <font-awesome-icon :icon="['fas', 'star']" />
                            Subperks
                        </inertia-link>
                    </li>
                    <b-nav-item
                        href="https://www.designbyhumans.com/shop/TwoAngryGamersTV/"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <font-awesome-icon :icon="['fas', 'shopping-bag']" />
                        Merch
                    </b-nav-item>
                    <b-nav-form>
                        <b-button variant="outline-light" id="authUser" @click.prevent="authorize">
                            <font-awesome-icon :icon="['fab', 'twitch']" />
                            Sign {{ !isAuthorized ? 'In' : 'Out' }}
                        </b-button>
                    </b-nav-form>
                </b-navbar-nav>
            </b-collapse>
        </b-container>
    </b-navbar>
</template>

<script>
import { mapGetters } from 'vuex'
import { AUTH_LOGIN, AUTH_LOGOUT } from '@/Store/Actions/Authentication'

import logoImg from '../../images/logo.png'

export default {
    name: 'AppNav',
    data() {
        return {
            logo: logoImg,
        }
    },
    computed: {
        ...mapGetters(['isAuthorized']),
    },
    methods: {
        authorize() {
            if (!this.$store.getters.isAuthorized) {
                this.$store.dispatch(AUTH_LOGIN)
            } else {
                this.$store.dispatch(AUTH_LOGOUT)
            }
        },
    },
}
</script>
