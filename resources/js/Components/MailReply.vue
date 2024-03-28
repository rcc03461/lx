
<script setup>
import { ref, defineProps } from 'vue'
import Editor from '@tinymce/tinymce-vue'

const props = defineProps({
    message: {
        type: Object,
        required: true
    }
})

const form = ref({
    from:{},
    to:[],
    cc:[],
    bcc:[],
    subject: props.message.subject,
    message: props.message.html_body,
    attachments: props.message.attachments
})


const apiKey = import.meta.env.VITE_TINYMCE_API_KEY
const uploadUrl = import.meta.env.VITE_UPLOAD_URL + '?for_type=editor&dir=editor'
const editorOptions = {
    height: 650,
    menubar: false,
    toolbar_mode: 'sliding',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount textcolor',
    toolbar: 'undo redo | blocks fontfamily fontsize forecolor backcolor | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
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


</script>

<template>
    <div class="message-container">
        <!-- <h2>{{ message.subject }}</h2> -->
        <input class="subject-input w-full p-.5 mb-2 border-b border-black" type="text" v-model="form.subject" >
        <Editor
          :api-key="apiKey"
          :init="editorOptions"
          v-model="form.message"
         />
         <div>
            <ul class="flex gap-2">
                <li v-for="attachment in message.attachments" :key="attachment.id">
                    <a :href="`/storage/` + attachment.path" target="_blank">
                        <img class="size-24 object-cover" :src="`/storage/` + attachment.path" alt="">
                        <p>
                            {{ attachment.name }}
                        </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
