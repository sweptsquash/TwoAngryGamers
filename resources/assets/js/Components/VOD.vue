<template>
    <div :class="{ 'd-none': !visible }" :id="`VOD-${service}`">
        <b-row class="my-3">
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
                :show="!loading && videos.length === 0"
            >
                No Videos Found.
            </b-alert>
            <template v-if="videos.length > 0 && !loading">
                <VideoCard
                    v-for="(vod, index) in videos"
                    :key="`VOD-${service}-${index}`"
                    :VODId="vod.id"
                    :title="vod.title"
                    :url="vod.url"
                    :thumbnail="vod.thumbnail"
                    :duration="vod.duration"
                />
            </template>
        </b-row>
        <Paginate
            v-if="totalVODs > 21"
            :isTwitch="isTwitch || isTwitchHighlights"
            :pageSize="21"
            :totalItems="totalVODs"
            @click="handleClick"
        />
    </div>
</template>

<script>
import Paginate from '@/Components/Paginate'
import VideoCard from '@/Components/VideoCard'

export default {
    name: 'VOD',
    components: { Paginate, VideoCard },
    props: {
        isTwitch: {
            default: false,
            type: Boolean,
        },
        isTwitchHighlights: {
            default: false,
            type: Boolean,
        },
        isYoutube: {
            default: false,
            type: Boolean,
        },
        visible: {
            default: false,
            type: Boolean,
        },
    },
    data() {
        return {
            service: 'twitch',
            loading: true,
            videos: [],
            totalVODs: 0,
        }
    },
    mounted: function () {
        this.fetchVODs()
    },
    methods: {
        handleClick: function (page) {
            this.fetchVODs(page)
        },
        fetchVODs: function (offset = 0) {
            this.loading = true

            if (this.videos.length > 0) {
                this.videos = []
            }

            if (this.isTwitch || this.isTwitchHighlights) {
                let requestUrl =
                    '/channels/56964879/videos?limit=21&period=all&sort=time&broadcast_type='

                if (this.isTwitch) {
                    requestUrl += 'archive,upload'
                    this.service = 'twitch'
                } else {
                    requestUrl += 'highlight'
                    this.service = 'twitch-highlights'
                }

                if (offset !== 0) {
                    requestUrl += '&offset=' + offset
                }

                window.twitchAPI
                    .get(requestUrl)
                    .then((response) => {
                        this.totalVODs = parseInt(response.data._total)

                        response.data.videos.forEach((vod) => {
                            let thumbnail = vod.thumbnails.medium

                            if (vod.thumbnails.length > 0) {
                                if (vod.thumbnails.medium[1]) {
                                    thumbnail = vod.thumbnails.medium[1].url
                                } else {
                                    thumbnail = vod.thumbnails.medium[0].url
                                }
                            } else {
                                thumbnail = vod.preview.medium
                            }

                            this.videos.push({
                                id: vod._id,
                                title: vod.title,
                                url: vod.url,
                                thumbnail:
                                    vod.status !== 'recording'
                                        ? thumbnail
                                        : 'https://static-cdn.jtvnw.net/previews-ttv/live_user_twoangrygamerstv-320x180.jpg',
                                duration:
                                    vod.status !== 'recording' ? parseInt(vod.length) : 'Live',
                            })
                        })
                    })
                    .catch(() => {})
                    .then(() => {
                        this.loading = false
                    })
            } else if (this.isYoutube) {
                this.service = 'youtube'

                window.axios
                    .get('/youtube')
                    .then((response) => {
                        response.data.videos.forEach((vod) => {
                            this.videos.push({
                                id: vod.id,
                                title: vod.title,
                                url: vod.url,
                                thumbnail: vod.thumbnail,
                                duration: 0,
                            })
                        })

                        this.totalVODs = response.data.videos.length
                    })
                    .catch(() => {})
                    .then(() => {
                        this.loading = false
                    })
            }
        },
    },
}
</script>
