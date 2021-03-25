<template>
<div>
    <div class="text-center">
        <button class="btn btn-primary d-inline-block my-2" @click="addNewLesson">Create lesson</button>
    </div>

    <ul class="list-group">
        <li class="list-group-item" v-for="lesson in formatLesson" :key="lesson.id">{{lesson.title}}</li>
    </ul>
    <create-lesson></create-lesson>
</div>
</template>

<script>
import CreateLesson from "./children/CreateLesson";

export default {
    name: "Lesson",
    props: ['default_lessons'],
    components: {CreateLesson},
    data(){
        return {
            lesson: this.default_lessons
        }
    },
    computed:{
        formatLesson(){
            return JSON.parse(this.lesson)
        }
    },
    methods:{
        addNewLesson(){
            this.$emit('createLesson')
        }
    }
}
</script>

<style scoped>

</style>
