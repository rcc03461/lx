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
        <section v-html="message.html_body"></section>
        <section>
            <ul>
                <li v-for="attachment in message.attachments" :key="attachment.id">

                <img class="size-10" :src="attachment.path" alt=""></li>
            </ul>
        </section>
    </div>
</template>
