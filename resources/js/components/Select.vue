<template>
    <div>
        <select :id="id" v-model="formEdit.status"
            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="" disabled>Select an option</option>
            <option v-for="(option, index) in options" :key="index" :value="option.value">{{ option.label }}</option>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        options: {
            type: Array,
            required: true,
        },

    },
    data() {
        return {
            selectedOption: '',
        };
    },
};
</script>

<style scoped></style>

