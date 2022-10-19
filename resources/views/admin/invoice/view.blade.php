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

    <section id="vue-app">


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
                  <td style="vertical-align:middle;width:45%">{{$invoice->task?->job?->job_code ?: " - "}}</td>
                  <td style="vertical-align:middle;width:1%"></td>
                  <td style="vertical-align:middle;width:20%">Invoice Number</td>
                  <td style="vertical-align:middle;width:2%">:</td>
                  <td style="vertical-align:middle;width:22%" class="text-right">{{$invoice->InvoiceNo ?: " - "}}</td>
                </tr>
                <tr>
                  <tr>
                    <td style="vertical-align:top">Company</td>
                    <td style="vertical-align:top">:</td>
                    <td colspan="5" class="whitespace-pre-line" style="line-height:1.3">{{$invoice->task->client->name ?: " - "}}<br>{{$invoice->task->client->address ?: " - "}}</td>
                  </tr>
                </tr>
                <tr>
                  <td>Attention</td>
                  <td>:</td>
                  <td>{{$invoice->task->client->attn ?: " - "}}</td>
                  <td></td>
                  <td>LingXpert Job No.</td>
                  <td>:</td>
                  <td class="text-right">{{$invoice->task->code ?: " - "}}</td>
                </tr>
                <tr>
                  <td style="vertical-align:middle">Date</td>
                  <td style="vertical-align:middle">:</td>
                  <td style="vertical-align:middle;position:relative">
                        {{$invoice->invoiceDate ?: " - "}}
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
                        <td><b>{{$invoice->task?->job?->company ?: " - "}}<b></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><i><u>{{$invoice->task?->job?->jobdescription ?: " - "}}</u></i></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @php
                        $i = 1;
                    @endphp
                    {{-- words --}}
                    @if ($invoice->words->eng?->words || $invoice->words->chi?->words )
                        <tr>
                            <td>&nbsp;</td>
                            <td><b>Words:</b></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endif
                    @if ($invoice->words->eng?->words)
                        <tr>
                            <td>{{$i++}}</td>
                            <td> - Chinese to English</td>
                            <td>${{$invoice->words->eng?->price}}</td>
                            <td>{{$invoice->words->eng?->words}}</td>
                            <td>Words</td>
                            <td>{{$invoice->words->eng?->words * $invoice->words->eng?->price > 0 ? number_format($invoice->words->eng?->words * $invoice->words->eng?->price, 2) : 'Waived'}}</td>
                        </tr>
                    @endif
                    @if ($invoice->words->chi?->words)
                        <tr>
                            <td>{{$i++}}</td>
                            <td> - English to Chinese</td>
                            <td>${{$invoice->words->chi?->price}}</td>
                            <td>{{$invoice->words->chi?->words}}</td>
                            <td>Words</td>
                            <td>{{$invoice->words->chi?->words * $invoice->words->chi?->price > 0 ? number_format($invoice->words->chi?->words * $invoice->words->chi?->price, 2) : 'Waived'}}</td>
                        </tr>
                    @endif

                    {{-- pages --}}
                    @if ($invoice->words->eng?->words || $invoice->words->chi?->words )
                        <tr>
                            <td>&nbsp;</td>
                            <td><b>Pages:</b></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endif
                    @if ($invoice->pages->eng?->pages)
                        <tr>
                            <td>{{$i++}}</td>
                            <td> - Chinese to English</td>
                            <td>${{$invoice->pages->eng?->price}}</td>
                            <td>{{$invoice->pages->eng?->pages}}</td>
                            <td>Pages</td>
                            <td>{{$invoice->pages->eng?->pages * $invoice->pages->eng?->price > 0 ? number_format($invoice->pages->eng?->pages * $invoice->pages->eng?->price, 2) : 'Waived'}}</td>
                        </tr>
                    @endif
                    @if ($invoice->pages->chi?->pages)
                        <tr>
                            <td>{{$i++}}</td>
                            <td> - English to Chinese</td>
                            <td>${{$invoice->pages->chi?->price}}</td>
                            <td>{{$invoice->pages->chi?->pages}}</td>
                            <td>Pages</td>
                            <td>{{$invoice->pages->chi?->pages * $invoice->pages->chi?->price > 0 ? number_format($invoice->pages->chi?->pages * $invoice->pages->chi?->price, 2) : 'Waived'}}</td>
                        </tr>
                    @endif

                    {{-- other --}}
                    @foreach ($invoice->other as $item)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$item['desc']}}</td>
                            <td>${{$item['price']}}</td>
                            <td>{{$item['qty']}}</td>
                            <td>{{$item['unit']}}</td>
                            <td>{{$item['qty'] * $item['price'] > 0 ? number_format($item['qty'] * $item['price'], 2) : 'Waived'}}</td>
                        </tr>
                    @endforeach

                    {{-- less --}}
                    @if ($invoice->other )
                        <tr>
                            <td>&nbsp;</td>
                            <td><b>Less:</b></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endif
                    @foreach ($invoice->less as $item)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$item['desc']}}</td>
                            <td>${{$item['price']}}</td>
                            <td>{{$item['qty']}}</td>
                            <td>{{$item['unit']}}</td>
                            <td>({{$item['qty'] * $item['price'] > 0 ? number_format($item['qty'] * $item['price'], 2) : 'Waived'}})</td>
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
                    <tr>
                        <td>&nbsp;</td>
                        <td style="white-space: pre-line;">{{$invoice->tranRemark}}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>


                    <tfoot>
                        <tr>
                            <th colspan="5" style="text-align:right; padding: 10px 15px;">Total : </th>
                            <th style="padding-right:10px; text-align:right;">
                                {{ $invoice->total > 0 ? number_format($invoice->total, 2) : 'Waived' }}
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
                <div class="w-1/3 h-24">
                    <img src="/assets/chop.png" alt="" class="h-20 mx-auto mb-1" style="display:block" >
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
                <div class="my-1">
                    LingXpert Language Services Limited
                </div>
                <div class=""  style="font-size: 9pt">
                    <span class="px-2">T 電話: 8101 1028 </span>
                    <span class="px-2">F 傳真: 8101 1281 </span>
                    <span class="px-2">Room 1106, 11/F, Office Plus @ Sheung Wan, 93-103 Wing Lok Street, Sheung Wan, Hong Kong</span>
                    <span class="px-2">香港上環永樂街93-103號協成行上環中心1106室</span>

                </div>
            </div>
        </section>


        </div>


        <div class="pagebreak"><hr></div>

    </section>

  </body>
</html>