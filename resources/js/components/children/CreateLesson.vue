<template>
    <div>
        <div class="modal fade" id="createLesson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ getTitle }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Lession title"
                                       v-model="form.title" :class="{ 'is-invalid': this.errors.title}">
                                <div class="invalid-feedback" v-if="this.errors.title">
                                    {{ this.errors.title[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Vimeo video id"
                                       v-model="form.video_id" :class="{ 'is-invalid': this.errors.video_id}">
                                <div class="invalid-feedback" v-if="this.errors.video_id">
                                    {{ this.errors.video_id[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" placeholder="Episode number"
                                       v-model="form.episode_number"
                                       :class="{ 'is-invalid': this.errors.episode_number}">
                                <div class="invalid-feedback" v-if="this.errors.episode_number">
                                    {{ this.errors.episode_number[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea rows="5" type="text" class="form-control" placeholder="Description"
                                          v-model="form.description"
                                          :class="{ 'is-invalid': this.errors.description}"></textarea>
                                <div class="invalid-feedback" v-if="this.errors.description">
                                    {{ this.errors.description[0] }}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateLesson" v-if="this.isEdit">Update</button>
                        <button type="button" class="btn btn-primary" @click="addLesson" v-else>Create</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['id'],
    computed:{
        getTitle(){
            if(this.isEdit)
                return 'Update lesson'
            else
                return 'Create lesson'
        }

    },
    methods: {
        addLesson() {
            axios.post(`/admin/${this.id}/lessons`, this.form)
                .then(res => {
                    this.$parent.$emit('created_lesson', res.data.data)
                    $('#createLesson').modal('hide');
                })
                .catch(err => {
                    if (err.response.status == 422) {
                        this.errors = err.response.data.errors
                    } else {
                        alert(err.response.statusText)
                    }
                })
        },
        updateLesson(){
            axios.put(`/admin/${this.id}/lessons/${this.editLessonId}`, this.form)
            .then(res => {
                this.$parent.$emit('update_already', res.data.data)
                $('#createLesson').modal('hide');
            })
            .catch(err => {
                alert(err.response.statusText)
            })
        }
    },
    data() {
        return {
            form: {
                title: '',
                video_id: '',
                description: '',
                episode_number: ''
            },
            errors: [],
            isEdit: false,
            editLessonId:''
        }
    },
    name: "CreateLesson",
    mounted() {
        this.$parent.$on('createLesson', () => {
            console.log('Create lesson from child')
            this.isEdit = false
            this.form = {
                title: '',
                video_id: '',
                description: '',
                episode_number: ''
            }
            $('#createLesson').modal('show');
        }),

        this.$parent.$on('edit_lesson', lesson => {
            this.isEdit = true
            this.editLessonId = lesson.id
            let data = {
                title:lesson.title,
                video_id:lesson.video_id,
                description:lesson.description,
                episode_number:lesson.episode_number
            }
            this.form = data
            $('#createLesson').modal('show');
        })
    }
}
</script>

<style scoped>

</style>
