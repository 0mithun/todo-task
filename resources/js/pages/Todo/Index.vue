<template>
    <div>
        <div class="mb-5">
            <router-link class="ml-auto submit-btn w-[150px]" :to="{name: 'todo.create'}">Add new Todo</router-link>
        </div>
        <div>
            <ul role="list" class="divide-y divide-gray-100">
                <li class="flex justify-between gap-x-6 p-5  bg-gray-100">
                    <div class="flex w-4/12">
                        <p class="text-sm/6 font-semibold text-gray-900">Title</p>
                    </div>
                    <div class="flex w-8/12">
                        <p class="text-sm/6 font-semibold text-gray-900">Body</p>
                    </div>
                    <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        Action
                    </div>
                </li>
                <li class="flex justify-between gap-x-6 py-5" v-for="todo in todos" :key="todo.id">
                    <div class="flex w-4/12">
                        <p class="text-sm/6 font-semibold text-gray-900">{{ todo.title }}</p>
                    </div>
                    <div class="flex w-6/12">
                        <p class="text-sm/6 font-semibold text-gray-900">{{ todo.body }}</p>
                    </div>
                    <div class="flex w-2/12 justify-end gap-3">
                        <span class="cursor-pointer" @click="edit(todo)">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                <path d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                <polygon fill="none" points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                </g>
                            </svg>
                        </span>

                        <span class="cursor-pointer" @click="deleteEmployee(todo)">
                            <svg width="26px" height="26px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </span>
                        <span class="cursor-pointer" v-if="!todo.status" @click="markAsComplete(todo)">
                            <svg fill="#000000" height="26px" width="26px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 490.05 490.05" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M418.275,418.275c95.7-95.7,95.7-250.8,0-346.5s-250.8-95.7-346.5,0s-95.7,250.8,0,346.5S322.675,513.975,418.275,418.275
                                            z M157.175,207.575l55.1,55.1l120.7-120.6l42.7,42.7l-120.6,120.6l-42.8,42.7l-42.7-42.7l-55.1-55.1L157.175,207.575z"/>
                                    </g>
                                </g>
                            </svg>
                        </span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</template>

<script setup>
import { ref, inject, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
    const emitter = inject("emitter");
    const todos = ref([])

    const vRouter = useRouter()
    const vRoute = useRoute()

   const getTasks = async ()=> {
    try {
        const {data} = await axios.get(route('todos.index'))
        todos.value = data.data;
    } catch (error) {
        console.log(error)
    }
   }

   const edit = (todo)=> {
    vRouter.push({name: 'todo.edit', params: {id: todo.id}})
   }

    const deleteEmployee = async(todo) =>{
        if(confirm("Are you sure?")) {
            try {
                await axios.delete(route('todos.destroy', {todo: todo.id}))
                emitter.emit(`show-success-notification`, "Todo successfully deleted");

                vRouter.push({ query: {
                    _hash: new Date().getTime(),
                } });

            } catch (error) {
                console.log(error)
            }
        }

    }

    const markAsComplete = async(todo) =>{
        if(confirm("Are you sure?")) {
            try {
                await axios.patch(route('todo.mark-as-complete', {todo: todo.id}))
                emitter.emit(`show-success-notification`, "Todo mark as completed");

                vRouter.push({ query: {
                    _hash: new Date().getTime(),
                } });

            } catch (error) {
                console.log(error)
            }
        }

    }

    watch(
        () => vRoute.fullPath,
        async () => {
            getTasks();
        }
    );

   getTasks()
</script>

<style lang="scss" scoped>

</style>
