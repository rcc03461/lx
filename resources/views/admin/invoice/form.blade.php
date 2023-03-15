<div>
    @verbatim
    <section id="vue-app">

        <div class="action-bar flex justify-end gap-2">
            <button class="btn btn-primary" @click="submitForm"> Submit </button>
        </div>

        <div class="flex items-center my-2">
            <label class="w-40" for="">Task:</label>
            <div class="flex-1">
                <selec-with-ajax-search v-model="form.task_id">
                    <template #selected="{selected}">
                        {{selected.code}} - {{selected.title}} - {{selected.job?.job_code}}
                    </template>
                    <template #item="{item}">
                        {{item.code}} - {{item.title}} - {{item.job?.job_code}}
                    </template>
                </selec-with-ajax-search>
            </div>
        </div>

        <!-- <div class="flex items-center my-2">
            <label class="w-40" for="">Invoice No:</label>
            <div class="flex-1">
                <div class="input-group">
                    <span class="input-group-prepend"><span class="input-group-text bg-white">Lx-</span></span>
                    <input v-model.number="form.InvoiceNo" type="number" name="InvoiceNo" class="form-control _normal_" placeholder="Invoice No">
                    <span @click="generateInvoiceNo" class="input-group-prepend cursor-pointer hover:bg-slate-200"><span class="input-group-text bg-white">Generate Invoice No</span></span>
                </div>
            </div>
        </div> -->


        <div class="flex">
            <div class="flex items-center my-2">
                <label class="w-40" for="">No:</label>
                <div class="flex-1">
                    <input  class="form-control" type="text" v-model="form.lx_number" placeholder="221001 | 111878">
                </div>
            </div>

            <div class="flex items-center my-2">
                <label class="w-40" for="">Code:</label>
                <div class="flex-1">
                    <input class="form-control" type="text" v-model="form.lx_code" placeholder="Cre8-221001 | LI-111878">
                </div>
            </div>

        </div>


        <div class="flex items-center my-2">
            <label class="w-40" for="">Invoice Date:</label>
            <div class="flex-1">
                <input class="form-control" type="date" v-model="form.invoiceDate">
            </div>
        </div>

        <table class="w-full">
            <tr>
                <td class="w-40"></td>
                <td>Words count</td>
                <td>Unit Price</td>
                <td>Unit</td>
            </tr>
            <tr>
                <td>English:</td>
                <td><input v-model.number="form.words.eng.words" class="form-control" type="text" name="" id=""></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-prepend"><span class="input-group-text bg-white">$</span></span>
                        <input v-model.number="form.words.eng.price" type="number" name="address" class="form-control field_address _normal_" placeholder="Price">
                    </div>
                </td>
                <td>
                    <select v-model="form.words.eng.unit" class="form-control" name="" id="">
                        <option value="Eng">Eng Words</option>
                        <option value="Chi">Chi Words</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Chinese:</td>
                <td><input v-model.number="form.words.chi.words" class="form-control" type="text" name="" id=""></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-prepend"><span class="input-group-text bg-white">$</span></span>
                        <input v-model.number="form.words.chi.price" type="number" name="address" class="form-control field_address _normal_" placeholder="Price">
                    </div></td>
                <td>
                    <select v-model="form.words.chi.unit" class="form-control" name="" id="">
                        <option value="Chi">Chi Words</option>
                        <option value="Eng">Eng Words</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td>Pages count</td>
                <td>Unit Price</td>
                <td>Unit</td>
            </tr>
            <tr>
                <td>English:</td>
                <td><input v-model="form.pages.eng.pages" class="form-control" type="text" name="" id=""></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-prepend"><span class="input-group-text bg-white">$</span></span>
                        <input v-model.number="form.pages.eng.price" type="number" name="address" class="form-control field_address _normal_" placeholder="Price">
                    </div>
                </td>
                <td>Pages</td>
            </tr>
            <tr>
                <td>Chinese:</td>
                <td><input v-model.number="form.pages.chi.pages" class="form-control" type="text" name="" id=""></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-prepend"><span class="input-group-text bg-white">$</span></span>
                        <input v-model="form.pages.chi.price" type="number" name="address" class="form-control field_address _normal_" placeholder="Price">
                    </div>
                </td>
                <td>Pages</td>
            </tr>
        </table>


        <div class="flex items-center my-2">
            <label class="w-40" for="">Overtime / Remarks:</label>
            <div class="flex-1">
                <textarea class="form-control" v-model="form.tranRemark" name="" id="" rows="2"></textarea>
            </div>
        </div>

        <div class="flex items-center my-2">

            <label class="w-40" for="">Other Cost: <button @click="addOther"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg></button>
            </label>
            <table class="flex-1">
                <tr v-for="(item,i) in form.other">
                    <td><textarea v-model="item.desc" name="description" class="autoHeight form-control" rows="1" placeholder="Description"></textarea></td>
                    <td><input v-model.number="item.qty" class="form-control" name="quantity" type="number" placeholder="Quantity"></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-prepend"><span class="input-group-text bg-white">$</span></span>
                            <input v-model.number="item.price" type="number" name="address" class="form-control field_address _normal_" placeholder="Price">
                        </div>
                    </td>
                    <td><input v-model="item.unit" class="form-control" name="unit" type="text" placeholder="Unit"></td>
                    <td>
                        <button class="btn" @click="removeOther(i)"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    </td>
                </tr>
            </table>
        </div>

        <div class="flex items-center my-2">

            <label class="w-40" for="">LESS: <button @click="addLess"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg></button></label>

            <table class="flex-1">
                <tr v-for="(item,i) in form.less">

                    <td><textarea v-model="item.desc" name="description" class="autoHeight form-control" rows="1" placeholder="Description"></textarea></td>
                    <td><input v-model.number="item.qty" class="form-control" name="quantity" type="number" placeholder="Quantity"></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-prepend"><span class="input-group-text bg-white">$</span></span>
                            <input v-model.number="item.price" type="number" name="address" class="form-control field_address _normal_" placeholder="Price">
                        </div>
                    </td>
                    <td><input v-model="item.unit" class="form-control" name="unit" type="text" placeholder="Unit"></td>
                    <td>
                        <button class="btn" @click="removeLess(i)"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    </td>
                </tr>
            </table>
        </div>

    <div class="text-2xl">
        <div>Total : </div>
        <div>{{digi(total)}}</div>
    </div>

    </section>
    @endverbatim
    {{-- mordern popup form with tailwindcss --}}

</div>

<style>
    table.bordered, table.bordered th, table.bordered td{
        border: 1px solid #ccc;
    }

</style>

{{-- <script src="https://unpkg.com/vue@3"></script> --}}


    <script>
        Dcat.ready(function () {
            // 写你的逻辑

            const { createApp , defineComponent } = Vue;
        const selecWithAjaxSearch = defineComponent({
                props: [
                    'value',
                ],
                data() {
                    return {
                        showSearch: false,
                        options: [],
                        selected: {},
                    }
                },
                watch:{
                    value(val) {
                        const {value} = this;
                        if (value) {
                            this.ajaxGet(value);
                        }
                    }
                },
                mounted(){
                    if(this.value){
                        this.ajaxGet(this.value);
                    }
                },
                methods: {
                    clickOutside: function (e) {
                        this.showSearch = false;
                    },
                    async ajaxGet( id ) {
                        let {data} = await axios.get('/admin/api/tasks/' + id);
                        this.selected = data;
                    },
                    ajaxSearch: _.debounce(async function (e) {
                        this.showSearch = true;
                        if (e.target.value) {
                            let res = await axios.get('/admin/api/tasks?q=' + e.target.value);
                            this.options = res.data;
                        }
                    }, 300),
                    select(e) {
                        // console.log(e);
                        this.$emit('input', e.id);
                        this.selected = e;
                        this.showSearch = false;
                    },
                    focusInput(e) {
                        this.showSearch = true;
                        // console.log(this.$refs);
                        setTimeout(() => {
                            this.$refs.searchinput.focus();
                        }, 100);
                    },
                    clearResult() {
                        this.selected = {};
                        this.$emit('input', null);
                    }
                },
                template: `<div class="relative w-full" v-click-outside="clickOutside">
                    <div class="flex items-center">
                        <input ref="searchinput" v-show="showSearch" class="form-control w-full outline-none px-1 focus:border-b bg-gray-100 " type="text" @keyup="ajaxSearch" @focus="showSearch = true"/>
                        <div v-show="!showSearch" class="flex-1 form-control cursor-pointer hover:bg-gray-50" @click="focusInput">
                            <slot name="selected" :selected="selected">
                                @{{selected.title}}
                            </slot>
                        </div>
                        <div @click="clearResult" class="w-12 text-center hover:bg-gray-50 cursor-pointer">Clear</div>
                    </div>
                    <div v-show="showSearch" class="absolute border shadow-lg left-0 bg-white w-full max-h-72 overflow-y-auto px-1 py-1 z-10" style="top:110%">
                        <div v-if="options.length == 0" class="text-center">Type to search...</div>
                        <ul v-else>
                            <li class="hover:bg-gray-100 cursor-pointer py-0.5 px-0.5" v-for="item in options" @click="select(item)">
                                <slot name="item" :item="item">
                                    @{{item.title}}
                                </slot>
                            </li>
                        </ul>
                    </div>
                </div>`
            })

            const lxInput = defineComponent('lx-input', {
                props: [
                    'value',
                    'type',
                    'datalist'
                ],
                data() {
                    return {
                        editing: false,
                        // date: dayjs().format('YYYY-MM-DD'),
                    }
                },
                mounted(){

                },
                methods: {
                    clickOutside: function (e) {
                        this.editing = false;
                    },

                    select(e) {
                        console.log(e);
                        this.$emit('input', e.target.value);
                        this.editing = false;
                    },
                    focusInput(e) {
                        this.editing = true;
                        // console.log(this.$refs);
                        setTimeout(() => {
                            this.$refs.refinput.focus();
                        }, 100);
                    }
                },
                template: `<div class="relative w-full" v-click-outside="clickOutside">
                    <input ref="refinput" v-show="editing" class="form-control w-full outline-none px-1 focus:border-b bg-gray-100" :type="type" @input="select" @focus="editing = true"/>
                    <div v-show="!editing" class="form-control cursor-pointer hover:bg-gray-50" @click="focusInput">
                        @{{value || ' - '}}
                    </div>

                </div>`
            })



        // Vue.component('vue-multiselect', window.VueMultiselect.default)
        // const { createApp , defineComponent } = Vue;
        const app = createApp({
            // el: '#vue-app',
            components:{
                selecWithAjaxSearch,
                lxInput,
            },
            data(){
               return {
                loading: false,
                form:{
                    task_id: @json(request('task_id', null)),
                    tranRemark:"",
                    InvoiceNo:"",
                    lx_number:"",
                    lx_code:"",
                    invoiceDate: dayjs().format('YYYY-MM-DD'),
                    words:{eng:{type:"eng",words:"",price:"",unit:"Chi"},chi:{type:"chi",words:"",price:"",unit:"Chi"}},
                    pages:{eng:{type:"eng",pages:"",price:""},chi:{type:"chi",pages:"",price:""}},
                    other:[{desc:"Package",price:"0",qty:"0",unit:"Package"}],
                    less:[{desc:"",price:"0",qty:"0",unit:"Chi Words"}],
                    total:0
                },
               }
            },
            // filters:{
            //     digi(doller){
            //         return new Intl.NumberFormat('en-US', {minimumFractionDigits: 2, maximumFractionDigits:2}).format(doller)
            //     }
            // },
            computed:{
                total: function(){
                    const {form:{words,pages,other,less}} = this;
                    // console.log(words, pages, other, less);
                    const total =   +words.eng.price * +words.eng.words + +words.chi.price * +words.chi.words +
                                    +pages.eng.price * +pages.eng.pages + +pages.chi.price * +pages.chi.pages +
                                    (other?.reduce((a,b)=>a + +b.price * +b.qty,0) || 0) -
                                    (less?.reduce((a,b)=>a + +b.price * +b.qty,0) || 0)
                                    ;
                    return +total;
                }
            },
            watch:{
            },
            methods:{
                digi(doller){
                    return new Intl.NumberFormat('en-US', {minimumFractionDigits: 2, maximumFractionDigits:2}).format(doller)
                },
                addOther(){
                    this.form.other.push({desc:"",price:"",qty:1,unit:"Package"})
                },
                addLess(){
                    this.form.less.push({desc:"",price:"",qty:1,unit:"Package"})
                },
                removeOther(index){
                    this.form.other.splice(index,1)
                },
                removeLess(index){
                    this.form.less.splice(index,1)
                },
                uploadFiles( event ){
                    const files = event.target.files
                    const formData = new FormData()
                    for(let i = 0; i < files.length; i++){
                        formData.append(`files${i}`, files[i])
                    }
                    axios.post('/admin/api/upload-files', formData).then(response => {
                        console.log(response.data);
                        if ( this.form.attachments == null ) {
                            this.form.attachments = [...response.data.data]
                        }else{
                            this.form.attachments = [...this.form.attachments, ...response.data.data]
                        }
                    })
                },
                removeAttachment( url ){
                    Dcat.confirm('确认要删除这行数据吗？', null,  () => {
                        console.log('确认删除');
                        this.form.attachments = this.form.attachments.filter(f=>f != url)
                    });
                },
                // generateInvoiceNo(){
                //     axios.get('/admin/api/generate-invoice-no').then(({data}) => {
                //         console.log(data);
                //         this.form.InvoiceNo = data.invoiceNo
                //     })
                // },
                submitForm: _.debounce(async function(){
                    this.loading = true;
                    const {form, total} = this;
                    const {words,pages,other,less} = form;
                    // alert(total);
                    const {data} = await axios.post('/admin/api/invoice', {
                        ...this.form,
                        total
                    })
                    Dcat.success('保存成功');
                    window.location.href = `/admin/invoices/${data.id}/edit`;
                    this.loading = false;
                }, 300)
            },
            async mounted(){

                const invoice = @json($invoice);

                console.log(invoice);

                this.form = {
                    ...this.form,
                    ...invoice,
                    other:invoice.other || [],
                    less:invoice.less || [],
                    invoiceDate: invoice.invoiceDate ? dayjs(invoice.invoiceDate).format('YYYY-MM-DD') : dayjs().format('YYYY-MM-DD'),
                };

                // if (this.job_id) {
                //     this.fetchJob()
                // }
                // if (this.clone) {
                //     this.cloneJob()
                // }


            }
        }).directive('click-outside', {
                mounted(el, binding, vnode) {
                    el.clickOutsideEvent = function(event) {
                    if (!(el === event.target || el.contains(event.target))) {
                        binding.value(event, el);
                    }
                    };
                    document.body.addEventListener('click', el.clickOutsideEvent);
                },
                unmounted(el) {
                    document.body.removeEventListener('click', el.clickOutsideEvent);
                }
            })

        .mount('#vue-app')

    console.log('所有JS脚本都加载完了');
    });
    </script>
