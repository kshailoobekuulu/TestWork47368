<template>
    <table class="table table-boarded mt-5" v-if="this.tasks.length > 0" >
        <thead>
            <th scope="col">Task</th>
            <th scope="col">Description</th>
            <th scope="col">dueDate</th>
            <th scope="col">Completed</th>
            <th scope="col text-center">Edit</th>
            <th scope="col text-center">Delete</th>
        </thead>
        <tbody>
            <ToDoItem
                v-for="(task, index) in this.tasks" 
                :key="task.id"
                :index="index"
                :task="task"
                :deleteTask="() => deleteTask(index)"
                :updateTask="updateTask"
            />
        </tbody>
    </table>
    <h2 v-else class="mt-5">You don't have any tasks</h2>
</template>
<script>
import ToDoItem from './ToDoItem.vue';
import axios from 'axios';
export default {
    name: 'ToDoList',
    props: {
        errorMessage: String,
        tasks: Array,
        updateTask: Function,
    },

    components: {
        ToDoItem
    },

    methods: {
        deleteTask(index) {
            axios.delete(this.$apiUrl + 'todo/' + this.tasks[index].id)
            .then( response => {
                if (response.status === 200 && response.data.success === true) {
                    this.tasks.splice(index, 1);
                } else {
                    this.errorMessage = "Something went wrong";
                }
            });
        }
    },
    
    
};
</script>
