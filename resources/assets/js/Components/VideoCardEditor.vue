<template>
    <div class="VOD VODEditor">
        <div class="thumbnail" :style="`background-image: url(${thumbnail})`"></div>
        <div class="info">
            {{ title }}
        </div>
        <div class="highlight" @click="handleClick"></div>
        <div class="duration">
            {{ duration }}
        </div>
        <div class="rightBtn" id="addToCollection" @click="handleAddToCollection">
            <font-awesome-icon :icon="['fas', isInBasket(VID) ? 'minus' : 'plus']" />
        </div>
        <a class="rightBtn" :href="video" target="_blank" rel="noopener noreferrer">
            <font-awesome-icon :icon="['fas', 'download']" />
        </a>
    </div>
</template>

<script>
import { EDITOR_UPDATE } from '@/Store/Actions/Editor'
import { mapGetters } from 'vuex'

export default {
    name: 'VideoCard',
    props: {
        VID: {
            required: true,
            type: Number,
        },
        title: {
            required: true,
            type: String,
        },
        thumbnail: {
            required: true,
            type: String,
        },
        duration: {
            required: true,
            type: String,
        },
        video: {
            required: true,
            type: String,
        },
    },
    computed: {
        ...mapGetters(['isInBasket']),
    },
    methods: {
        handleClick: function () {
            this.$emit('click', this.VID)
        },
        handleAddToCollection: function () {
            this.$store.dispatch(EDITOR_UPDATE, this.VID)
        },
    },
}
</script>
