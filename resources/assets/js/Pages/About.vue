<template>
    <div></div>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
    name: 'About',
    layout: Layout,
    metaInfo() {
        return {
            title: 'About',
            link: [{ rel: 'canonical', href: 'https://www.twoangrygamers.tv/about' }],
            meta: [
                {
                    property: 'og:title',
                    content: 'About | Two Angry Gamers',
                },
                {
                    name: 'twitter:title',
                    content: 'About | Two Angry Gamers',
                },
            ],
        }
    },
}
</script>
