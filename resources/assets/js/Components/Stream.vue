<template>
    <div class="featuredVideo mb-4">
        <b-container>
            <b-row>
                <b-col v-if="!isLive">
                    <div
                        class="countdown-counter"
                        id="countdownCount"
                        :data-start="countdown.start"
                        :data-end="countdown.end"
                        :data-name="countdown.name"
                        :data-description="countdown.description"
                    >
                        <span class="countdown-title" id="countdownTitle">
                            {{ soonTM ? 'soonTM' : countdown.name }}
                        </span>
                        <div class="countdown-counter-container" id="countdownContainer">
                            <template v-for="unit in countdownUnits">
                                <div
                                    :id="`countdown-${unit.toLowerCase()}`"
                                    :class="`timeslice timeslice-${unit.toLowerCase()}`"
                                    :key="`timeslice-${unit.toLowerCase()}`"
                                >
                                    <span
                                        :id="`${unit.toLowerCase()}Value`"
                                        class="timeslice-value"
                                    >
                                        0
                                    </span>
                                    <span :id="`${unit.toLowerCase()}Unit`" class="timeslice-unit">
                                        {{ unit }}
                                    </span>
                                </div>
                            </template>
                        </div>
                    </div>
                </b-col>
                <template v-else>
                    <div class="player">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe
                                id="twitchVideoEmbed"
                                class="embed-responsive-item"
                                src="https://player.twitch.tv/?channel=twoangrygamerstv&quality=medium&autoplay=true&muted=false&parent=twoangrygamers.tv&parent=www.twoangrygamers.tv&parent=development.twoangrygamers.tv"
                                allowfullscreen
                                frameborder="0"
                                framespacing="0"
                                scrolling="no"
                                seamless
                            ></iframe>
                        </div>
                    </div>
                    <div class="playerBtns">
                        <b-row>
                            <b-col :sm="6" :md="6">
                                <div class="p-2">
                                    <font-awesome-icon :icon="['fas', 'eye']" />
                                    <span id="viewers">
                                        {{ this.formatNumber(viewers) }}
                                    </span>
                                </div>
                            </b-col>
                            <b-col :sm="6" :md="6" class="text-right">
                                <b-button
                                    v-if="isAuthorized"
                                    :variant="getUser.isFollowing ? 'danger' : 'success'"
                                    @click="handleFollowship"
                                >
                                    {{ getUser.isFollowing ? 'Unfollow' : 'Follow' }}
                                </b-button>
                                <b-button
                                    href="https://www.twitch.tv/twoangrygamerstv"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <font-awesome-icon :icon="['fas', 'comments']" />
                                    Enter Chat
                                </b-button>
                            </b-col>
                        </b-row>
                    </div>
                </template>
            </b-row>
        </b-container>
    </div>
</template>

<script>
import { USER_UPDATE } from '@/Store/Actions/User'
import { mapGetters } from 'vuex'

export default {
    name: 'Stream',
    data: function () {
        return {
            countdownTimer: null,
            countdownUnits: ['Days', 'Hours', 'Minutes', 'Seconds'],
            countdown: {
                start: 0,
                end: 0,
                name: null,
                description: null,
            },
            viewers: 0,
            soonTM: false,
            isLive: false,
        }
    },
    computed: {
        ...mapGetters(['isAuthorized', 'getUser']),
    },
    mounted: function () {
        this.streamCheck()
    },
    methods: {
        streamCheck: function () {
            this.isLive = false
            this.soonTM = false

            window.twitchAPI
                .get('/streams/56964879')
                .then((response) => {
                    if (response.data.stream !== null) {
                        this.isLive = true
                        this.viewers = response.data.stream.viewers
                    } else {
                        this.fetchSchedule()
                    }
                })
                .catch(() => {
                    this.fetchSchedule()
                })
        },
        fetchSchedule: function () {
            window.axios
                .get('/schedule/next')
                .then((response) => {
                    this.countdown = response.data

                    this.updateCountdown()
                })
                .catch((e) => {
                    console.log(e)
                })
        },
        updateCountdown: function () {
            const countdownNow = this.moment.now()
            const countdownStart = this.moment.unix(this.countdown.start)
            const countdownEnd = this.moment.unix(this.countdown.end)

            if (this.moment(countdownNow).isAfter(countdownEnd)) {
                this.streamCheck()
            } else if (this.moment(countdownNow).isAfter(countdownStart)) {
                this.soonTM = true
                this.streamCheck()
            } else {
                const counter = this.moment.duration(countdownStart - countdownNow)

                for (let i = 0; i < this.countdownUnits.length; i++) {
                    const unit = this.countdownUnits[i]
                    const unitLower = unit.toLowerCase()
                    const timeslice = document.getElementById('countdown-' + unitLower)
                    const value = counter[unitLower]()

                    timeslice.childNodes[0].innerText = value
                    timeslice.childNodes[1].innerText =
                        value !== 1 ? unit : unit.substr(0, unit.length - 1)
                }
            }

            if (this.countdownTimer === undefined || this.countdownTimer === null) {
                this.countdownTimer = setInterval(() => {
                    this.updateCountdown()
                }, 1000)
            }
        },
        handleFollowship: function () {
            if (this.isAuthorized) {
                if (this.getUser.isFollowing) {
                    window.twitchAPI
                        .put('/users/' + this.getUser.id + '/follows/channels/56964879')
                        .then(() => {
                            this.$store.commit(USER_UPDATE, {
                                ...this.getUser,
                                isFollowing: true,
                            })
                        })
                        .catch(() => {})
                } else {
                    window.twitchAPI
                        .delete('/users/' + this.getUser.id + '/follows/channels/56964879')
                        .then(() => {
                            this.$store.commit(USER_UPDATE, {
                                ...this.getUser,
                                isFollowing: false,
                            })
                        })
                        .catch(() => {})
                }
            }
        },
    },
}
</script>
