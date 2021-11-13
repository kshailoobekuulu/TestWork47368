<template>
  <div id="app">
    <TodoApp msg="Welcome to Your Vue.js App"/>
  </div>
</template>

<script>
import TodoApp from './components/TodoApp.vue'

export default {
  name: 'App',
  components: {
    TodoApp
  }
}
</script>
