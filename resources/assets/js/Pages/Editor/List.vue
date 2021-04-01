<template>
    <b-container>
        <b-row class="my-4">
            <b-col :cols="6">
                <h2>Editor Portal</h2>
            </b-col>
            <b-col :cols="6" class="text-right">
                <b-button variant="primary" v-if="getBasket.length > 0" @click="downloadCollection">
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
        <b-modal id="videoModal" v-model="showVideoModal">Hello World</b-modal>
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
            videoModal: {},
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
                    // TODO: Display Error
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
        toggleEditors: function () {
            // TODO: Toggle Editor Management Modal
        },
        downloadCollection: function () {
            // TODO: Download ZIP of Videos
        },
    },
}
</script>
