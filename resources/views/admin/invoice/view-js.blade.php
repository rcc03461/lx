<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style media="print">
      .ui-pnotify.ui-pnotify-fade-normal.ui-pnotify-in.ui-pnotify-fade-in.ui-pnotify-move,
      .ui-pnotify{
        display: none !important;
      }
      .pagebreak hr{
        display: none;
      }
      .hidden-print{
        display: none;
      }
      body {
        -webkit-print-color-adjust: exact;
      }
    </style>
    <style>
      .datetimepicker{
        position: relative;
      }
      select{
        border: 0;
      }
      body *{
        box-sizing: border-box;
        font-size: 14px;
      }
      body{
        box-sizing: border-box;
        background-color: rgb(240, 240, 240);
      }
      .bold *{
        font-weight: bold;
      }
      .np{
        padding:0 !important;
      }
      .typeTitle{
        font-size:50px;
        color:#fff;
        background:#000;
        padding:0px 20px;
        border: 2px solid #000;
      }
      @media print {
        input, textarea, select{
          border: none;
        }
      }
      input, textarea, select{
        /*border: 1px solid #000;*/
        width: 100%;
        padding: 2px 5px;
      }
      .serviceLevel{
        padding: 4px 3px;
        border: 1px solid #000;
      }
      .edited ,
      .edited input{
        background-color: rgb(238, 123, 74);
      }
      .container{
        width: 768px;
        padding: 10px;
        /*width:595px;*/
        margin: 0 auto;
        min-height: 700px;
        background-color: #fff;
      }
      table{
        width:100%;
      }
      table tr td{
        padding: 1px 0;
      }
      .flex-col{
        padding: 3px 5px;
        display: flex;
        flex-direction: column;
      }
      .flex-row{
        padding: 3px 5px;
        display: flex;
        flex-direction: row;
      }
      table.bordered td{
        border: 1px solid #000;
        vertical-align: middle;
        text-align: center;
      }
      table.bordered input{
        border: 0 !important;

      }
      .col1big td:nth-of-type(1){
        width: 200px;
      }
      .bottomLineInput input{
        border:0px;
      }
      .pagebreak{
        page-break-before: always;
      }
      .fatBorder{
        border: 2px solid #000;
      }
      .fatBorder thead td{
        padding: 5px 0;
      }
      .fatBorder thead tr{
        border-bottom: 2px solid #000;
      }
      .smallFont{
        font-size: 14px;
      }
      .smallFont thead td{
        font-size: 13px;
      }
      .smallFont td{
        padding: 2px 0;
      }
      .narrowInput input{
        padding: 0 5px;
      }
      #ProofSeq input,
      #ALT input{
        text-align: center;
      }
      table thead tr th{
        text-align: center;
        font-weight: normal;
        font-style: italic;
        font-size: 15px;
      }
      table tbody tr td{
        vertical-align: top;
      }
      .borderContainer{
        border: 2px solid rgb(0, 0, 0);
      }
      h3{
        padding: 6px 0;
        text-align: center;
        border-top: 2px solid rgb(0, 0, 0);
        border-bottom: 1px solid rgb(0, 0, 0);
      }
      .detailContent {
        /*border-top: 1px solid rgb(0, 0, 0);*/

      }
      .detailContent thead{
        background-color: rgb(215, 215, 215) !important;
      }
      @media print {
        .detailContent thead{
          background-color: rgb(215, 215, 215) !important;
        }
      }
      .detailContent thead tr th{
        border-top: 1px solid rgb(0, 0, 0);
        border-bottom: 1px solid rgb(0, 0, 0);
      }
      /*.detailContent thead tr:not(:first),
      .detailContent thead tr:not(:first),
      .detailContent thead tr:not(:last-child),
      .detailContent tbody tr:not(:last-child){
        border-left: 1px solid rgb(0, 0, 0);
        border-right: 1px solid rgb(0, 0, 0);
      }*/
      .detailContent tbody tr:last-of-type td{
        border-bottom: 1px solid rgb(0, 0, 0);
      }
      .detailContent thead tr th:not(:last-child),
      .detailContent tbody tr td:not(:last-child){
        border-right: 1px solid rgb(0, 0, 0);
      }
      .detailContent tr td {
        padding: 3px 5px;
      }
      .detailContent tbody tr td{
        white-space: normal;
        padding: 3px 10px;
      }

      .detailContent tbody tr td:first-child{
        text-align: center;
      }
      .detailContent tbody tr td:nth-child(3), .detailContent tbody tr td:nth-child(4), .detailContent tbody tr td:last-child{
        text-align: right;
      }

    </style>
  </head>
  <body >
    @verbatim

    <section id="vue-app">

        <div class="hidden-print" id="back" style="position:fixed; top:50px; left:30px;" >
          <a onclick="javascript:window.close()">Close (Ctrl + w)</a>
        </div>
        <div class="hidden-print" id="toolbar"style="position:fixed; bottom:50px; right:30px;"></div>
        <input id="idjob" type="hidden" name="" value="">
        <div class="max-w-3xl mx-auto bg-white p-4">
          <div class="borderContainer">
            <section class="mb-1">
              <img src="/assets/lx_logo.png" alt="" style="height:110px;margin: 0 auto; display:block" >
              <!-- <span class="typeTitle" style="float:right;">Translation Invoice</span> -->
            </section>

            <section>

              <h3>INVOICE</h3>
              <table style="margin-left:1%;margin-right:1%;width:98%;">
                <tr>
                  <td style="vertical-align:middle;width:13%">Client Ref</td>
                  <td style="vertical-align:middle;width:2%">:</td>
                  <td style="vertical-align:middle;width:45%">
                    <selec-with-ajax-search v-model="form.task_id">
                        <template #selected="{selected}">
                           <span class="w-full">{{selected.job?.job_code || " - "}}</span>
                        </template>
                        <template #item="{item}">
                           {{item.title}} - {{item.job?.job_code}}
                        </template>
                    </selec-with-ajax-search>
                    </td>
                  <td style="vertical-align:middle;width:1%"></td>
                  <td style="vertical-align:middle;width:20%">Invoice Number</td>
                  <td style="vertical-align:middle;width:2%">:</td>
                  <td style="vertical-align:middle;width:22%" class="text-right">
                        <lx-input type="text" v-model="form.InvoiceNo"></lx-input>
                  </td>
                </tr>
                <tr>
                  <tr>
                    <td style="vertical-align:top">Company</td>
                    <td style="vertical-align:top">:</td>
                    <td colspan="5" class="whitespace-pre-line" style="line-height:1.3">{{client.name}}<br>{{client.address}}</td>
                  </tr>
                </tr>
                <tr>
                  <td>Attention</td>
                  <td>:</td>
                  <td>{{client.attn}}</td>
                  <td></td>
                  <td>LingXpert Job No.</td>
                  <td>:</td>
                  <td class="text-right">{{task.code}}</td>
                </tr>
                <tr>
                  <td style="vertical-align:middle">Date</td>
                  <td style="vertical-align:middle">:</td>
                  <td style="vertical-align:middle;position:relative">
                        <lx-input type="date" v-model="form.invoiceDate"></lx-input>
                  </td>
                  <td style="vertical-align:middle"></td>
                  <td style="vertical-align:middle">Page Number	</td>
                  <td style="vertical-align:middle">:</td>
                  <td style="text-align:right;vertical-align:middle">1 of 1</td>
                </tr>
                </table>

            </section>

            <section>
              <table class="detailContent" class="text-sm">
                <thead>
                  <tr>
                    <th style="width:6% !important;">Item</th>
                    <th style="width:43% !important;">Description</th>
                    <th style="width:12% !important;">Unit Price<br>(HKD)</th>
                    <th style="width:12% !important;">Quantity</th>
                    <th style="width:14% !important;">Unit</th>
                    <th style="width:13% !important;">Amount<br>(HKD)</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td><b>{{task.job?.company || ""}}<b></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><i><u>{{task.job?.jobdescription || ""}}</u></i></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr v-if="form.words.eng.words || form.words.chi.words" >
                        <td>&nbsp;</td>
                        <td><b>Words:</b></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr v-if="form.words.eng.words">
                        <td>1</td>
                        <td> - Chinese to English</td>
                        <td>${{form.words.eng.price}}</td>
                        <td>{{form.words.eng.words}}</td>
                        <td>Words</td>
                        <td>{{form.words.eng.words * form.words.eng.price > 0 ? digi(form.words.eng.words * form.words.eng.price) : 'Waived'}}</td>
                    </tr>
                    <tr v-if="form.words.chi.words">
                        <td>2</td>
                        <td> - English to Chinese</td>
                        <td>${{form.words.chi.price}}</td>
                        <td>{{form.words.chi.words}}</td>
                        <td>Words</td>
                        <td>{{form.words.chi.words * form.words.chi.price > 0 ? digi(form.words.chi.words * form.words.chi.price) : 'Waived'}}</td>
                    </tr>

                    <tr v-for="item in form.other">
                        <td>3</td>
                        <td>{{item.desc}}OT on 15 Sep (2300-0730)</td>
                        <td>${{item.price}}</td>
                        <td>{{item.qty}}</td>
                        <td>{{item.unit}}</td>
                        <td>{{item.qty * item.price > 0 ? digi(item.qty * item.price) : 'Waived'}}</td>
                    </tr>

                    <tr v-for="item in form.less">
                        <td>3</td>
                        <td>{{item.desc}}</td>
                        <td>${{item.price}}</td>
                        <td>{{item.qty}}</td>
                        <td>{{item.unit}}</td>
                        <td>{{item.qty * item.price > 0 ? digi(item.qty * item.price) : 'Waived'}}</td>
                    </tr>
                    <tr >
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr v-for="(item,index) in CalcItems">
                        <td>{{index+1}}</td>
                        <td>{{item.desc}}</td>
                        <td>${{item.price}}</td>
                        <td>{{item.qty}}</td>
                        <td>{{item.unit}}</td>
                        <td>{{item.qty * item.price > 0 ? digi(item.qty * item.price) : 'Waived'}}</td>
                    </tr>
                    <tr >
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="5" style="text-align:right; padding: 10px 15px;">Total : </th>
                    <th style="padding-right:10px; text-align:right;">{{total > 0 ? digi(total) : 'Waived'}}</th>
                  </tr>
                </tfoot>
              </table>
            </section>

        </div>
        <section style="font-size: xx-small;">
            <div class="flex justify-end my-2">
                <div class="w-1/3 h-24">
                    <img src="/assets/lx_logo.png" alt="" class="h-20 mx-auto mb-1" style="display:block" >
                    <div class="border-t border-black" style="font-size: 9pt">
                        Company Chop
                    </div>
                </div>
            </div>
            <div class="leading-3" style="font-size: 9pt">
                Remarks:<br/>
                1. Payment in full shall be due 30 days after the date of the invoice.<br/>
                2. Any overdue amount is subject to interest payments at a monthly interest rate of 1.5%.<br/>
                3. Cheque should be crossed and made payable to “Lingxpert Language Services Limited”.<br/>
                4. Please quote invoice number on the back of the cheque or of the bank-in receipt (where appropriate).<br/>
                5. No receipt will be issued unless specifically requested.<br/>

            </div>
            <div class="text-center mt-2">
                LingXpert Language Services Limited<br>
                <div class="">
                    <span class="px-2">T 電話: 8101 1028 </span>
                    <span class="px-2">F 傳真: 8101 1281 </span>
                    <span class="px-2">Room 1106, 11/F, Office Plus @ Sheung Wan, 93-103 Wing Lok Street, Sheung Wan, Hong Kong</span>
                    <span class="px-2">香港上環永樂街93-103號協成行上環中心1106室</span>

                </div>
            </div>
        </section>

{{CalcItems}}

        </div>


        <div class="pagebreak"><hr></div>

    </section>
    @endverbatim
    {{-- <script src="{{ admin_asset('@admin/dcat/plugins/vendors.min.js?v2.2.2-beta')}}"></script>
    <script src="{{ admin_asset('@admin/dcat/js/dcat-app.js?v2.2.2-beta')}}"></script> --}}
    <!-- <div class="" style="padding:250px 0"></div> -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/dayjs/1.9.8/dayjs.min.js"></script>
    <script src="//unpkg.com/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/vue@2.7.13"></script>
    <script src="/assets/js/vue.component.js"></script>
    <script type="text/javascript">
        (function () {

            const app = new Vue({
                el: '#vue-app',
                components:{
                    // selecWithAjaxSearch
                },
                data(){
                    return {
                        task_id: @json(request('task_id', null)),
                        loading: false,
                        client: {},
                        task: {},
                        form:{
                            task_id: null,
                            invoiceCode: null,
                            InvoiceNo: null,
                            invoiceDate: dayjs().format('YYYY-MM-DD'),
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
                    CalcItems: function(){
                        const {form:{words,pages,other,less}} = this;
                        const items = _.concat(
                            {...words.eng, qty: words.eng.words, desc:"Words: English to Chinese"},
                            {...words.chi, qty: words.chi.words, desc:"Words: Chinese to English"},
                            {...pages.eng, qty: pages.eng.pages, desc:"Pages: English to Chinese"},
                            {...pages.chi, qty: pages.chi.pages, desc:"Pages: Chinese to English"},
                            other,
                            less
                        );
                        // const total =   this.form.words.eng.price * this.form.words.eng.words + this.form.words.chi.price * this.form.words.chi.words +
                        //                 this.form.pages.eng.price * this.form.pages.eng.pages + this.form.pages.chi.price * this.form.pages.chi.pages +
                        //                 this.form.other.reduce((a,b)=>a + b.price * b.qty,0) -
                        //                 this.form.less.reduce((a,b)=>a + b.price * b.qty,0);
                        console.log(items);
                        return items.filter(function(item){
                            return item.qty > 0;
                        });
                    },
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
                    submitForm: _.debounce(async function(){
                        this.loading = true;
                        const {form, total} = this;
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

                    if (this.task_id) {
                        this.form.task_id = this.task_id;
                        const {data} = await axios.get(`/admin/api/tasks/${this.task_id}`)
                        this.client = data.client;
                        this.task = data;
                    }

                    // if (this.job_id) {
                    //     this.fetchJob()
                    // }
                    // if (this.clone) {
                    //     this.cloneJob()
                    // }


                }
            })

        console.log('所有JS脚本都加载完了');
    })();
    </script>
  </body>
</html>
