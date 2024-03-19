<div>
    <body>
        <h1>{{ LaravelGmail::user() }}</h1>
        @if(LaravelGmail::check())
            <a href="{{ url('oauth/gmail/logout') }}">logout</a>
        @else
            <a href="{{ url('oauth/gmail') }}">login</a>
        @endif

        <table>
            @foreach ($messages as $item)
            <tr class="">
                <td>{{ $item->getId()  }}</td>
                <td>{{ $item->getFromName() }}</td>
                <td>{{ $item->getSubject() }}</td>
                <td>{{ collect($item->getLabels())->join(",") }}</td>
                <td>{{ $item->getDate()  }}</td>
                <td><a href="/admin/control_panel/action/{{$item->getId()}}">Action</a></td>
                {{-- <td>{!! $item->getHtmlBody() !!}</td> --}}
                {{-- <td>{{ $item->load }}</td> --}}
            </tr>
            @endforeach
        </table>

    </body>
</div>
