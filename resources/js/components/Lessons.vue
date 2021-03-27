<template>
<div>
    <div class="text-center">
        <button class="btn btn-primary d-inline-block my-2" @click="addNewLesson">Create lesson</button>
    </div>

    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between" v-for="(lesson, index) in lessons" :key="lesson.id">
            <span>
                   {{lesson.title}}
            </span>
         <div class="btn-group">
             <a href="" class="btn btn-primary" @click.prevent="editLesson(lesson)">Edit</a>
             <a href="" class="btn btn-danger" @click.prevent="deleteLesson(lesson.id, index)">Delete</a>
         </div>
        </li>
    </ul>
    <create-lesson :id="id"></create-lesson>
</div>
</template>

<script>
import CreateLesson from "./children/CreateLesson";

export default {
    name: "Lesson",
    props: ['default_lessons', 'id'],
    components: {CreateLesson},
    mounted() {
        this.$on('created_lesson', (lesson) => {
            console.log(lesson)
            this.lessons.push(lesson)
        })

        this.$on('update_already', lesson => {
          let index =  this.lessons.findIndex(lessonIn => {
                return lessonIn.id == lesson.id
            })
            this.lessons.splice(index, 1, lesson)
        })
    },
    data(){
        return {
            lessons: JSON.parse(this.default_lessons)
        }
    },
    computed:{
        // formatLesson(){
        //    return JSON.parse(this.lesson)
        // }
    },
    methods:{
        editLesson(lesson){
          this.$emit('edit_lesson', lesson)
        },
        addNewLesson(){
            this.$emit('createLesson')
        },
        deleteLesson(id, index){
            if(confirm('Are you sure to delete this lesson?')){
                axios.delete(`/admin/${this.id}/lessons/${id}`)
                    .then(res => {
                      this.lessons.splice(index, 1)
                    })
                    .catch(err => {
                        alert(err.response.statusText)
                    })
            }

        }
    }
}
</script>

<style scoped>

</style>
