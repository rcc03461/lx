<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Order</title>
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
                <img src="/assets/lx_logo.png" alt="" style="height:90px;margin: 0 auto 10px; display:block">
                <!-- <span class="typeTitle" style="float:right;">Translation Invoice</span> -->
            </section>
            <div class="borderContainer">

                <section>

                    <h3 class="font-black text-lg">Purchase Order</h3>
                    <table class="my-2" style="margin-left:1%;margin-right:1%;width:98%;">
                        <tr>
                            <td style="vertical-align:middle;width:13%">Client Ref</td>
                            <td style="vertical-align:middle;width:2%">:</td>
                            <td style="vertical-align:middle;width:45%">{{ $po?->task?->title ?? ' - ' }}</td>
                            <td style="vertical-align:middle;width:1%"></td>
                            <td style="vertical-align:middle;width:20%">PO. No.</td>
                            <td style="vertical-align:middle;width:2%">:</td>
                            <td style="vertical-align:middle;width:22%" class="text-right">{{ $po->code ?? ' - ' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Attention</td>
                            <td>:</td>
                            <td>{{ $po->vendor?->name ?: ' - ' }}</td>
                            <td></td>
                            <td>LingXpert Job No.</td>
                            <td>:</td>
                            <td class="text-right">{{ $po->task?->code ?: ' - ' }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle">Date</td>
                            <td style="vertical-align:middle">:</td>
                            <td style="vertical-align:middle;position:relative">
                                {{ $po->job_date?->format('Y-m-d') ?: ' - ' }}
                            </td>
                            <td style="vertical-align:middle"></td>
                            <td style="vertical-align:middle">Page Number </td>
                            <td style="vertical-align:middle">:</td>
                            <td style="text-align:right;vertical-align:middle">1 of 1</td>
                        </tr>
                    </table>

                    <div class="px-2 py-4">

                        <table class="text-sm w-full ">
                            <thead>
                              <tr>
                                <th class="border-b text-left">No</th>
                                <th class="border-b text-left">Title</th>
                                <th class="border-b text-left">Description</th>
                                <th class="border-b text-left">Qty</th>
                                <th class="border-b text-left">Unit Price</th>
                                <th class="border-b text-right">Amount</th>
                              </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td colspan="6">&nbsp;</td>
                                </tr>
                                @foreach ($po->items as $item)
                                    <tr>
                                        <td class="px-0.5">{{ $loop->index +1 }}</td>
                                        <td class="px-0.5">{{ $item['title'] }}</td>
                                        <td class="px-0.5">{{ $item['description'] }}</td>
                                        <td class="px-0.5">
                                            @if (in_array(Str::lower($item['unit']) , ['hours', 'hour', 'hrs', 'hr']))
                                                {{ number_format($item['qty'], 2) }} {{ $item['unit'] }}
                                                @else
                                                {{ number_format($item['qty']) }} {{ $item['unit'] }}
                                            @endif
                                        </td>
                                        <td class="px-0.5">{{ $item['unit_price'] }}</td>
                                        <td class="text-right px-0.5">{{ number_format($item['qty'] * $item['unit_price'], 2) }}</td>
                                        {{-- <td class="text-right">
                                            {{
                                                match ($item['direction']) {
                                                    'e2c' => 'E > C',
                                                    'c2e' => 'C > E',
                                                    'cross-translation' => 'Cross-Translation',
                                                    'client' => 'Client',
                                                }
                                            }}
                                        </td> --}}
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6">&nbsp;</td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td class="py-2 border-t  text-right" colspan="5" class="text-right">Total</td>
                                    <td class="py-2 border-t  text-right font-bold">{{ number_format(collect($po->items)->sum(fn($item)=> $item['qty'] * $item['unit_price'] ), 2) }}</td>
                                </tr>
                        </table>
                    </div>

                </section>



            </div>
            <section style="font-size: xx-small;">

                <div id="footnote">
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



    </section>

</body>

</html>
