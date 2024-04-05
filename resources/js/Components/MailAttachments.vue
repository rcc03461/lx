<script>
// import { ElUpload } from 'element-plus';
import { fileThumbnail } from '@/utils/doctype'
import { fetchUpload } from '@/api'
export default {
    name: 'MailAttachment',
    components: {
        // ElUpload
    },
    props: {
        modelValue: {
            type: Array,
            default: () => []
        }
    },
    emits: ['update:modelValue'],
    data() {
        return {
            // uid: this._uid,
        }
    },
    methods: {
        async handleFileChange(event) {
            const files = event.target.files;
            const res = await fetchUpload(files);
            // console.log(res, "handleFileChange");
            this.$emit('update:modelValue', [...this.modelValue,...res.files]);
        },
        fileThumbnail,
    },
    mounted() {
        // console.log('mounted');
    }
}
</script>

<template>
    <div class="my-2 flex gap-2 flex-wrap">
        <!-- <el-upload
            class="avatar-uploader"
            action="https://run.mocky.io/v3/9d059bf9-4660-45f2-925d-ce80ad6c4d15"
            :show-file-list="false"
        >
        </el-upload> -->

        <div v-for="attachment in modelValue" :key="attachment.name" class="mail-attachment-item border rounded text-center relative">
            <div class="mail-attachment group/item relative">
                <img class="size-28  object-contain" :src="fileThumbnail(attachment.path)" alt="" srcset="">
                <div class="mail-attachment-backdrop p-0.5 place-content-center items-center inset-0 w-full h-full bg-black bg-opacity-30 text-white hidden group-hover/item:absolute group-hover/item:!grid group-hover:!visible  ">
                    <div class="mail-attachment-name text-truncate line-clamp-1 w-full">
                        {{ attachment.name }}
                    </div>
                    <div class="flex gap-2 justify-center items-center w-full">
                        <div class="mail-attachment-download">
                            <a :href="attachment.path" target="_blank" class="text-white hover:text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0-3-3m3 3 3-3m-8.25 6a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                                </svg>
                            </a>
                        </div>
                        <div class="mail-attachment-remove">
                            <a :href="attachment.path" target="_blank" class="text-white hover:text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mail-attachment size-28 border rounded text-center relative">
            <label :for="`mail-attachment-id-${$.uid}`" class="size-28 grid place-content-center cursor-pointer !p-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                </svg>
            </label>
            <input :id="`mail-attachment-id-${$.uid}`" class="hidden" type="file" multiple @change="handleFileChange">
        </div>
    </div>
</template>

<style>
.mail-attachment:hover .mail-attachment-backdrop{
    visibility: visible;
}
</style>
