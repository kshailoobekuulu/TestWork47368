<template>
  <div>
    <div>
      <b-modal id="taskModal" :title="options.title" ok-title="Submit" @cancel="resetData" @ok="createOrUpdateTask">
        <p v-for="(error, index) in errors" :key="index" class="alert alert-danger mt-1 mb-1">{{ error }}</p>
        <p class="my-4">
            <input v-model="task.title" type="text" placeholder="Title" class="form-control mb-2">
            <textarea v-model="task.body" cols="10" rows="10" placeholder="Body" class="form-control mt-2 mb-2"></textarea>
            <label for="date">Due Date</label>
            <input v-model="task.due_date" type="date" class="form-control" id="date">
        </p>
      </b-modal>
    </div>    
  </div>
</template>
<script>
import axios from "axios"


export default({
    name: 'ToDoModal',
    props: {
        task: Object,
        options: Object,
        resetData: Function,
        tasks: Array,
        updateTask: Function,
    }, 
    data() {
        return {
            errors: []
        }
    },
    
    methods: {
        createOrUpdateTask(bvModalEvt) {
            bvModalEvt.preventDefault();
            if (this.options.method == 'post') {
                axios.post(this.$apiUrl + this.options.url, this.task)
                .then(response => {
                    if (response.status == 201) {
                        this.$bvModal.hide('taskModal');
                        this.resetData();
                        this.tasks.unshift(response.data.todo);
                        this.errors = [];
                    }
                })
                .catch(error => {
                    this.errors = [];
                    Object.values(error.response.data.errors).forEach(error => {
                        this.errors.push(error[0]);
                    });
                })
            } else {
                axios.put(this.$apiUrl + this.options.url, this.task)
                .then(response => {
                    if (response.status == 200) {
                        this.$bvModal.hide('taskModal');
                        this.resetData();
                        this.updateTask(response.data.todo, this.task.index);
                        this.errors = [];
                    }
                })
                .catch(error => {
                    this.errors = [];
                    Object.values(error.response.data.errors).forEach(error => {
                        this.errors.push(error[0]);
                    });
                })
            }
        },
    }
})
</script>
