<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Statement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.1.8/base.css"> --}}
    {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css"> --}}

    <style>
        @media print {
            .screen-only {
                display: none !important;
            }
        }
    </style>
  </head>
  <body >

    <section id="vue-app">


        <div class="max-w-3xl mx-auto bg-white p-4">
          <div class="borderContainer">
            <section>
                @include('components.lx-header')
                <h3 class="text-center text-xl font-bold my-4">Statement</h3>
                <div class="text-center">{{$from}} -> {{$to}} <input class="screen-only" type="month"> <button id="toggleSettled" class="screen-only border py-1 px-2 rounded hover:bg-gray-300">Toggle Settled</button></div>


                <table class="w-full">
                    <tr>
                        <td class="w-24">TO</td>
                        <td></td>
                        <td>LingXpert Language Services Limited</td>
                    </tr>
                    <tr>
                        <td class="w-24">Address</td>
                        <td></td>
                        <td>Room 1106, OfficePlus @Sheung Wan,<br/>93-103 WingLok Street,<br/>Sheung Wan, Hong Kong</td>
                    </tr>
                    <tr>
                        <td class="w-24">Contact</td>
                        <td></td>
                        <td>Rose Yip</td>
                    </tr>
                    <tr>
                        <td class="w-24">&nbsp;</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="w-24">Name</td>
                        <td></td>
                        <td>{{$vendor->name}}</td>
                    </tr>
                    <tr>
                        <td class="w-24">Address</td>
                        <td></td>
                        <td>{{$vendor->address}}</td>
                    </tr>
                    <tr>
                        <td class="w-24">Tel</td>
                        <td></td>
                        <td>{{$vendor->phone}}</td>
                    </tr>
                    <tr>
                        <td class="w-24">Email</td>
                        <td></td>
                        <td>{{$vendor->email}}</td>
                    </tr>
                </table>

            </section>

            <hr class="my-4 border-b border-black">

            <section>
              <table class="text-sm w-full">
                <thead>
                  <tr data-selectable>
                    <th                                 class="text-left border-b ">No</th>
                    <th data-sort="po_no"               class="cursor-pointer text-left border-b ">PO No.</th>
                    <th data-sort="job_date"            class="cursor-pointer text-left border-b ">Job date</th>
                    <th data-sort="settled_at"          class="cursor-pointer text-left border-b ">Settled At</th>
                    <th                                 class="cursor-pointer text-left border-b ">Ref</th>
                    <th data-sort="total"               class="cursor-pointer text-right border-b w-32 pr-2">Amount</th>
                  </tr>
                </thead>

                <tbody class="text-xs">
                    <tr>
                        <td colspan="6" class="text-center">&nbsp;</td>
                    </tr>
                    @foreach ($pos as $item)
                        <tr
                            @class([
                                'bg-gray-100' => $loop->even,
                            ])
                            data-is-settled="{{$item->is_settled ? 'yes' : 'no'}}"
                        >
                            <td>{{ $loop->index +1 }}</td>
                            <td>{{ $item->po_no }}</td>
                            <td>{{ $item->job_date->format('Y-m-d') }}</td>
                            <td>{{ $item->settled_at?->format('Y-m-d') ?: "" }}</td>
                            <td>{{ $item->settled_ref }}</td>
                            <td class="text-right pr-2" data-total="{{$item->total}}">{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" class="text-center">&nbsp;</td>
                    </tr>
                </tbody>

                <tfoot class="text-sm">
                    <tr>
                        <td class="border-t border-black">Total :</td>
                        <td class="border-t border-black"></td>
                        <td class="border-t border-black"></td>
                        <td class="border-t border-black"></td>
                        <td class="border-t border-black"></td>
                        <td class="border-t border-black text-right font-bold">
                            <div class="border-b-4 border-double border-black  pr-2">
                                <span>HK$ </span><span id="total">{{ number_format($pos->sum('total'), 2) }}</span>
                            </div>
                        </td>
                    </tr>
                </tfoot>

              </table>
            </section>

        </div>

        <div class="whitespace-pre-line text-sm mt-12">{{ $vendor->remark }}</div>

        </div>
    </section>


    {{-- dayjs --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.9.8/dayjs.min.js"></script>
    <script>

        let vendor_id = '{{$vendor->id}}';
        let orderby = '{{$orderby}}';
        let from = '{{$from}}';
        let to = '{{$to}}';

        function displayDollerFormat( doller ){
            return new Intl.NumberFormat('en-US', {maximumFractionDigits:2,
                minimumFractionDigits:2,
            }).format(doller)
        }


        document.querySelectorAll('[data-sort]').forEach(el => {
            el.addEventListener('click', (e) => {
                const sort = e.target.dataset.sort
                window.location.href = `/admin/print/vendors/${vendor_id}/statement?from=${from}&to=${to}&orderby=${orderby}`
            })
        })

        const month = document.querySelector('input[type="month"]')
        month.addEventListener('change', (e) => {
            const date = dayjs(e.target.value)
            const mfrom = date.startOf('month').format('YYYY-MM-DD')
            const mto = date.endOf('month').format('YYYY-MM-DD')
            window.location.href = `/admin/print/vendors/${vendor_id}/statement?from=${mfrom}&to=${mto}&orderby=${orderby}`
        })

        let showSettled = true
        let total = 0
        const toggleSettled = document.querySelector('#toggleSettled');
        toggleSettled.addEventListener('click', (e) => {
            total = 0
            showSettled = !showSettled
            document.querySelectorAll('[data-is-settled]').forEach(el => {
                if (showSettled) {
                    el.style.display = 'table-row'
                } else {
                    if (el.dataset.isSettled == 'yes') {
                        el.style.display = 'none'
                    } else {
                        el.style.display = 'table-row'
                    }
                }
            })

            document.querySelectorAll( showSettled ? `[data-total]` : `[data-is-settled="no"] [data-total]` ).forEach(el => {
                total += parseFloat(el.dataset.total)
            })
            document.querySelector('#total').innerHTML = displayDollerFormat(total)

        })

    </script>


  </body>
</html>
