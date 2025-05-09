import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'

export const useTaskStore = defineStore('tasks', () => {
    const tasks = ref([])

    const fetchTasks = async (status = null, sort = null) => {
        const params = {}
        if (status) params.status = status
        if (sort) params.sort = sort

        const response = await axios.get('/api/tasks', { params })
        tasks.value = response.data.data
    }

    const createTask = async (payload) => {
        const response = await axios.post('/api/tasks', payload)
        tasks.value.push(response.data.data)
    }

    const updateTask = async (id, payload) => {
        const response = await axios.put(`/api/tasks/${id}`, payload)
        const index = tasks.value.findIndex(t => t.id === id)
        tasks.value[index] = response.data.data
    }

    const deleteTask = async (id) => {
        await axios.delete(`/api/tasks/${id}`)
        tasks.value = tasks.value.filter(t => t.id !== id)
    }

    return { tasks, fetchTasks, createTask, updateTask, deleteTask }
})
