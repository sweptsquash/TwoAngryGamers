<template>
    <b-container>
        <b-row class="my-4">
            <b-col :cols="6">
                <h2>Editor Portal</h2>
            </b-col>
            <b-col :cols="6" class="text-right">
                <b-button
                    variant="primary"
                    v-if="getBasket.length > 0 && getUser.permissions.includes('Can Download')"
                    :href="this.route('videos.collection', { ids: this.getBasket.join() })"
                >
                    <font-awesome-icon :icon="['fas', 'download']" />
                    Download Collection
                </b-button>
                <b-button
                    variant="primary"
                    v-if="isAuthorized && getUser.permissions.includes('List Editors')"
                    @click="toggleEditors"
                >
                    <font-awesome-icon :icon="['fas', 'users']" />
                    Manage Editors
                </b-button>
            </b-col>
        </b-row>
        <b-row class="mb-4">
            <b-col :cols="12" class="text-center" v-if="loading">
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
                <p>Loading Videos...</p>
            </b-col>
            <b-alert
                variant="danger"
                class="text-center flex-fill"
                :show="totalVideos === 0 && !loading"
            >
                No Videos Found.
            </b-alert>
            <template v-if="totalVideos > 0 && !loading">
                <VideoCard
                    v-for="(video, index) in videos"
                    :key="`Video-${index}`"
                    :VID="video.id"
                    :title="video.title"
                    :thumbnail="video.thumbnail"
                    :video="video.video"
                    :duration="video.duration"
                    @click="handleView"
                />
            </template>
        </b-row>
        <Paginate
            v-if="totalVideos > 15"
            :pageSize="15"
            :totalItems="totalVideos"
            @click="handleClick"
        />
        <b-modal id="videoModal" size="lg" v-model="showVideoModal" :title="videoModal.title">
            <b-embed
                type="video"
                aspect="16by9"
                controls
                :poster="`/images/thumbnails/${videoModal.thumbnail}`"
            >
                <source :src="`/api/videos/${videoModal.id}/stream`" type="video/mp4" />
            </b-embed>

            <table class="table table-bordered mt-4">
                <tbody>
                    <tr>
                        <th scope="row">Created:</th>
                        <td>{{ videoModal.created }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Author:</th>
                        <td>{{ videoModal.author }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Duration:</th>
                        <td>{{ videoModal.duration }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Filename:</th>
                        <td>{{ videoModal.filename }}</td>
                    </tr>
                </tbody>
            </table>

            <template #modal-footer>
                <b-button
                    variant="primary"
                    v-if="getUser.permissions.includes('Can Download')"
                    :href="`/api/videos/${videoModal.id}/download`"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <font-awesome-icon :icon="['fas', 'download']" />
                    Download
                </b-button>
                <b-button
                    variant="danger"
                    v-if="getUser.permissions.includes('Delete Videos')"
                    @click="deleteVideo(videoModal.id)"
                >
                    <font-awesome-icon :icon="['fas', 'trash']" />
                    Delete
                </b-button>
                <b-button variant="primary" @click="showVideoModal = false">
                    <font-awesome-icon :icon="['fas', 'times']" />
                    Close
                </b-button>
            </template>
        </b-modal>

        <b-modal
            id="editorModal"
            size="lg"
            v-model="showEditorModal"
            :title="modalTitle"
            v-if="
                getUser.permissions.includes('Create Editors') ||
                getUser.permissions.includes('Edit Editors')
            "
        ></b-modal>
    </b-container>
</template>

<script>
import { mapGetters } from 'vuex'
import Layout from '@/Shared/Layout'
import Paginate from '@/Components/Paginate'
import VideoCard from '@/Components/VideoCardEditor'

export default {
    name: 'EditorList',
    layout: Layout,
    components: { Paginate, VideoCard },
    data() {
        return {
            loading: true,
            videos: [],
            totalVideos: 0,
            showVideoModal: false,
            showEditorModal: false,
            modalTitle: 'Editors',
            isEditting: false,
            videoModal: {
                id: 0,
                title: null,
                author: null,
                created: null,
                duration: null,
                filename: null,
            },
        }
    },
    computed: {
        ...mapGetters(['isAuthorized', 'getUser', 'getBasket']),
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
                            this.fetchVideos()
                        } else {
                            this.$inertia.visit(this.route('editor.denied'))
                        }
                    }
                } else {
                    this.$inertia.visit(this.route('editor.login'))
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
            this.fetchVideos()
        }
    },
    methods: {
        handleView: function (id) {
            window.axios
                .post(this.route('videos.show', { id: id }), { uuid: this.getUser.id })
                .then((response) => {
                    this.showVideoModal = true
                    this.videoModal = response.data.data
                })
                .catch(() => {
                    this.$bvToast.toast('Failed to load video information, please try again.', {
                        title: 'Error',
                        variant: 'danger',
                        solid: true,
                    })
                })
        },
        handleClick: function (page) {
            this.fetchVideos(page)
        },
        fetchVideos: function (offset = null) {
            if (this.videos.length > 0) {
                this.videos = []
            }

            this.loading = true

            window.axios
                .post(this.route('videos.list', { page: offset }), { uuid: this.getUser.id })
                .then((response) => {
                    this.totalVideos = response.data.meta.total

                    response.data.data.forEach((video) => {
                        this.videos.push({
                            id: video.id,
                            title: video.title,
                            author: video.author,
                            created: video.created,
                            duration: video.duration,
                            thumbnail: '/images/thumbnails/' + video.thumbnail,
                            video: '/api/videos/' + video.id + '/download',
                        })
                    })
                })
                .catch(() => {
                    this.totalVideos = 0
                })
                .then(() => {
                    this.loading = false
                })
        },
        deleteVideo: function (id) {
            if (confirm('Are you sure you want to delete this video?')) {
                window.axios
                    .delete(this.route('videos.delete', { id: id, uuid: this.getUser.id }))
                    .then(() => {
                        this.$inertia.visit(this.route(this.route().current()))
                    })
                    .catch(() => {
                        this.$bvToast.toast('Failed to delete the video, please try again.', {
                            title: 'Error',
                            variant: 'danger',
                            solid: true,
                        })
                    })
            }
        },
        toggleEditors: function () {
            this.showEditorModal = !this.showEditorModal
        },
    },
}
</script>
