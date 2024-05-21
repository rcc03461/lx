
<script setup>
import { ref, reactive, defineProps, onMounted, defineExpose } from 'vue'
import { ElUpload, ElButton, ElInput} from 'element-plus'
// import { Delete, Download, Plus, ZoomIn } from '@element-plus/icons-vue'
import Editor from '@tinymce/tinymce-vue'
import MailContact from './MailContact.vue'
import MailAttachments from './MailAttachments.vue'
import { fetchSend, fetchContacts } from '@/api'
import { uniqBy } from 'lodash';

function nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

const props = defineProps({
    message: {
        type: Object,
        required: true
    },
    action: {
        type: String,
        required: true
    }
})

const contacts = ref()

const form = reactive({
    // from:{},
    to:[],
    cc:[],
    bcc:[],
    subject: "",
    message: "",
    attachments: []
})

onMounted( async () => {

    contacts.value = await fetchContacts();
    console.log(contacts.value, "contacts monted");

    const content = props.message.html_body || nl2br(props.message.text_body);

    if (props.action === 'reply') {
        form.to = [props.message.from]
        form.subject = `Re: ${props.message.subject}`
        form.message = `${content}`
    }

    if (props.action === 'forward') {
        form.to = []
        // form.cc = props.message.cc
        form.attachments = props.message.attachments
        form.subject = `Fwd: ${props.message.subject}`
        form.message = `${content}`
    }

    if (props.action === 'reply-all') {
        form.to = uniqBy([props.message.from, ...props.message.to], 'email')
        form.cc = props.message.cc
        form.subject = `Re: ${props.message.subject}`
        form.message = `${content}`
    }

    console.log(props.action)
})




const apiKey = import.meta.env.VITE_TINYMCE_API_KEY
const uploadUrl = import.meta.env.VITE_UPLOAD_URL + '?for_type=editor&dir=editor'
const editorOptions = {
    height: 350,
    menubar: false,
    toolbar_mode: 'sliding',
    plugins: 'anchor autolink charmap code codesample emoticons image link lists media searchreplace table visualblocks wordcount textcolor',
    toolbar: 'undo redo | blocks fontfamily fontsize forecolor backcolor | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | codesample | code',
    automatic_uploads: true,
    // block_unsupported_drop: false,
    images_upload_url: uploadUrl, // return ['location' => url]
    /*
        URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
        images_upload_url: 'postAcceptor.php',
        here we add custom filepicker only to Image dialog
    */
    file_picker_types: 'image',
    // images_file_types: "png,jpeg,gif,jpg,svg,webp",
    block_unsupported_drop: false,
    // images_upload_url: 'postAcceptor.php',
    /* and here's our custom image picker*/
    file_picker_callback: function (cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        /*
        Note: In modern browsers input[type="file"] is functional without
        even adding it to the DOM, but that might not be the case in some older
        or quirky browsers like IE, so you might want to add it to the DOM
        just in case, and visually hide it. And do not forget do remove it
        once you do not need it anymore.
        */

        input.onchange = function () {
            var file = this.files[0];

            var reader = new FileReader();
            reader.onload = function () {
                /*
                Note: Now we need to register the blob in TinyMCEs image blob
                registry. In the next release this part hopefully won't be
                necessary, as we are looking to handle it internally.
                */
                // var id = 'blobid' + (new Date()).getTime();
                // var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                // var base64 = reader.result.split(',')[1];
                // var blobInfo = blobCache.create(id, file, base64);
                // blobCache.add(blobInfo);

                /* call the callback and populate the Title field with the file name */
                // cb('http://localhost/dist/images/logo.png', { title: file.name });
                // cb(blobInfo.blobUri(), { title: file.name });
                const formdata = new FormData();
                formdata.append('file', file);

                fetch(uploadUrl, {
                    method: 'POST',
                    body: formdata,
                    // headers: {
                    //     'Content-Type':'multipart/form-data'
                    // }
                })
                .then(response => response.json())
                .then((data) => { // return ['location' => url]
                    // console.log(data);
                    cb(data.location, { title: "" });
                    // resolve( {
                    //     default: data.files[0].url
                    // } );
                }).catch(error => {
                    console.error(error);
                    // reject( error );
                })

            };
            reader.readAsDataURL(file);
        };

        input.click();
    },
}




const handleSend = () => {
    // console.log(form)
    //
    if (form.to.length === 0) {
        alert('Please select at least one recipient')
        return
    }
    if (form.subject.trim() === '') {
        alert('Please enter a subject')
        return
    }
    fetchSend(form).then(response => {
        console.log(response)
    }).catch(error => {
        console.error(error)
    })
}


defineExpose({
    handleSend
})
</script>

<template>
    <div class="message-container">
        <!-- <h2>{{ message.subject }}</h2> -->
        <div class="flex flex-col gap-2">
            <!-- <input class="subject-input w-full p-.5 mb-2 border-b border-black" type="text" v-model="form.subject" > -->
            <MailContact v-model="form.to" title="To" :contacts="contacts" />
            <MailContact v-model="form.cc" title="cc" :contacts="contacts" />
            <MailContact v-model="form.bcc" title="bcc" :contacts="contacts" />

            <el-input class="w-full" v-model="form.subject" placeholder="Subject" />
        </div>
        <!-- <MailContact v-model="form.cc" />
        <MailContact v-model="form.bcc" /> -->
        <Editor
          :api-key="apiKey"
          :init="editorOptions"
          v-model="form.message"
         />
         <div>
            <MailAttachments v-model="form.attachments" />
        </div>
        <!-- <div>
            <el-button type="primary" @click="handleSend">Send</el-button>
        </div> -->
    </div>
</template>
