<script setup>
// import 'element-plus/es/components/message/style/css'
import { ref, defineEmits, defineProps, onMounted } from 'vue';
import { ElButton, ElDrawer } from 'element-plus'
// import Drawer from './Components/Drawer.vue';
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
function setAction(type = 'reply'){
    action.value = type
}

function closeDrawer() {
    // drawer.value.closeModal()
    // console.log('drawer closed', drawer.value.closeModal() )
    // alert('Drawer closed')
    emit('close')
}

onMounted(async () => {
    message.value =  await fetchMessage(props.message_id)
})

const refReply = ref(null)
function handleSubmit(){
    console.log('handleSubmit', refReply.value.handleSend())

}


</script>

<template>
    <el-drawer ref="drawer" :model-value="true" :title="message.subject" size="50%">
        <!-- <Drawer ref="drawer" @close="closeDrawer" > -->
            <div v-if="action === 'view'">
                <MailView :message="message" />
            </div>
            <div v-else>
                <MailReply ref="refReply" :message="message" :action="action" />
            </div>
            <template #footer>
                <div class="flex flex-row justify-end items-center w-full p-2 gap-2">
                    <div v-if="action === 'view'">
                        <el-button type="primary" @click="setAction('reply')">Reply</el-button>
                        <el-button type="primary" @click="setAction('reply-all')">Reply All</el-button>
                        <el-button type="primary" @click="setAction('forward')">Forward</el-button>
                    </div>
                    <div v-else>
                        <el-button type="primary" @click="setAction('view')">View</el-button>
                        <el-button type="primary" @click="handleSubmit">Send</el-button>
                    </div>
                </div>
            </template>
        <!-- </Drawer> -->
    </el-drawer>
</template>
