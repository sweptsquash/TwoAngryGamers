<template>
    <div>
        <Stream />
        <b-container>
            <b-row>
                <b-col :xl="9">
                    <b-row>
                        <b-col>
                            <h2>Latest Content</h2>
                        </b-col>
                        <b-col class="text-right">
                            <b-dropdown right id="vod-service-dropdown">
                                <template #button-content>
                                    Twitch
                                </template>
                                <b-dropdown-item>Twitch</b-dropdown-item>
                                <b-dropdown-item>Twitch Highlights</b-dropdown-item>
                                <b-dropdown-item>YouTube</b-dropdown-item>
                            </b-dropdown>
                        </b-col>
                    </b-row>
                    <VOD :visible="VODService === 'twitch'" :isTwitch="true" />
                    <VOD :visible="VODService === 'twitchhighlights'" :isTwitchHighlights="true" />
                    <VOD :visible="VODService === 'youtube'" :isYoutube="true" />
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
            VODService: 'twitch',
        }
    },
}
</script>
