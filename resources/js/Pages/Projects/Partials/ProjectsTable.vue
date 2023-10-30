<template>
    <div v-if="projects.data.length" class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row-reverse pr-5">
            <button class="mr-1 mb-1 px-4 py-3 text-sm leading-4 font-semibold text-sm bg-slate-500 hover:bg-slate-300 text-white rounded shadow-sm" 
                @click="showEditModal()"> New Project </button>
        </div>
        <div class="table-auto bg-white overflow-x-auto shadow-sm rounded">
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Value</th>
                <th>Status</th>
                <th>Creator</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(project, index) in projects.data" :key="index" class="hover:bg-gray-200">
                <td>{{ project.name }}</td>
                <td>{{ project.start_date }}</td>
                <td>{{ project.end_date }}</td>
                <td>{{ project.value }}</td>
                <td>{{ project.status }}</td>
                <td>{{ project.creator.name }}</td>
                <td>{{ project.created_at }}</td>
                <td>{{ project.updated_at }}</td>
                <td>
                    <div class="flex justify-center" role="group">
                        <button 
                            class="px-4 p-2 font-semibold text-sm bg-gray-600 hover:bg-gray-500 text-white rounded-l-lg shadow-sm"
                            @click="showEditModal(project)"> Edit </button>
                        <button class="px-4 p-2 font-semibold text-sm bg-red-600 hover:bg-red-400 text-white rounded-r-lg shadow-sm" 
                            @click="showDeleteModal(project.id)"> Delete </button>
                    </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="flex justify-center mt-4 hidden sm:flex">
            <div v-for="(link, index) in projects.links" :key="index">
                <Link 
                    v-if="link.url"
                    :href="link.url" 
                    v-html="link.label"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-700 border rounded"
                    :class="link.active ? 'bg-white' : ''"
                />
            </div>
        </div>
        <div class="flex justify-center mt-4 sm:hidden">
                <Link 
                    :href="projects.prev_page_url" 
                    v-html="'Previous'"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-700 border rounded"
                    :class="projects.prev_page_url ? 'bg-white' : ''"
                />
                <Link 
                    :href="projects.next_page_url" 
                    v-html="'Next'"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-700 border rounded"
                    :class="projects.next_page_url ? 'bg-white' : ''"
                />
        </div>
    </div>
    <div v-else class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    There are no registered projects yet.
                    <div class="add-project-button pt-4">
                        <button class="mr-1 mb-1 px-4 py-3 text-sm leading-4 font-semibold text-sm bg-slate-500 hover:bg-slate-300 text-white rounded shadow-sm" 
                            @click="showEditModal()"> Add a new project! </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- edit -->
    <Modal :show="showingEditModal" @close="closeModal">
        <div class="p-6">
            <form @submit.prevent="updateProject" class="mt-6 space-y-6">
                <div>
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="formEdit.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="formEdit.errors.name" />
                </div>
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <InputLabel for="start_date" value="Start Date" />
                        <TextInput
                            id="start_date"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="formEdit.start_date"
                            required
                            autofocus
                            autocomplete="start_date"
                        />
                        <InputError class="mt-2" :message="formEdit.errors.name" />
                    </div>
                    <div class="w-1/2">
                        <InputLabel for="end_date" value="End Date" />
                        <TextInput
                            id="end_date"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="formEdit.end_date"
                            required
                            autofocus
                            autocomplete="end_date"
                        />
                        <InputError class="mt-2" :message="formEdit.errors.end_date" />
                    </div>
                </div>
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <InputLabel for="name" value="Value" />
                        <TextInput
                            id="value"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="formEdit.value"
                            pattern="[0-9]+(\.[0-9]+)?"
                            required
                            autofocus
                            autocomplete="value"
                        />
                        <InputError class="mt-2" :message="formEdit.errors.value" />
                    </div>
                    <div class="w-1/2">
                        <InputLabel for="status" value="Status" />
                        <select :id="id" v-model="formEdit.status"
                            class="mt-1 block w-full 
                                border-gray-300 

                                focus:border-indigo-500 

                                focus:ring-indigo-500 

                                rounded-md shadow-sm">
                            <option value="" disabled>Select an option</option>
                            <option v-for="(option, index) in selectOptions" :key="index" :value="option.value">{{ option.label }}</option>
                        </select>
                        <InputError v-if="formEdit.errors.status" class="mt-2" :message="formEdit.errors.status" />
                    </div>
                </div>
                <div class="mt-1 flex justify-end">
                    <SecondaryButton @click="closeModal">Cancel</SecondaryButton>

                    <DangerButton class="ml-3">Save</DangerButton>
                </div>
            </form>
        </div>
        
    </Modal>
    <!-- delete -->
    <Modal :show="showingDeleteModal" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Are you sure you want to delete this project?
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Once this project is deleted, all of its resources and data will be permanently deleted. Please
                enter your password to confirm you would like to permanently delete your account.
            </p>

            <div class="mt-6">
                <InputLabel for="password" value="Password" class="sr-only" />
                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="formDelete.password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="Password"
                    @keyup.enter="deleteProject(formDelete.id)"
                />
                <InputError v-if="formDelete.errors.password" class="mt-2" :message="formDelete.errors.password" />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': formDelete.processing }"
                    :disabled="formDelete.processing"
                    @click="deleteProject"
                >
                    Delete Project
                </DangerButton>
            </div>
        </div>
        
    </Modal>
</template>
  
<script setup>
import Modal from '@/components/Modal.vue';
import DangerButton from '@/components/DangerButton.vue';
import SecondaryButton from '@/components/SecondaryButton.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import TextInput from '@/components/TextInput.vue';
import { useForm, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    projects: Object
});

const showingEditModal = ref(false);
const showingDeleteModal = ref(false);
const passwordInput = ref(null);
const formDelete = useForm({
    id: '',
    password: '',
});
const formEdit = useForm({
    id: '',
    name: '', 
    start_date: '', 
    end_date: '', 
    value: '', 
    status: '',
    creator_id: ''
});
const selectOptions = [
{ label: 'Active', value: 'Active' },
{ label: 'Inactive', value: 'Inactive' }
];

const showEditModal = (project = null) => {
    showingEditModal.value = true;
    
    if (project) {
        formEdit.id = project.id;
        formEdit.name = project.name;
        formEdit.start_date = project.start_date;
        formEdit.end_date = project.end_date;
        formEdit.value = project.value;
        formEdit.status = project.status;
    }
};
const showDeleteModal = (projectId) => {
    showingDeleteModal.value = true;
    formDelete.id = projectId;
};
const closeModal = () => {
    showingEditModal.value = false;
    showingDeleteModal.value = false;

    formEdit.reset();
    formDelete.reset();
};

const createProject = () => {
    formEdit.creator_id = usePage().props.auth.user.id
    formEdit.post(route('project.store'), {
        preserveState: true,
        onSuccess: () => closeModal(),
        onFinish: () => formEdit.reset(),
    });
};
const updateProject = () => {
    if (!formEdit.id) {
        createProject();
        return;
    }
    formEdit.patch(route('project.update'), {
        preserveState: true,
        onSuccess: () => closeModal(),
        onFinish: () => formEdit.reset(),
    });
};
const deleteProject = () => {
    formDelete.delete(route('project.destroy'), {
        preserveState: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
    });
};

</script>

<style scoped>
  .table-container {
    margin-top: 20px;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
  }
  
  th {
    background-color: #f2f2f2;
  }

  .add-project-button {
    display: flex;
    justify-content: center;
  }
</style>
  