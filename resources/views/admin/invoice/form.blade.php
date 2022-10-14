<div>
    @verbatim
    <section id="vue-app">

        <div class="action-bar flex justify-end gap-2">
            <button class="btn btn-primary" @click="submitForm"> Submit </button>
        </div>

        <div class="flex items-center my-2">{{form.task_id}}
            <label class="w-40" for="">Task:</label>
            <div class="flex-1">
                <selec-with-ajax-search v-model="form.task_id">
                    <template slot="item" scope="{item}">
                       {{item.job_code}} - {{item.company}}
                    </template>
                </selec-with-ajax-search>
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
                    </div></td>
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
            Vue.directive('click-outside', {
                bind: function (el, binding, vnode) {
                    el.clickOutsideEvent = function (event) {
                    // here I check that click was outside the el and his children
                    if (!(el == event.target || el.contains(event.target))) {
                        // and if it did, call method provided in attribute value
                        vnode.context[binding.expression](event);
                    }
                    };
                    document.body.addEventListener('click', el.clickOutsideEvent)
                },
                unbind: function (el) {
                    document.body.removeEventListener('click', el.clickOutsideEvent)
                },
            });

        Vue.component('selec-with-ajax-search', {
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
                    this.ajaxGetJob(value);
                }
            },
            mounted(){

            },
            methods: {
                clickOutside: function (e) {
                    this.showSearch = false;
                },
                async ajaxGetJob( job_id ) {
                    let {data} = await axios.get('/admin/api/c8c-jobs/' + job_id);
                    this.selected = data;
                },
                ajaxSearch: _.debounce(async function (e) {
                    this.showSearch = true;
                    if (e.target.value) {
                        let res = await axios.get('/admin/api/c8c-jobs?q=' + e.target.value);
                        this.options = res.data;
                    }
                }, 300),
                select(e) {
                    // console.log(e);
                    this.$emit('input', e.job_id);
                    this.selected = e;
                    this.showSearch = false;
                },
                focusInput(e) {
                    this.showSearch = true;
                    // console.log(this.$refs);
                    setTimeout(() => {
                        this.$refs.searchinput.focus();
                    }, 100);
                }
            },
            template: `<div class="relative" v-click-outside="clickOutside">
                <input ref="searchinput" v-show="showSearch" class="form-control" type="text" @keyup="ajaxSearch" @focus="showSearch = true"/>
                <div v-show="!showSearch" class="form-control cursor-pointer" @click="focusInput">@{{selected.job_code || ""}} - @{{selected.company || ""}}</div>
                <div v-show="showSearch" class="absolute border shadow-lg top-12 left-0 bg-white w-full max-h-72 overflow-y-auto px-1 py-1 z-10">
                    <div v-if="options.length == 0" class="text-center">Type to search...</div>
                    <ul v-else>
                        <li class="hover:bg-gray-100 cursor-pointer py-0.5 px-0.5" v-for="item in options" @click="select(item)">
                            <slot name="item" :item="item">
                                @{{item.job_code}} - @{{item.company}}
                            </slot>
                        </li>
                    </ul>
                </div>
            </div>`
        })

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
                    idjob: null,
                    tranRemark:"",
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
                    const total =   this.form.words.eng.price * this.form.words.eng.words + this.form.words.chi.price * this.form.words.chi.words +
                                    this.form.pages.eng.price * this.form.pages.eng.pages + this.form.pages.chi.price * this.form.pages.chi.pages +
                                    this.form.other.reduce((a,b)=>a + b.price * b.qty,0) -
                                    this.form.less.reduce((a,b)=>a + b.price * b.qty,0);
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
                submitForm: _.debounce(async function(){
                    this.loading = true;
                    const {form} = this;
                    const {words,pages,other,less} = form;


                    // alert(total);
                    const {data} = await axios.post('/admin/api/invoice', {
                        ...this.form,
                        total
                    })
                    // .then(response => {
                    //     console.log(response.data);
                    //     // window.location.href = '/admin/c8c-invoices';
                    // })
                    // console.log(data);
                    Dcat.success('保存成功');
                    this.loading = false;
                }, 300)
            },
            async mounted(){

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
