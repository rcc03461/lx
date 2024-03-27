<script setup>
    import { ref, defineEmits, defineExpose } from 'vue'

    const drawer = ref(null);
    const isOpen = ref(true);

    const emit = defineEmits(['close']);

    const props = defineProps({
        title: {
            type: String,
            default: 'Drawer'
        }
    })

    function backdropClicked( event ){
        closeModal( event );
    }
    function closeModal( event ){
        isOpen.value = false;
        emit('close');
    }

    defineExpose({
        isOpen,
        closeModal,
    })
</script>

<template>
    <div ref="drawer" v-if="isOpen" class="drawer fixed z-[1001] inset-0 h-screen w-screen shadow-md">
        <div class="drawer-backdrop fixed inset-0 bg-black/30" @click="backdropClicked"></div>
        <div class="drawer-container w-screen h-screen max-w-3xl flex flex-col absolute right-0 top-0 rounded-md bg-white">
            <div class="drawer-header w-full flex items-center justify-between p-1 gap-1">
                <slot name="drawer-header">{{ title }}</slot>
                <button class="ml-auto drawer-close" @click="closeModal">Close</button>
            </div>
            <div class="drawer-content flex-1 overflow-y-auto p-1 gap-1">
                <slot></slot>
            </div>
            <div class="drawer-footer w-full flex justify-end p-1 gap-1">
                <slot name="drawer-footer"></slot>
            </div>
        </div>
    </div>
</template>
