<template>
    <div>
        <Stream />
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import Stream from '@/Components/Stream'

export default {
    name: 'Home',
    layout: Layout,
    components: {
        Stream,
    },
}
</script>
