<template>
    <div class="text-center" :data-vimeo-id="video_id" data-vimeo-width="1200" id="handstick"></div>
</template>

<script>
import Player from "@vimeo/player"
export default {
    props:['video_id'],
    mounted() {
        var player = new Player('handstick');
        player.on('play', ()=>{
            console.log('Video playing')
        })

    },
    name: "Vimeo"
}
</script>

<style scoped>

</style>
