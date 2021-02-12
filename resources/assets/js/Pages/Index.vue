<template>
    <div>
        <Stream />
        <b-container>
            <b-row>
                <b-col :xl="9">
                    <b-row class="mb-3">
                        <b-col class="pl-0">
                            <h2 class="mb-0">Latest Content</h2>
                        </b-col>
                        <b-col class="text-right pr-0">
                            <b-dropdown right id="vod-service-dropdown">
                                <template #button-content>
                                    <font-awesome-icon :icon="['fab', VODIcon]" class="mr-1" />
                                    {{ VODService }}
                                </template>
                                <b-dropdown-item @click.prevent="changeVOD('Twitch')">
                                    <font-awesome-icon :icon="['fab', 'twitch']" class="mr-1" />
                                    Twitch
                                </b-dropdown-item>
                                <b-dropdown-item @click.prevent="changeVOD('Twitch Highlights')">
                                    <font-awesome-icon :icon="['fab', 'twitch']" class="mr-1" />
                                    Twitch Highlights
                                </b-dropdown-item>
                                <b-dropdown-item @click.prevent="changeVOD('YouTube')">
                                    <font-awesome-icon :icon="['fab', 'youtube']" class="mr-1" />
                                    YouTube
                                </b-dropdown-item>
                            </b-dropdown>
                        </b-col>
                    </b-row>
                    <VOD :visible="VODService === 'Twitch'" :isTwitch="true" />
                    <VOD :visible="VODService === 'Twitch Highlights'" :isTwitchHighlights="true" />
                    <VOD :visible="VODService === 'YouTube'" :isYoutube="true" />
                </b-col>
                <b-col :xl="3">
                    <div className="mb-3">
                        <a
                            className="twitter-timeline"
                            data-height="605"
                            href="https://twitter.com/2AngryGamers?ref_src=twsrc%5Etfw"
                        >
                            Tweets by 2AngryGamers
                        </a>
                    </div>
                    <div className="mb-3">
                        <iframe
                            src="https://discordapp.com/widget?id=107055937814016000&theme=dark"
                            width="262"
                            height="500"
                            allowtransparency="true"
                            frameBorder="0"
                            id="discordEmbed"
                        ></iframe>
                    </div>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import Stream from '@/Components/Stream'
import VOD from '@/Components/VOD'

export default {
    name: 'Home',
    layout: Layout,
    components: {
        Stream,
        VOD,
    },
    data() {
        return {
            VODService: 'Twitch',
            VODIcon: 'twitch',
        }
    },
    methods: {
        changeVOD: function (service) {
            if (service !== null) {
                this.VODService = service

                if (service === 'Twitch' || service === 'Twitch Highlights') {
                    this.VODIcon = 'twitch'
                } else if (service === 'YouTube') {
                    this.VODIcon = 'youtube'
                }
            }
        },
    },
}
</script>
