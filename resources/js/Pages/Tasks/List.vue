<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    defineProps({
        tasks: {
            type: Object,
            required: true,
            default: () => ({})
        }
    });

    </script>

    <template>
        <Head title="Dashboard" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between">
                    <span>Tasks List</span>
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-2">
                            <Link :href="route('tasks.create')" class="ml-auto">
                                    <PrimaryButton>Create</PrimaryButton>
                            </Link>
                        </div>
                        <!-- <div class="p-6 bg-white border-b border-gray-200">
                            You're logged in!
                        </div> -->
                        <table class="w-full">
                            <tr>
                                <th class="px-2 text-left">#</th>
                                <th class="px-2 text-left">Job Ref</th>
                                <th class="px-2 text-left">Title</th>
                                <th class="px-2 text-left">Publish Date</th>
                                <th class="px-2 text-right">Action</th>
                            </tr>
                            <tr v-for="task in tasks.data" :key="task.id">
                                <td class="px-2">{{task.id}}</td>
                                <td class="px-2"></td>
                                <td class="px-2">{{task.title}}</td>
                                <td class="px-2">{{task.publish_date}}</td>
                                <td class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="#" class="cursor-pointer"></a>
                                        <a href="#" class="cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>
