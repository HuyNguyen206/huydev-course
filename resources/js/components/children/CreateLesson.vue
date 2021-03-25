<template>
    <div>
        <div class="modal fade" id="createLesson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add new lesson</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Lession title"
                                       v-model="form.title">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Vimeo video id"
                                       v-model="form.video_id">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" placeholder="Episode number"
                                       v-model="form.episode_number">
                            </div>
                            <div class="form-group">
                                <textarea rows="5" type="text" class="form-control" placeholder="Description"
                                          v-model="form.description"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="addLesson">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods:{
      addLesson(){
          axios.post(`admin/{series_by_id}/lessons`)
      }
    },
    data(){
      return {
          form:{
              title:'',
              video_id:'',
              description: '',
              episode_number:''
          }
      }
    },
    name: "CreateLesson",
    mounted() {
        this.$parent.$on('createLesson', () => {
            console.log('Create lesson from child')
            $('#createLesson').modal('show');
        })
    }
}
</script>

<style scoped>

</style>
