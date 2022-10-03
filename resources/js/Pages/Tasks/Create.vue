<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

    import TextareaInput from '@/Components/TextareaInput.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import InputError from '@/Components/InputError.vue';
    import TableInput from '@/Components/TableInput.vue';

    const form = useForm({
        client_id: 1,
        job_ref: '',
        title: '',
        description: '',
        remark: '',
        publish_date: '',
        meta:[
            {
                content: '',
                direction: 'C > E'
            }
        ]
    });

    const submit = () => {
        // console.log(form, form.get('meta'));
        form.post(route('tasks.store'), {
            // onFinish: () => form.reset('password'),
        });
    };

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

                    <Link :href="route('tasks.index')" class="ml-auto my-8 px-y">
                        <PrimaryButton>
                            Back
                        </PrimaryButton>
                    </Link>

                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="client" value="Client" />
                            <TextInput id="client" type="text" class="mt-1 block w-full" v-model="form.client_id" required />
                            <InputError class="mt-2" :message="form.errors.client_id" />
                        </div>
                        <div>
                            <InputLabel for="ref" value="Ref" />
                            <TextInput id="ref" type="text" class="mt-1 block w-full" v-model="form.ref" />
                            <InputError class="mt-2" :message="form.errors.job_ref" />
                        </div>
                        <div>
                            <InputLabel for="title" value="Title" />
                            <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" required />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>
                        <div>
                            <InputLabel for="description" value="Deacription" />
                            <TextareaInput id="description" type="text" class="mt-1 block w-full" v-model="form.description" />
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>
                        <div>
                            <InputLabel for="remark" value="Remark" />
                            <TextareaInput id="remark" type="text" class="mt-1 block w-full" v-model="form.remark"  />
                            <InputError class="mt-2" :message="form.errors.remark" />
                        </div>
                        <div>
                            <InputLabel for="publishdate" value="Publish Date" />
                            <TextInput id="publishdate" type="date" class="mt-1 block w-full" v-model="form.publish_date" />
                            <InputError class="mt-2" :message="form.errors.publish_date" />
                        </div>

                        <div>
                            <InputLabel for="translationsummary" value="Translation Summary" />
                            <TableInput id="translationsummary" class="mt-1 block w-full" v-model="form.meta" :config="{
                                columns: [
                                    { name: 'content', label: 'Content', type: 'text' },
                                    { name: 'direction', label: 'Direction', type: 'select', options: ['E > C', 'C > E', 'Cross-Translation', 'Client'] }
                                ]}" />
                            <InputError class="mt-2" :message="form.errors.publish_date" />
                        </div>


                        <div class="flex items-center justify-center mt-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Submit
                            </PrimaryButton>
                        </div>

                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    </template>
