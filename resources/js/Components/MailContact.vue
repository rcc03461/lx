<script>
    import { ElAutocomplete, ElTag, ElInput, ElButton } from 'element-plus'
    export default {
        name: 'MailContact',
        components: {
            ElAutocomplete,
            ElTag,
            ElInput,
            ElButton
        },
        props: {
            editable:{
                type: Boolean,
                default: true
            },
            title: {
                type: String,
                default: 'To'
            },
            modelValue: {
                type: Array,
                default: () => []
            }
        },
        emits: ['update:modelValue'],
        data() {
            return {
                inputVisible: false,
                inputValue: '',
            }
        },
        methods: {
            handleSelect(item) {
                if ( !this.editable ) return
                this.inputVisible = true
                this.$nextTick(() => {
                    this.$refs.InputRef.focus()
                    this.inputValue = item.email
                })
            },
            querySearch(queryString, cb) {
                const results = queryString ? this.options.filter(this.createFilter(queryString)) : this.options;
                cb(results)
            },
            showInput() {
                this.inputVisible = true
                this.$nextTick(() => {
                    this.$refs.InputRef.focus()
                })
            },
            handleClose(item) {
                this.modelValue.splice(this.modelValue.indexOf(item), 1)
            },
            handleInputConfirm(){
                if (this.inputValue) {
                    this.modelValue.push({
                        email: this.inputValue,
                        name: ''
                    })
                    this.$emit('update:modelValue', this.modelValue)
                }
                this.inputVisible = true
                this.inputValue = ''
            },
        },
        mounted() {
            console.log(this.modelValue);
        }
    }
</script>

<template>
    <div class="flex gap-2 items-center">
        <label for="">{{ title }}</label>
        <div class="flex gap-2 flex-wrap">
            <div class="flex gap-2 flex-wrap">
                <el-tag
                    v-for="item in modelValue"
                    @click.stop="handleSelect(item)"
                    :key="item.email"
                    :closable="editable"
                    :disable-transitions="false"
                    @close="handleClose(item)"
                >
                {{ item.email }}
                </el-tag>
                <el-input
                    v-if="inputVisible"
                    ref="InputRef"
                    v-model="inputValue"
                    class="w-20"
                    size="small"
                    @keyup.enter="handleInputConfirm"
                    @blur="handleInputConfirm"
                />
                <el-button v-if="!inputVisible && editable" class="button-new-tag" size="small" @click="showInput">
                + New
                </el-button>
            </div>
        </div>
    </div>
</template>
