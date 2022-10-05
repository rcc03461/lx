<div>
    @verbatim
    <div id="vue-app">

        <datalist id="size_list">
            <option v-for="item in size_list">{{item}}</option>
        </datalist>

        <datalist id="pagination_list">
            <option v-for="item in pagination_list">{{item}}</option>
        </datalist>

        <datalist id="color_list">
            <option v-for="item in color_list">{{item}}</option>
        </datalist>

        <datalist id="material_list">
            <option v-for="item in material_list">{{item}}</option>
        </datalist>

        <datalist id="binding_list">
            <option v-for="item in binding_list">{{item}}</option>
        </datalist>



        <section class="flex flex-start gap-4">
            <div class="cursor-pointer btn btn-xs" :class="{'btn-success' : tag_display == 'info'}" @click="tag_display = 'info'">Job Details</div>
            <div class="cursor-pointer btn btn-xs"
                v-for="(product,index) in form.products"
                :key="index"
                :class="{
                    'btn-success' : tag_display == 'product' && product_showing_index == index,
                    'text-red-500' : product._delete_
                    }"
                @click="showProduct(index)">{{product.product_name}}</div>

            <div class="cursor-pointer btn btn-xs btn-primary"  @click="addProduct">Add Product</div>
            <span class="ml-auto btn btn-xs" @click="modern_form_show = true">現代</span>
            <div class="w-48" >
                <select class="form-control" v-model="templated">
                    <option value="">Templates</option>
                    {{-- <option value="_mordern">現代</option> --}}
                </select>
            </div>
            <div class="cursor-pointer btn btn-xs btn-primary "  @click="submitJob">Submit</div>
        </section>

        <div v-show="tag_display == 'info'" title="Job Detail" class="w-full">
            <div v-show="form.created_at" class="flex items-center my-2">
                <label class="w-40" for="">Created At</label>
                <div>{{form.created_at}}</div>
            </div>
            <div class="flex items-center my-2">
                <label class="w-40" for="">Company</label>
                <select v-model="form.company_id" class="flex-1 form-control">
                    <option v-for="company in companies" :value="company.id">{{company.name}}</option>
                </select>
            </div>
            <div class="flex items-center my-2">
                <label class="w-40" for="">Job Title</label>
                <input class="flex-1 form-control" type="text" v-model="form.job_title" >
            </div>
            <div class="flex items-center my-2">
                <label class="w-40" for="">Job description</label>
                <textarea class="flex-1 form-control"  v-model="form.job_description" ></textarea>
            </div>
            <div class="flex items-center my-2">
                <label class="w-40" for="">Ref. no</label>
                <input class="flex-1 form-control" type="text" v-model="form.ref_no" >
            </div>
            <div class="flex items-center my-2">
                <label class="w-40" for="">Job In At</label>
                <input class="flex-1 form-control" type="datetime-local" v-model="form.job_in_at" >
            </div>
            <div class="flex items-center my-2">
                <label class="w-40" for="">Attachments</label>
                <div class="">
                    <input class="flex-1 form-control" name="attachments[]" type="file" multiple @change="uploadFiles">
                    <ul class="ml-1 border-l border-gray-500 pl-1 my-1">
                        <li v-for="(url,index) in form.attachments" :key="url" class="hover:bg-gray-300 px-1">
                            <a :href="'/'+url" target="_blank">File {{index + 1}}</a> <span class="pl-4" @click="removeAttachment(url)"> <i class="">Trash</i> </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex items-center my-2">
                <label class="w-40" for="">Is Sample</label>
                <input class="" type="checkbox" v-model="form.is_sample" >
            </div>
            <div class="flex items-center my-2">
                <label class="w-40" for="">Delivery Date</label>
                <input class="flex-1 form-control" type="datetime-local" v-model="form.delivery_date" >
            </div>
            <div class="flex items-center my-2">
                <label class="w-40" for="">Delivery Instructions</label>
                <textarea class="flex-1 form-control"  v-model="form.delivery_instructions" ></textarea>
            </div>
            <div class="flex items-center my-2">
                <label class="w-40" for="">Payment Terms</label>
                <textarea class="flex-1 form-control"  v-model="form.payment_terms" ></textarea>
            </div>
            <div class="flex items-center my-2">
                <label class="w-40" for="">Status</label>
                <select v-model="form.status" class="flex-1 form-control">
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Product Ready">Product Ready</option>
                    <option value="Delivered">Delivered</option>
                </select>
            </div>

            <div class="flex items-center my-2">
                <label class="w-40" for="">Is Outsource</label>
                <input class="" type="checkbox" v-model="form.is_outsource" >
            </div>
            <div v-show="form.is_outsource">
                <div class="flex items-center my-2">
                    <label class="w-40" for="">Oursource Remark</label>
                    <textarea class="flex-1 form-control"  v-model="form.outsource_remark" ></textarea>
                </div>
                <!-- <div class="flex items-center my-2">
                    <label class="w-40" for="">Oursource Cost</label>
                    <input class="flex-1 form-control" type="number"  v-model="form.outsource_cost" >
                </div>
                <div class="flex items-center my-2">
                    <label class="w-40" for="">Outsource Supportings</label>
                    <input class="flex-1 form-control" type="file" v-model="form.outsource_supportings" >
                </div> -->
            </div>

        </div>



        <div v-show="modern_form_show" class="fixed inset-0 z-20 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                <div @click="modern_form_show = false" v-show="modern_form_show"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"
                ></div>

                <div v-show="modern_form_show"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block w-full max-w-7xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl"
                >
                    <div class="flex items-center justify-between space-x-4">
                        <h1 class="text-xl font-medium text-gray-800 ">現代訂印單</h1>

                        <button @click="modern_form_show = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>

                    <p class="mt-2 text-sm text-gray-500 ">
                        Add your teammate to your team and start work to get things done
                    </p>

                    <form class="mt-2">





                        <div class="flex justify-end mt-6">
                            <button @click="submit_mordern" type="button" class="px-2 py-1 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>


</div>


    </div>
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
                // vuedraggable
            },
            data(){
               return {
               }
            },
            filters:{
                digi(value){
                    return Number(value).toFixed(2)
                }
            },
            computed:{
            },
            watch:{
            },
            methods:{
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
