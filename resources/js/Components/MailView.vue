<script setup>

import { defineExpose , onMounted } from 'vue';


const props = defineProps({
    message: {
        type: Object,
        required: true
    }
})

// onMounted(() => {
//     inlineHtml(props.message);
// });



// expose editor instance and functions to parent component


</script>

<template>
    <div class="message-container">
        <h2>{{ message.subject }}</h2>
        <iframe class="border-none" height="600" width="100%" :srcdoc="message.html_body"></iframe>
        <!-- <div v-html="message.html_body"></div> -->
        <div>
            <ul class="flex gap-2">
                <li v-for="attachment in message.attachments" :key="attachment.id">
                    <a :href="`/storage/` + attachment.path" target="_blank">
                        <img class="size-24 object-cover" :src="`/storage/` + attachment.path" alt="">
                        <p>{{ attachment.name }}</p>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</template>
