<template>
    <a
        :href="url"
        class="VOD"
        :id="`VOD-${VODId}`"
        target="_blank"
        rel="noopener noreferrer"
        :title="title"
    >
        <div class="thumbnail" :style="`background-image: url(${thumbnail})`">
            <div class="duration">
                {{
                    typeof duration === 'number'
                        ? moment.unix(duration).format('H:mm:ss')
                        : duration
                }}
            </div>
        </div>
        <div class="info">
            {{ title }}
        </div>
    </a>
</template>

<script>
export default {
    name: 'VideoCard',
    props: {
        VODId: {
            required: true,
            type: String,
        },
        url: {
            required: true,
            type: String,
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
            type: [String, Number],
        },
    },
}
</script>
