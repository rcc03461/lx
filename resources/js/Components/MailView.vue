<script setup>

import { defineExpose , onMounted } from 'vue';
import { fileThumbnail } from '@/utils/doctype'
import MailContact from './MailContact.vue'
const props = defineProps({
    message: {
        type: Object,
        required: true
    }
})

// expose editor instance and functions to parent component


</script>

<template>
    <div class="message-container">
        <!-- <pre>
            {{ message }}
        </pre> -->
        <p class="text-gray-500 text-sm">{{ message.message_id }}</p>
        <h2>{{ message.subject }}</h2>
        <div>
            <MailContact v-model="message.to" title="To" :editable="false"/>
            <MailContact v-model="message.cc" title="cc" :editable="false"/>
            <MailContact v-model="message.bcc" title="bcc" :editable="false"/>
        </div>
        <div>
            <iframe v-if="message.html_body" class="border-none no-scrollbar" width="100%" :srcdoc="message.html_body" onload="this.style.height=(this.contentWindow.document.body.scrollHeight+50)+'px';this.contentWindow.document.body.style.overflow='hidden';"></iframe>
            <div v-else class="border-none whitespace-pre-line no-scrollbar" v-html="message.text_body"></div>
        </div>
        <!-- <div v-html="message.html_body"></div> -->
        <div class="mt-4 w-full bg-white">
            <hr class="my-2">
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
