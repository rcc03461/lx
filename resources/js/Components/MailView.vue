<script setup>

import { defineExpose , onMounted,  computed } from 'vue';
import { fileThumbnail } from '@/utils/doctype'
import MailContact from './MailContact.vue'

const props = defineProps({
    message: {
        type: Object,
        required: true
    }
})

// expose editor instance and functions to parent component

const message_injected_body = computed(() => injectStyle(props.message.html_body, `<style>
p {
    margin: 0;
}
</style>`) )

function injectStyle(email_body, style){
    // console.log(email_body, "html");
    return style + email_body;
}

// onMounted(() => {
//     console.log(props.message);

// })


</script>

<template>
    <div class="message-container">
        <!-- <pre>
            {{ message }}
        </pre> -->
        <p class="message-code text-gray-500 text-sm">{{ message.message_id }}</p>
        <h2 class="message-subject">{{ message.subject }}</h2>
        <div class="message-contact">
            <MailContact v-model="message.to" title="To" :editable="false"/>
            <MailContact v-model="message.cc" title="cc" :editable="false"/>
            <MailContact v-model="message.bcc" title="bcc" :editable="false"/>
        </div>
        <div class="message-body">
            <!-- sandbox="allow-scripts" -->
            <iframe
            class="border-none no-scrollbar"
            v-if="message.html_body"
            width="100%"
            :srcdoc="message_injected_body"
            onload="this.style.height=(this.contentWindow.document.body.scrollHeight+50)+'px';this.contentWindow.document.body.style.overflow='hidden';"></iframe>
            <div v-else class="border-none whitespace-pre-line no-scrollbar" v-html="message.text_body"></div>
        </div>
        <!-- <div v-html="message.html_body"></div> -->
        <div class="message-attachments">
            <ul class="flex gap-2">
                <li class="size-28 border rounded " v-for="attachment in message.attachments" :key="attachment.id">
                    <a :href="'/storage/' + attachment.path" target="_blank" :download="attachment.name || 'No Name'" :title="attachment.name || 'No Name'">
                        <div class="text-gray-500 line-clamp-1 text-ellipsis overflow-hidden">{{ attachment.name || 'No Name' }}</div>
                        <img class="size-24 object-contain" :src="'' + fileThumbnail(attachment.path)" alt="">
                    </a>
                </li>
            </ul>
        </div>

    </div>
</template>

<style>

.message-container{
    /* padding: 1rem; */
    /* background-color: hsl(0, 0%, 97%); */
}

    .message-container .message-code,
    .message-container .message-subject,
    .message-container .message-contact,
    .message-container .message-body,
    .message-container .message-attachments
    {
        padding: 1rem;
        background-color: hsl(0, 0%, 97%);
        border-radius: 0.5rem;
        box-shadow: 0 0 0.2rem rgba(0,0,0,0.3);
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

</style>
