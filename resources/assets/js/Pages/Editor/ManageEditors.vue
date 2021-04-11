<template>
    <div>
        <b-button variant="primary" @click="toggleEditors">
            <font-awesome-icon :icon="['fas', 'users']" />
            Manage Editors
        </b-button>

        <b-modal id="editorModal" size="lg" v-model="showModal" title="Editors">
            <template v-if="!isAdding && !isEditing">
                <div class="text-right mb-3">
                    <b-button
                        variant="primary"
                        @click="toggleAdd"
                        v-if="getUser.permissions.includes('Create Editors')"
                    >
                        Add Editor
                    </b-button>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="isLoading">
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="lds-roller mb-2">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                    <p>Loading Editors...</p>
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <template v-if="editors.length > 0">
                                <tr v-for="editor in editors" :key="`editor-${editor.id}`">
                                    <td class="align-middle">{{ editor.name }}</td>
                                    <td class="align-middle">{{ editor.role.name }}</td>
                                    <td class="align-middle">
                                        {{ getFormatedDate(editor.created, 'DD/MM/YYYY hh:mm') }}
                                    </td>
                                    <td class="text-center">
                                        <b-button-group>
                                            <b-button
                                                variant="success"
                                                title="Edit Editor"
                                                v-if="getUser.permissions.includes('Edit Editors')"
                                                @click="updateEditor(editor.id)"
                                            >
                                                <font-awesome-icon :icon="['fas', 'user-edit']" />
                                            </b-button>
                                            <b-button
                                                variant="danger"
                                                title="Delete Editor"
                                                v-if="
                                                    getUser.permissions.includes('Delete Editors')
                                                "
                                                @click="deleteEditor(editor.id, editor.name)"
                                            >
                                                <font-awesome-icon :icon="['fas', 'trash']" />
                                            </b-button>
                                        </b-button-group>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr class="table-danger">
                                    <td colspan="4" class="text-center">No Editors Found.</td>
                                </tr>
                            </template>
                        </template>
                    </tbody>
                </table>
                <Paginate
                    v-if="totalEditors > 15"
                    :pageSize="15"
                    :totalItems="totalEditors"
                    @click="fetchEditors"
                />
            </template>

            <form id="addEditor" v-if="isAdding">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row">Twitch Username:</th>
                            <td>
                                <b-input-group>
                                    <b-form-input
                                        v-model="editor.username"
                                        name="username"
                                        placeholder="Twitch Username..."
                                        :state="editor.valid"
                                    />
                                    <b-input-group-append>
                                        <b-button
                                            variant="outline-primary"
                                            @click.prevent="validateUser"
                                        >
                                            Find User
                                        </b-button>
                                    </b-input-group-append>
                                </b-input-group>
                                <b-form-text id="username-help">
                                    Enter a Twitch Username and click Find User to validate it.
                                </b-form-text>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Role:</th>
                            <td>
                                <b-form-select
                                    v-model="editor.role"
                                    :options="roles"
                                ></b-form-select>
                                <p class="mt-2 mb-0"><strong>Permissions</strong></p>
                                <ul class="mb-0">
                                    <li
                                        v-for="(permission, index) in roles[editor.role - 1]
                                            .permissions"
                                        :key="`permission-${index}`"
                                    >
                                        {{ permission }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <b-button variant="primary" @click.prevent="addEditor">
                                    Add Editor
                                </b-button>
                                <b-button variant="outline-primary" @click.prevent="listEditors">
                                    Cancel
                                </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>

            <form id="updateEditor" v-if="isEditing"></form>
        </b-modal>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Paginate from '@/Components/Paginate'

export default {
    name: 'ManageEditors',
    components: { Paginate },
    data() {
        return {
            showModal: false,
            editors: [],
            editor: {
                id: 0,
                username: '',
                role: 3,
                valid: null,
            },
            totalEditors: 0,
            isLoading: true,
            isAdding: false,
            isEditing: false,
            roles: [],
        }
    },
    computed: {
        ...mapGetters(['getUser']),
    },
    mounted: function () {
        this.fetchEditors()
        this.fetchRoles()
    },
    methods: {
        toggleEditors: function () {
            this.showModal = true
        },
        fetchEditors: function (offset = null) {
            if (this.editors.length > 0) {
                this.editors = []
            }

            this.isLoading = true

            window.axios
                .post(this.route('editor.list', { page: offset }), { uuid: this.getUser.id })
                .then((response) => {
                    this.totalEditors = response.data.meta.total

                    response.data.data.forEach((editor) => {
                        this.editors.push(editor)
                    })
                })
                .catch(() => {
                    this.totalEditors = 0

                    this.$bvToast.toast('Failed to load editors, please try again.', {
                        title: 'Error',
                        variant: 'danger',
                        solid: true,
                    })
                })
                .then(() => {
                    this.isLoading = false
                })
        },
        fetchRoles: function () {
            window.axios
                .post(this.route('editor.roles'), { uuid: this.getUser.id })
                .then((response) => {
                    response.data.data.forEach((role) => {
                        this.roles.push({
                            value: role.id,
                            text: role.name,
                            permissions: role.permissions,
                        })
                    })
                })
                .catch(() => {})
        },
        addEditor: function () {
            if (this.editor.valid) {
                window.axios
                    .post(this.route('editor.store'), {
                        uuid: this.getUser.id,
                        id: this.editor.id,
                        name: this.editor.username,
                        role_id: this.editor.role,
                    })
                    .then(() => {
                        this.$inertia.visit(this.route(this.route().current()))
                    })
                    .catch((response) => {
                        this.$bvToast.toast(response.data.message, {
                            title: 'Error',
                            variant: 'danger',
                            solid: true,
                        })
                    })
            } else {
                this.$bvToast.toast('A valid Twitch User must be provided before being added.', {
                    title: 'Error',
                    variant: 'danger',
                    solid: true,
                })
            }
        },
        updateEditor: function (id) {
            //
        },
        deleteEditor: function (id, username) {
            if (confirm('Are you sure you want to delete the editor "' + username + '"?')) {
                window.axios
                    .delete(this.route('editor.delete', { id: id, uuid: this.getUser.id }))
                    .then(() => {
                        this.$inertia.visit(this.route(this.route().current()))
                    })
                    .catch(() => {
                        this.$bvToast.toast(
                            'Failed to delete the editor "' + username + '", please try again.',
                            {
                                title: 'Error',
                                variant: 'danger',
                                solid: true,
                            },
                        )
                    })
            }
        },
        validateUser: function () {
            window.twitchAPI
                .get('users?login=' + this.editor.username)
                .then((response) => {
                    this.editor = {
                        ...this.editor,
                        valid: true,
                        id: response.data.users[0]._id,
                    }
                })
                .catch(() => {
                    this.editor = {
                        ...this.editor,
                        valid: false,
                        id: 0,
                    }

                    this.$bvToast.toast('Twitch Username is not valid.', {
                        title: 'Error',
                        variant: 'danger',
                        solid: true,
                    })
                })
        },
        toggleAdd: function () {
            this.isAdding = true
            this.isEditing = false
        },
        listEditors: function () {
            this.isAdding = false
            this.isEditing = false
            this.editor = {
                id: 0,
                username: '',
                role: 3,
                valid: null,
            }
        },
    },
}
</script>
