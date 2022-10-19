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
                       {{selected.title}} - {{selected.job?.job_code}}
                    </template>
                    <template #item="{item}">
                       {{item.title}} - {{item.job?.job_code}}
                    </template>
                </selec-with-ajax-search>
            </div>
        </div>

        <div class="flex items-center my-2">
            <label class="w-40" for="">Invoice No:</label>
            <div class="flex-1">
                <div class="input-group">
                    <span class="input-group-prepend"><span class="input-group-text bg-white">Lx-</span></span>
                    <input v-model.number="form.InvoiceNo" type="number" name="InvoiceNo" value="" class="form-control _normal_" placeholder="Invoice No">
                    <span @click="generateInvoiceNo" class="input-group-prepend cursor-pointer hover:bg-slate-200"><span class="input-group-text bg-white">Generate Invoice No</span></span>
                </div>
            </div>
        </div>

        <div class="flex items-center my-2">
            <label class="w-40" for="">Invoice Date:</label>
            <div class="flex-1">
                {{form.invoiceDate}}
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
                        <input v-model.number="form.words.eng.price" type="number" name="address" value="" class="form-control field_address _normal_" placeholder="Price">
                    </div>
                </td>
                <td>
                    <select v-model="form.words.eng.unit" class="form-control" name="" id="">
                        <option value="Chi">Chi Words</option>
                        <option value="Eng">Eng Words</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Chinese:</td>
                <td><input v-model.number="form.words.chi.words" class="form-control" type="text" name="" id=""></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-prepend"><span class="input-group-text bg-white">$</span></span>
                        <input v-model.number="form.words.chi.price" type="number" name="address" value="" class="form-control field_address _normal_" placeholder="Price">
                    </div></td>
                <td>
                    <select v-model="form.words.chi.unit" class="form-control" name="" id="">
                        <option value="Chi">Chi Words</option>
                        <option value="Eng">Eng Words</option>
                    </select>
                </td>
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
                        <input v-model.number="form.pages.eng.price" type="number" name="address" value="" class="form-control field_address _normal_" placeholder="Price">
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
                        <input v-model="form.pages.chi.price" type="number" name="address" value="" class="form-control field_address _normal_" placeholder="Price">
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


        <label class="w-40" for="">Other Cost: <button @click="addOther"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
</svg>
</button></label>
        <table class="w-full">
            <tr v-for="(item,i) in form.other">
                <td><textarea v-model="item.desc" name="description" class="autoHeight form-control" rows="1" placeholder="Description"></textarea></td>
                <td><input v-model.number="item.qty" class="form-control" value="" name="quantity" type="number" placeholder="Quantity"></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-prepend"><span class="input-group-text bg-white">$</span></span>
                        <input v-model.number="item.price" type="number" name="address" value="" class="form-control field_address _normal_" placeholder="Price">
                    </div>
                </td>
                <td><input v-model="item.unit" class="form-control" value="" name="unit" type="text" placeholder="Unit"></td>
                <td>
                    <button class="btn" @click="removeOther(i)"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </td>
            </tr>
        </table>


        <label class="w-40" for="">LESS: <button @click="addLess"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg></button></label>

        <table class="w-full">
            <tr v-for="(item,i) in form.less">

                <td><textarea v-model="item.desc" name="description" class="autoHeight form-control" rows="1" placeholder="Description"></textarea></td>
                <td><input v-model.number="item.qty" class="form-control" value="" name="quantity" type="number" placeholder="Quantity"></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-prepend"><span class="input-group-text bg-white">$</span></span>
                        <input v-model.number="item.price" type="number" name="address" value="" class="form-control field_address _normal_" placeholder="Price">
                    </div>
                </td>
                <td><input v-model="item.unit" class="form-control" value="" name="unit" type="text" placeholder="Unit"></td>
                <td>
                    <button class="btn" @click="removeLess(i)"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </td>
            </tr>
        </table>
    <div>
        <div>Total : </div>
        <div>{{total | digi}}</div>
    </div>


    {{form}}
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

        // Vue.component('vue-multiselect', window.VueMultiselect.default)

        const app = new Vue({
            el: '#vue-app',
            components:{
                // selecWithAjaxSearch
            },
            data(){
               return {
                loading: false,
                form:{
                    task_id: @json(request('task_id', null)),
                    tranRemark:"",
                    InvoiceNo:"",
                    invoiceDate: dayjs().format('YYYY-MM-DD'),
                    words:{eng:{type:"eng",words:"",price:"",unit:"Chi"},chi:{type:"chi",words:"1253",price:"0.8",unit:"Chi"}},
                    pages:{eng:{type:"eng",pages:"",price:""},chi:{type:"chi",pages:"",price:""}},
                    other:[{desc:"Package",price:"3200",qty:"1",unit:"Package"}],
                    less:[{desc:" 2021-10-04_cyc 006 (E to C) - Copied from cyc 005",price:"0.8",qty:"4496",unit:"Chi Words"}],
                    total:0
                },
               }
            },
            filters:{
                digi(doller){
                    return new Intl.NumberFormat('en-US', {minimumFractionDigits: 2, maximumFractionDigits:2}).format(doller)
                }
            },
            computed:{
                total: function(){
                    const {form:{words,pages,other,less}} = this;
                    const total =   words.eng.price * words.eng.words + words.chi.price * words.chi.words +
                                    pages.eng.price * pages.eng.pages + pages.chi.price * pages.chi.pages +
                                    other?.reduce((a,b)=>a + b.price * b.qty,0) -
                                    less?.reduce((a,b)=>a + b.price * b.qty,0);
                    return +total;
                }
            },
            watch:{
            },
            methods:{

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
                generateInvoiceNo(){
                    axios.get('/admin/api/generate-invoice-no').then(({data}) => {
                        console.log(data);
                        this.form.InvoiceNo = data.invoiceNo
                    })
                },
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
                    invoiceDate: invoice.invoiceDate ? dayjs(invoice.invoiceDate).format('YYYY-MM-DD') : dayjs().format('YYYY-MM-DD'),
                };

                // if (this.job_id) {
                //     this.fetchJob()
                // }
                // if (this.clone) {
                //     this.cloneJob()
                // }


            }
        })

    console.log('所有JS脚本都加载完了');
    });
    </script>
