<template>
  <div class='container'>
    <p ></p>
    <h1 class='text-center mt-3'>Todo App</h1>
    <p v-if="error.length > 0" class="alert alert-danger">{{ error }}</p>
    <b-button 
          @click="setModalOptions({title: 'Create Todo',url: 'todo', method: 'post'})" 
          v-b-modal.taskModal
          variant="warning">
      + Create new task
    </b-button>
    <div class="d-inline-block ml">
      <button @click="hideCompleted = !hideCompleted" class="ml-3 btn btn-primary">Hide completed tasks</button>
    </div>
    <ToDoModal :task="taskData" button-variant="warning" :options="modalOptions" :resetData="resetTaskData" :tasks="tasks" :updateTask="updateTask"/>
    <ToDoList :errorMesage="this.error" :tasks="tasks" :updateTask="updateTaskHandler"/>
  </div>
</template>

<script>
import ToDoList from './TodoList.vue';
import ToDoModal from './ToDoModal.vue';
import axios from 'axios';

export default {
  name: 'TodoApp',
  data() {
    return {
      tasks: [],
      hideCompleted: false,
      taskData: {
        id: '',
        title: '',
        body: '',
        due_date: '',
        index: ''
      },
      error: '',
      modalOptions: {
        title: 'Create Todo',
        url: 'todo',
        method: 'post'
      }
    };
  },

  watch: {
    hideCompleted() {
      this.getTasks();
    }
  },

  created() {
      this.getTasks();
  }, 

  methods: {
    getTasks() {
      const url = this.$apiUrl+'todo' + (this.hideCompleted ? '?hidecompleted=1' : '');
      axios.get(url)
        .then( response => {
            if (response.status === 200) {
              this.tasks = response.data
            }
            this.error = '';
        })
        .catch(error => {
            this.error = error;
        });
    },

    setModalOptions(options) {
      this.modalOptions = {...options}
    },

    resetTaskData() {
      this.taskData = {
        id: '',
        title: '',
        body: '',
        dueDate: ''
      }
    },

    updateTask(data, index) {
      this.tasks.splice(index, 1, data);
    }, 

    updateTaskHandler(taskData) {
        this.taskData = {...taskData},
        this.setModalOptions({
          title: 'Update Todo',
          url: 'todo/' + taskData.id,
          method: 'put',
          index: taskData.id,
        });
        
        this.$bvModal.show('taskModal');
    }

  },

  components: {
    ToDoList,
    ToDoModal,
  }
}
</script>

<style scoped>
  .ml {
    margin-left: 5px;
  }
</style>