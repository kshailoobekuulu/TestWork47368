<template>
    <tr>
        <td>{{ task.title }}</td>
        <td>
            {{ task.body }}
        </td>
        <td>
            {{ task.due_date }}
        </td>
        <td>
           <input type="checkbox" name="status" :checked="task.completed" value="1" @change="completeTask">
        </td>
        <td>
        <a @click="updateTask({...task, index: index, status: task.completed})">
            <span class="fa fa-pen"></span>
        </a>
        </td>
        <td>
        <a @click="deleteTask()">
            <span class="fa fa-trash"></span>
        </a>
        </td>
    </tr> 
</template>

<script>
import axios from 'axios';
    export default {
        name: 'ToDoItem',
        props: {
            task: Object,
            deleteTask: Function,
            updateTask: Function,
            index: Number
        },
        methods: {
            completeTask(e) {
                const status = e.target.value ? true : false;
                const data = {...this.task, status};
                axios.put(this.$apiUrl + 'todo/' + this.task.id, data)
                .then(response => {
                    if(response.status == 200) {
                        this.task.completed = response.data.todo.completed
                    }
                }).catch(() => {
                    alert("Oops something went wrong while completing a task. Try again please");
                });
            }
        }
    }
</script>