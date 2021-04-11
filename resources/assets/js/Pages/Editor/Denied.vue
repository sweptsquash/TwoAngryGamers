<template>
    <b-container>
        <b-row>
            <b-col class="text-center mt-5">
                <h1>Access Denied</h1>
                <p v-if="isAuthorized">You do not have permission to access this area.</p>
                <p v-else>Please login to access the Editor Section.</p>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import { mapGetters } from 'vuex'
import Layout from '@/Shared/Layout'

export default {
    name: 'Denied',
    layout: Layout,
    computed: {
        ...mapGetters(['isAuthorized', 'getUser']),
    },
    watch: {
        getUser: {
            handler(user, oldUser) {
                if (this.isAuthorized) {
                    if (
                        user.id !== null &&
                        oldUser !== undefined &&
                        user.id === oldUser.id &&
                        user.permissions !== oldUser.permissions
                    ) {
                        if (user.permissions.length > 0) {
                            this.$inertia.visit(this.route('editor.index'))
                        }
                    }
                }
            },
            immediate: true,
        },
    },
    mounted: function () {
        if (
            this.$store.getters.isAuthorized &&
            this.$store.getters.getUser.permissions.length > 0
        ) {
            this.$inertia.visit(this.route('editor.index'))
        }
    },
}
</script>
