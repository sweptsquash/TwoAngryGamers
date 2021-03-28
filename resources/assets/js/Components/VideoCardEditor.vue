<template>
    <div class="VOD">
        <div class="thumbnail" :style="`background-image: url(${thumbnail})`">
            <div class="duration">
                {{ duration }}
            </div>
            <div id="addToCollection">
                <font-awesome-icon :icon="['fas', 'plus']" />
            </div>
            <a :href="video" target="_blank" rel="noopener noreferrer">
                <font-awesome-icon :icon="['fas', 'download']" />
            </a>
        </div>
        <div class="info">
            {{ title }}
        </div>
    </div>
</template>

<script>
export default {
    name: 'VideoCard',
    props: {
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
    },
    methods: {
        handleClick: function (id) {
            this.$emit('click', id)
        },
    },
}
</script>
