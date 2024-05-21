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
            },
            contacts: {
                type: Array,
                default: () => [
                // { email: '123@123.com', value: '123@123.com' },
                ]
            }
        },
        emits: ['update:modelValue'],
        data() {
            return {
                inputVisible: false,
                inputValue: '',
                // emailsOptions: [
                //     { email: '123@123.com', value: '123@123.com' },
                // ],
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
                // const { contacts } = this;
                // console.log(contacts, "contacts");
                const results = queryString ? this.contacts.filter(this.createFilter(queryString)) : this.contacts;
                // console.log(results, "res");
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
            // auto complete
            createFilter(queryString) {
                return (item) => {
                    return item.email.toLowerCase().indexOf(queryString.toLowerCase()) > -1
                }
            },
            handleSelected(item) {
                this.modelValue.push(item)
                this.$emit('update:modelValue', this.modelValue)
            }



        },
        mounted() {
            console.log(this.contacts, "contacts");
            // console.log(this.modelValue);
        }
    }
</script>

<template>
    <div class="flex gap-2 items-center">
        <label for="">{{ title }}</label>
        <!-- <div>
            <span v-for="item in contacts">{{ item.value }}</span>
        </div> -->
        <div class="flex gap-2 flex-1">
            <div class="flex gap-2 flex-wrap w-full">
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
                <el-autocomplete
                    ref="InputRef"
                    v-if="inputVisible"
                    v-model="inputValue"
                    :fetch-suggestions="querySearch"
                    class="inline-block w-48"
                    size="small"
                    clearable
                    placeholder="Please Input"
                    @select="handleInputConfirm"
                    @blur="handleInputConfirm"
                    @keyup.enter="handleInputConfirm"
                />
                <!-- <el-input
                    v-if="inputVisible"
                    ref="InputRef"
                    v-model="inputValue"
                    class="w-20"
                    size="small"
                    @keyup.enter="handleInputConfirm"
                    @blur="handleInputConfirm"
                /> -->
                <el-button v-if="!inputVisible && editable" class="button-new-tag" size="small" @click="showInput">
                + New
                </el-button>
            </div>
        </div>
    </div>
</template>
