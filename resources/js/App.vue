<script setup>
import { ref, defineEmits, defineProps, onMounted } from 'vue';
import Drawer from './Components/Drawer.vue';
import MailView from './Components/MailView.vue'
import MailReply from './Components/MailReply.vue'
import { fetchMessage } from './api';


const emit = defineEmits(['close'])

const props = defineProps({
    message_id: {
        type: String,
    }
})

const message = ref([])
const drawer = ref(null)
const action = ref('view')

function closeDrawer() {
    // drawer.value.closeModal()
    // console.log('drawer closed', drawer.value.closeModal() )
    // alert('Drawer closed')
    emit('close')
}

function reply(type = 'reply'){
    action.value = type
}

onMounted(async () => {
    message.value =  await fetchMessage(props.message_id)
})



</script>

<template>
    <Drawer ref="drawer" @close="closeDrawer" >
        <div v-if="action === 'view'">
            <MailView :message="message" />
        </div>
        <div v-else>
            <MailReply :message="message" />
        </div>
        <template #drawer-footer>
            <div class="flex flex-row justify-end items-center w-full p-2 gap-2">
                <button @click="reply()">Reply</button>
                <button @click="reply('reply-all')">Reply All</button>
                <button @click="reply('forward')">Forward</button>

            </div>
        </template>
    </Drawer>
</template>
