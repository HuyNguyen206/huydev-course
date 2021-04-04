<template>
    <div class="text-center" :data-vimeo-id="video_id" data-vimeo-width="1200" id="handstick"></div>
</template>

<script>
import Player from "@vimeo/player"
export default {
    props:['video_id', 'next_lesson_url', 'lesson_id'],
    methods:{
        showCompletedLesson(){
            console.log('lesson ended')

            let timerInterval
            Swal.fire({
                title: 'You have completed this lesson',
                html: 'Go to the next lesson in <b></b> milliseconds.',
                timer: 4000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                            const b = content.querySelector('b')
                            if (b) {
                                b.textContent = Swal.getTimerLeft()
                            }
                        }
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    window.location = this.next_lesson_url
                    console.log('I was closed by the timer')
                }
            })

            // const Toast = Swal.mixin({
            //     toast: true,
            //     position: 'top-end',
            //     showConfirmButton: false,
            //     timer: 3000,
            //     timerProgressBar: true,
            //     didOpen: (toast) => {
            //         toast.addEventListener('mouseenter', Swal.stopTimer)
            //         toast.addEventListener('mouseleave', Swal.resumeTimer)
            //     },
            //     onClose: ()=>{
            //         console.log('Popup auto close')
            //         window.location = this.next_lesson_url
            //     }
            // })
            //
            // Toast.fire({
            //     icon: 'success',
            //     title: 'You have completed this lesson'
            // })

            // Swal.fire({
            //     position: 'top-end',
            //     icon: 'success',
            //     title: 'You have completed this lesson',
            //     showConfirmButton: false,
            //     timer: 1500
            // })
        },
        completeLesson(isLastLesson){
            axios.post(`/series/complete-lesson/${this.lesson_id}`)
            .then(res =>{
                console.log('last lesson:'+isLastLesson)
                if(isLastLesson){
                    Swal.fire({
                        icon: 'success',
                        title: 'Congratulation!',
                        text: 'You have complete the series',
                        // footer: '<a href>Why do I have this issue?</a>'
                    })
                }
                else{
                    this.showCompletedLesson()
                }
                console.log('Alrady send complete lesson request')
            })
            .catch(err => {
                alert(err.response.statusText)
            })
        }
    },
    mounted() {
        var player = new Player('handstick');
        player.on('play', ()=>{
            console.log('Video playing')
        })

        player.on('ended', ()=>{
            // if(this.next_lesson_url){
                this.completeLesson(this.next_lesson_url == "")
            // }
            // else{
            //     Swal.fire({
            //         icon: 'success',
            //         title: 'Congratulation!',
            //         text: 'You have complete the series',
            //         // footer: '<a href>Why do I have this issue?</a>'
            //     })
            // }

        })

    },
    name: "Vimeo"
}
</script>

<style scoped>

</style>
