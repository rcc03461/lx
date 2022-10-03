<script setup>
import { onMounted, ref, watch } from 'vue';

// defineProps([
//     'config',
//     'modelValue'
// ]);

const props = defineProps({
    config: {
        type: Object,
        required: true,
        default: () => ({})
    },
    modelValue: {
        type: Array,
        required: true,
        default: []
    }
});

const emit = defineEmits(['update:modelValue']);

// const input = ref(null);

// watch(props.modelValue, (value) => {
//     console.log('modelValue', value);
// });

// onMounted(() => {
//     if (input.value.hasAttribute('autofocus')) {
//         input.value.focus();
//     }
// });

function duplicateItem( item, index ) {
    // add new item to index + 1 position
    props.modelValue.splice(index + 1, 0, JSON.parse( JSON.stringify( item ) ));
    emit('update:modelValue', props.modelValue);
};

function removeItem( index ) {
    props.modelValue.splice(index, 1);
    emit('update:modelValue', props.modelValue);
};

function addItem() {
    const newMeta = {} ;
    console.log(props.config);
    props.config.columns.forEach((item) => {
        newMeta[item.name] = '';
    });
    emit('update:modelValue', [...props.modelValue, newMeta]);
};

</script>

<template>
    <div>
        <span class="px-2 py-2" @click="addItem"> + </span>
        <table class="w-full">
            <tr>
                <th class="text-left" v-for="column in config.columns" :key="column.name">{{column.label}}</th>
                <th class="text-right">Action</th>
            </tr>
            <tr v-for="(item,index) in modelValue">
                <td v-for="column in config.columns"  @dblclick="duplicateItem(item, index)" >
                    <input class="w-full" v-if="column.type == 'text'" type="text" :name="column.name" v-model="item[column.name]" />
                    <select class="w-full" v-if="column.type == 'select'" :name="column.name" v-model="item[column.name]">
                        <option v-for="option in column.options" :value="option">{{ option }}</option>
                    </select>
                </td>
                <td class="text-right">
                    <span class="float-right cursor-pointer" @click="removeItem(index)"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></span>
                </td>
            </tr>
        </table>
    </div>
    <!-- <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input"> -->
</template>
