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

              <h3 class="text-center text-xl font-bold my-4">Task</h3>
              <table style="margin-left:1%;margin-right:1%;width:98%;">
                <tr>
                  <tr>
                    <td style="vertical-align:top">Company</td>
                    <td style="vertical-align:top">:</td>
                    <td colspan="5" class="whitespace-pre-line" style="line-height:1.3">{{$task->client->name}}</td>
                  </tr>
                </tr>
                <tr>
                  <td style="vertical-align:middle;width:13%">Client Ref</td>
                  <td style="vertical-align:middle;width:2%">:</td>
                  <td style="vertical-align:middle;width:45%">{{$task?->job?->job_code ?: ""}}</td>
                  <td style="vertical-align:middle;width:1%"></td>
                  <td style="vertical-align:middle;width:20%">LingXpert Job No.</td>
                  <td style="vertical-align:middle;width:2%">:</td>
                  <td style="vertical-align:middle;width:22%" class="text-right">{{$task->code}}</td>
                </tr>
                <tr>
                  <td style="vertical-align:middle">Date</td>
                  <td style="vertical-align:middle">:</td>
                  <td style="vertical-align:middle;position:relative">{{$task->job_in_date}}</td>
                  <td style="vertical-align:middle"></td>
                  <td style="vertical-align:middle">Publish Date</td>
                  <td style="vertical-align:middle">:</td>
                  <td style="text-align:right;vertical-align:middle">{{$task->publish_date}}</td>
                </tr>
                </table>

            </section>

            <hr class="my-4 border-b border-black">

            <section>
              <table class="text-sm w-full">
                <thead>
                  <tr>
                    <th class="border-b text-left">Item</th>
                    <th class="border-b text-left">Section</th>
                    <th class="border-b text-right">Direction</th>
                  </tr>
                </thead>

                <tbody>
                    @if ($task->meta)
                        @foreach ($task->meta as $item)
                            <tr>
                                <td>{{ $loop->index +1 }}</td>
                                <td>{{ $item['section'] }}</td>
                                <td class="text-right">
                                    {{
                                        match ($item['direction']) {
                                            'e2c' => 'E > C',
                                            'c2e' => 'C > E',
                                            'cross-translation' => 'Cross-Translation',
                                            'client' => 'Client',
                                        }
                                    }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
              </table>
            </section>

        </div>





        </div>



    </section>

  </body>
</html>
