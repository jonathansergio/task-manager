<template>
    <div>
        <h1 class="text-2xl mb-4">Task List</h1>
        <div class="flex gap-2 mb-4">
            <select v-model="status" @change="reload">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
            <select v-model="sort" @change="reload">
                <option value="priority">Sort by Priority</option>
                <option value="created_at">Sort by Created</option>
            </select>
        </div>

        <ul>
            <li v-for="task in store.tasks" :key="task.id" class="mb-2 border-b pb-2">
                <strong>{{ task.title }}</strong> - {{ task.status }} - Priority: {{ task.priority }}
            </li>
        </ul>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useTaskStore } from '@/stores/useTaskStore'

const store = useTaskStore()
const status = ref('')
const sort = ref('priority')

const reload = () => store.fetchTasks(status.value, sort.value)

onMounted(() => {
    reload()
})
</script>
