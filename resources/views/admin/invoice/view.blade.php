<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.1.8/base.css"> --}}
    {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css"> --}}
    <style media="print">
        .ui-pnotify.ui-pnotify-fade-normal.ui-pnotify-in.ui-pnotify-fade-in.ui-pnotify-move,
        .ui-pnotify {
            display: none !important;
        }

        .pagebreak hr {
            display: none;
        }

        .hidden-print {
            display: none;
        }

        body {
            -webkit-print-color-adjust: exact;
        }

        #footnote {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding-bottom: 4px;
            border-bottom: 8px solid #006600;
        }
    </style>
    <style>
        .datetimepicker {
            position: relative;
        }

        select {
            border: 0;
        }

        body * {
            box-sizing: border-box;
            font-size: 9px;
        }

        body {
            box-sizing: border-box;
            background-color: rgb(240, 240, 240);
        }

        .bold * {
            font-weight: bold;
        }

        .np {
            padding: 0 !important;
        }

        .typeTitle {
            font-size: 50px;
            color: #fff;
            background: #000;
            padding: 0px 20px;
            border: 2px solid #000;
        }

        @media print {

            input,
            textarea,
            select {
                border: none;
            }
        }

        input,
        textarea,
        select {
            /*border: 1px solid #000;*/
            width: 100%;
            padding: 2px 5px;
        }

        .serviceLevel {
            padding: 4px 3px;
            border: 1px solid #000;
        }

        .edited,
        .edited input {
            background-color: rgb(238, 123, 74);
        }

        .container {
            width: 768px;
            padding: 10px;
            /*width:595px;*/
            margin: 0 auto;
            min-height: 700px;
            background-color: #fff;
        }

        table {
            width: 100%;
        }

        table tr td {
            padding: 1px 0;
        }

        .flex-col {
            padding: 3px 5px;
            display: flex;
            flex-direction: column;
        }

        .flex-row {
            padding: 3px 5px;
            display: flex;
            flex-direction: row;
        }

        table.bordered td {
            border: 1px solid #000;
            vertical-align: middle;
            text-align: center;
        }

        table.bordered input {
            border: 0 !important;

        }

        .col1big td:nth-of-type(1) {
            width: 200px;
        }

        .bottomLineInput input {
            border: 0px;
        }

        .pagebreak {
            page-break-before: always;
        }

        .fatBorder {
            border: 2px solid #000;
        }

        .fatBorder thead td {
            padding: 5px 0;
        }

        .fatBorder thead tr {
            border-bottom: 2px solid #000;
        }


        .smallFont td {
            padding: 2px 0;
        }

        .narrowInput input {
            padding: 0 5px;
        }

        #ProofSeq input,
        #ALT input {
            text-align: center;
        }

        table thead tr th {
            text-align: center;
            font-weight: bold;
            font-style: italic;
            font-size: 12px;
        }

        table tbody tr td {
            vertical-align: top;
        }

        .borderContainer {
            border: 2px solid rgb(0, 0, 0);
        }

        .borderContainer * {
            font-size: 12px;
        }

        h3 {
            padding: 6px 0;
            text-align: center;
            /* border-top: 2px solid rgb(0, 0, 0); */
            border-bottom: 1px solid rgb(0, 0, 0);
        }

        .detailContent {
            /*border-top: 1px solid rgb(0, 0, 0);*/

        }

        .detailContent thead {
            background-color: #99ccff !important;
        }

        @media print {
            .detailContent thead {
                background-color: #99ccff !important;
            }
        }

        .detailContent thead tr th {
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
        .detailContent tbody tr:last-of-type td {
            border-bottom: 1px solid rgb(0, 0, 0);
        }

        .detailContent thead tr th:not(:last-child),
        .detailContent tbody tr td:not(:last-child) {
            border-right: 1px solid rgb(0, 0, 0);
        }

        .detailContent tr td {
            padding: 3px 5px;
        }

        .detailContent tbody tr td {
            white-space: normal;
            padding: 3px 10px;
        }

        .detailContent tbody tr td:first-child {
            text-align: center;
        }

        .detailContent tbody tr td:nth-child(3),
        .detailContent tbody tr td:nth-child(4),
        .detailContent tbody tr td:last-child {
            text-align: right;
        }
    </style>
</head>

<body>

    <section id="vue-app">


        <div class="max-w-3xl mx-auto bg-white p-4">
            <section class="mb-1">
                @include('components.lx-header')
                <!-- <span class="typeTitle" style="float:right;">Translation Invoice</span> -->
            </section>
            <div class="borderContainer">

                <section>

                    <h3 class="font-black text-lg">INVOICE</h3>
                    <table class="my-2" style="margin-left:1%;margin-right:1%;width:98%;">
                        <tr>
                            <td style="vertical-align:middle;width:13%">Client Ref</td>
                            <td style="vertical-align:middle;width:2%">:</td>
                            <td style="vertical-align:middle;width:45%"><Editable v-model="invoice.self_ref" type="text" @input="()=>edited = true"/></td>
                            <td style="vertical-align:middle;width:1%"></td>
                            <td style="vertical-align:middle;width:20%">Invoice Number</td>
                            <td style="vertical-align:middle;width:2%">:</td>
                            <td style="vertical-align:middle;width:22%" class="text-right">{{ $invoice->code ?? ' - ' }}
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td style="vertical-align:top">Company</td>
                            <td style="vertical-align:top">:</td>
                            <td colspan="5" class="whitespace-pre-line" style="line-height:1.3">{{ $invoice->localtask?->client->name ?? $invoice->task?->client->name ?? ($cre->name ?? ' - ') }}<br>{!! nl2br($invoice->localtask?->client->address ?? $invoice->task?->client->address ?: $cre->address ?? ' - ') !!}</td>
                        </tr>
                        </tr>
                        <tr>
                            <td>Attention</td>
                            <td>:</td>
                            <td>{{$invoice->localtask?->client->attn ?? $invoice->task?->client->attn ?? ($cre->attn ?? ' - ') }}</td>
                            <td></td>
                            <td>LingXpert Job No.</td>
                            <td>:</td>
                            <td class="text-right">{{ $invoice->localtask?->code ?? $invoice->task?->code ?: ' - ' }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle">Date</td>
                            <td style="vertical-align:middle">:</td>
                            <td style="vertical-align:middle;position:relative">
                                {{ $invoice->invoiceDate?->format('Y-m-d') ?: ' - ' }}
                            </td>
                            <td style="vertical-align:middle"></td>
                            <td style="vertical-align:middle">Page Number </td>
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
                                <td><b>{{ $invoice->job?->company ??  $invoice->localtask?->title ?? $invoice->task?->client?->name ?? ' - ' }}<b>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><i><u>{{ $invoice->job?->jobdescription ?? $invoice->localtask?->description  ?? $invoice->task?->description ?? ' - ' }}</u></i>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            @if ($invoice->localtask?->remark)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><i><u>{{ $invoice->localtask?->remark }}</u></i>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endif
                            @php
                                $i = 1;
                            @endphp
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            {{-- words --}}
                            @if ($invoice->words->eng?->words || $invoice->words->chi?->words)

                                <tr>
                                    <td>&nbsp;</td>
                                    <td><b>Words:</b></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @if ($invoice->words->eng?->words)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td> - Chinese to English</td>
                                        <td>${{ number_format($invoice->words->eng?->price, 2) }}</td>
                                        <td>{{ number_format($invoice->words->eng?->words) }}</td>
                                        <td class="text-right">Words</td>
                                        <td>{{ $invoice->words->eng?->words * $invoice->words->eng?->price > 0 ? "$ ". number_format($invoice->words->eng?->words * $invoice->words->eng?->price, 2) : 'Waived' }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($invoice->words->chi?->words)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td> - English to Chinese</td>
                                        <td>${{ number_format($invoice->words->chi?->price, 2) }}</td>
                                        <td>{{ number_format($invoice->words->chi?->words) }}</td>
                                        <td class="text-right">Words</td>
                                        <td>{{ $invoice->words->chi?->words * $invoice->words->chi?->price > 0 ? "$ ". number_format($invoice->words->chi?->words * $invoice->words->chi?->price, 2) : 'Waived' }}
                                        </td>
                                    </tr>
                                @endif
                            @endif

                            {{-- pages --}}
                            @if ($invoice->pages->eng?->pages || $invoice->pages->chi?->pages)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><b>Pages:</b></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @if ($invoice->pages->eng?->pages)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td> - Chinese to English</td>
                                        <td>${{ number_format($invoice->pages->eng?->price, 2) }}</td>
                                        <td>{{ number_format($invoice->pages->eng?->pages) }}</td>
                                        <td class="text-right">Pages</td>
                                        <td>{{ $invoice->pages->eng?->pages * $invoice->pages->eng?->price > 0 ? "$ ". number_format($invoice->pages->eng?->pages * $invoice->pages->eng?->price, 2) : 'Waived' }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($invoice->pages->chi?->pages)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td> - English to Chinese</td>
                                        <td>${{ number_format($invoice->pages->chi?->price, 2) }}</td>
                                        <td>{{ number_format($invoice->pages->chi?->pages) }}</td>
                                        <td class="text-right">Pages</td>
                                        <td>{{ $invoice->pages->chi?->pages * $invoice->pages->chi?->price > 0 ? "$ ". number_format($invoice->pages->chi?->pages * $invoice->pages->chi?->price, 2) : 'Waived' }}
                                        </td>
                                    </tr>
                                @endif
                            @endif

                            {{-- other --}}
                            @if ($invoice->other)
                                @foreach ($invoice->other as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item['desc'] }}</td>
                                        <td>${{ number_format($item['price'], 2) }}</td>
                                        <td>{{ number_format($item['qty']) }}</td>
                                        <td class="text-right">{{ $item['unit'] }}</td>
                                        <td>{{ $item['qty'] * $item['price'] > 0 ? "$ ". number_format($item['qty'] * $item['price'], 2) : 'Waived' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif


                            {{-- less --}}
                            @if ($invoice->less)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><b>Less:</b></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @foreach ($invoice->less as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item['desc'] }}</td>
                                        <td>${{ number_format($item['price'], 2) }}</td>
                                        <td>{{ number_format($item['qty']) }}</td>
                                        <td class="text-right">{{ $item['unit'] }}</td>
                                        <td>({{ $item['qty'] * $item['price'] > 0 ? "$ ". number_format($item['qty'] * $item['price'], 2) : 'Waived' }})
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endif
                            <tr>
                                <td>&nbsp;</td>
                                <td style="white-space: pre-line;">{{ $invoice->tranRemark }}</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>


                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align:right; padding: 10px 15px;">Total : </th>
                                <th style="padding-right:10px; text-align:right;">
                                    {{ $invoice->total > 0 ? "$ ". number_format($invoice->total, 2) : 'Waived' }}
                                </th>
                            </tr>
                        </tfoot>
                        {{--

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
                </tbody>

                --}}

                    </table>
                </section>

            </div>
            <section style="font-size: xx-small;">
                <div class="flex justify-end my-2">
                    <div class="w-2/5 h-24 relative">
                        <span class="text-sm">Lingxpert Language Services Limited</span>
                        <img src="/assets/LXChop.jpg" alt="" class="absolute right-8 h-20 mx-auto mb-1"
                            style="display:block;">
                        <div class="mt-20 border-t border-black relative z-10" style="font-size: 9pt">
                            Company Chop
                        </div>
                    </div>
                </div>

                <div id="footnote">

                    <div class="mb-4">
                        <span class="font-bold">Bank Account Information</span>
                        <ul>
                            <li class="flex">
                                <span class="w-1/6">Beneficiary Name:</span>
                                <span class="flex-1">Lingxpert Language Services Limited</span>
                            </li>
                            <li class="flex">
                                <span class="w-1/6">Account Number:</span>
                                <span class="flex-1">400-882171-838</span>
                            </li>
                            <li class="flex">
                                <span class="w-1/6">Bank Name:</span>
                                <span class="flex-1">The Hongkong and Shanghai Banking Corporation Limited</span>
                            </li>
                            <li class="flex">
                                <span class="w-1/6">Bank Address:</span>
                                <span class="flex-1">HSBC Main Building, No. 1 Queen’s Road Central, Central, Hong
                                    Kong</span>
                            </li>
                            <li class="flex">
                                <span class="w-1/6">Swift Code: </span>
                                <span class="flex-1">HSBCHKHHHKH</span>
                            </li>
                        </ul>

                    </div>

                    <div class="leading-3" style="font-size: 9pt">
                        Remarks:<br />
                        <ul>
                            <li class="flex">
                                <span class="w-6">1. </span>
                                <span>Payment in full shall be due 30 days after the date of the invoice.</span>
                            </li>
                            <li class="flex">
                                <span class="w-6">2. </span>
                                <span>Any overdue amount is subject to interest payments at a monthly interest rate of
                                    1.5%.</span>
                            </li>
                            <li class="flex">
                                <span class="w-6">3. </span>
                                <span>Cheque should be crossed and made payable to “Lingxpert Language Services
                                    Limited”.</span>
                            </li>
                            <li class="flex">
                                <span class="w-6">4. </span>
                                <span>Please quote invoice number on the back of the cheque or of the bank-in receipt
                                    (where appropriate).</span>
                            </li>
                            <li class="flex">
                                <span class="w-6">5. </span>
                                <span>No receipt will be issued unless specifically requested.</span>
                            </li>
                        </ul>
                        <br />

                    </div>
                    <div class="text-center mt-2 leading-3">
                        <div class="text-xs my-1 font-black" style="color:#006600">
                            LingXpert Language Services Limited
                        </div>
                        <div class="text-gray-500">
                            <span class="px-2">T 電話: 8101 1028 </span>
                            <span class="px-2">F 傳真: 8101 1281 </span>
                            <span class="px-2">Room 1106, 11/F, Office Plus @ Sheung Wan, 93-103 Wing Lok Street,
                                Sheung Wan, Hong Kong</span>
                            <div class="px-2">香港上環永樂街93-103號協成行上環中心1106室</div>

                        </div>
                    </div>
                </div>
            </section>


        </div>


        <div class="pagebreak">
            <hr>
        </div>

        <div v-show="edited" class="screen-only fixed bottom-2 right-2 w-24 h-24 flex flex-col justify-center text-center border rounded bg-red-300 hover:bg-red-200 cursor-pointer" @click="submitInvoice">
            Save
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    {{-- <script src="/assets/js/vue.component.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    {{-- axios --}}
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    {{-- <script src="/assets/js/vue.components.js"></script> --}}
    <script type="module">
        function displayDollerFormat( doller, min = 0, whenZero = null ){
            if (+doller == 0 && whenZero) return whenZero;
            return new Intl.NumberFormat('en-US', {maximumFractionDigits:2, minimumFractionDigits:min}).format(doller)
        }
        function uuid() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }
        function popup( url ) {
            window.open(url, '_blank', 'location=yes,height=950,width=1200,scrollbars=yes,status=yes');
        }
        // import { createApp } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
        const { createApp , defineComponent } = Vue;

            const Editable = defineComponent ({
                template: `<div class="hover:bg-gray-100" @dblclick="startEdit">
                                <textarea
                                    class="w-full px-1"
                                    ref="textarea"
                                    v-if="editing && type == 'textarea'"
                                    :value="modelValue"
                                    @focus="resize"
                                    @change="handleChange"
                                    @blur="handleBlur"></textarea>
                                <input
                                    class="w-full px-1"
                                    ref="textarea"
                                    :type="type"
                                    v-if="editing && type != 'textarea'"
                                    :value="modelValue"
                                    @focus="resize"
                                    @change="handleChange"
                                    @blur="handleBlur" />
                                <div v-show="!editing">@{{prefix}} @{{type == 'number' ? displayDollerFormat(modelValue) : modelValue}} @{{suffix}}</div>
                                <div v-show="!editing && !modelValue" class="screen-only"> --- </div>
                            </div>`,
                props: {
                    modelValue: String | Number,

                    prefix: {
                        type: String,
                        default: ''
                    },
                    suffix: {
                        type: String,
                        default: ''
                    },
                    type: {
                        type: String,
                        default: 'textarea'
                    }
                },
                data() {
                    return {
                        editing: false,
                    }
                },
                methods: {
                    displayDollerFormat,
                    startEdit() {
                        this.editing = true;
                        this.$nextTick(() => {
                            this.$refs.textarea.focus();
                        });
                    },
                    resize() {
                        const { textarea } = this.$refs;
                        textarea.style.height = textarea.scrollHeight + 'px';
                    },
                    handleChange(){
                        this.$emit('update:modelValue', this.$refs.textarea.value);
                        this.resize();
                    },
                    handleBlur(){
                        this.editing = false;
                        this.$emit('update:modelValue', this.$refs.textarea.value);
                    }
                }
            })


            createApp({
                components: {
                    Editable
                },
                data() {
                    return {
                        edited: false,
                        invoice:{
                            id: @json($invoice->id),
                            self_ref: @json($invoice?->self_ref ?? $invoice?->job?->job_code ?? $invoice->localtask?->code ?? $invoice->task?->code ?? ' - '),
                        }
                    }
                },
                watch:{
                },
                methods: {
                    popup,
                    displayDollerFormat,
                    submitInvoice(){
                        const { invoice } = this;
                        axios.post('/admin/api/invoice', invoice)
                        .then(res => {
                            console.log(res);
                            this.edited = false;
                        })
                        .catch(err => {
                            console.log(err);
                        })
                        console.log(invoice);
                    }
                },
                mounted() {
                    // this.getJobsInvoices();
                    // console.log('this.invoice');
                }
            })
            .mount('#vue-app')


    </script>


</body>

</html>
