<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task</title>
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
            <section class="mb-1">
              {{-- <img src="/assets/lx_logo.png" alt="" style="height:110px;margin: 0 auto; display:block" > --}}
              <!-- <span class="typeTitle" style="float:right;">Translation Invoice</span> -->
            </section>

            <section>

                @include('components.lx-header')
                <h3 class="text-center text-xl font-bold my-4">Estimated Revenue</h3>
                <div class="text-center">{{$from}} -> {{$to}} <input class="screen-only" type="month"></div>
            </section>

            <hr class="my-4 border-b border-black">

            <section>
              <table class="text-sm w-full">
                <thead>
                  <tr data-selectable>
                    <th class="text-left border-b ">No</th>
                    <th data-sort="lx_no"               class="cursor-pointer text-left border-b ">Lx Ref</th>
                    <th data-sort="job_ref"             class="cursor-pointer text-left border-b ">Job Ref</th>
                    <th data-sort="job_in_date"         class="cursor-pointer text-left border-b ">Job In</th>
                    <th data-sort="end_date"            class="cursor-pointer text-left border-b ">Job End</th>
                    <th data-sort="title"               class="cursor-pointer text-left border-b ">Title</th>
                    <th data-sort="estimated_revenue"   class="cursor-pointer text-right border-b ">Sales</th>
                  </tr>
                </thead>

                <tbody class="text-xs">
                        @foreach ($tasks as $task)
                            <tr @class([
                                'bg-gray-100' => $loop->even,
                            ])>
                                <td>{{ $loop->index +1 }}</td>
                                <td>{{ $task->code }}</td>
                                <td>{{ $task->job?->code }}</td>
                                <td>{{ $task->job_in_date->format('Y-m-d') }}</td>
                                <td>{{ $task->end_date->format('Y-m-d') }}</td>
                                <td>{{ $task->title }}</td>
                                <td class="text-right">{{ number_format($task->estimated_revenue, 2) }}</td>
                            </tr>
                        @endforeach
                </tbody>

                <tfoot class="text-sm">
                    <tr>
                        <td class="border-t border-black"></td>
                        <td class="border-t border-black"></td>
                        <td class="border-t border-black"></td>
                        <td class="border-t border-black"></td>
                        <td class="border-t border-black"></td>
                        <td class="border-t border-black text-right px-4">Total :</td>
                        <td class="border-t border-black text-right">{{ number_format($tasks->sum('estimated_revenue'), 2) }}</td>
                    </tr>
                </tfoot>

              </table>
            </section>

        </div>

        </div>
    </section>


    {{-- dayjs --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.9.8/dayjs.min.js"></script>
    <script>
        let orderby = '{{$orderby}}';
        let from = '{{$from}}';
        let to = '{{$to}}';

        document.querySelectorAll('[data-sort]').forEach(el => {
            el.addEventListener('click', (e) => {
                const sort = e.target.dataset.sort
                window.location.href = `/admin/print/estimated-revenue?from=${from}&to=${to}&orderby=${orderby}`
            })
        })

        const month = document.querySelector('input[type="month"]')
        month.addEventListener('change', (e) => {
            const date = dayjs(e.target.value)
            const mfrom = date.startOf('month').format('YYYY-MM-DD')
            const mto = date.endOf('month').format('YYYY-MM-DD')
            window.location.href = `/admin/print/estimated-revenue?from=${mfrom}&to=${mto}&orderby=${orderby}`
        })






    </script>


  </body>
</html>
