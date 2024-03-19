<div class="flex gap-1 items-center">
    <div>
        @foreach ($labels as $item)
            @if ( $item->type == 'user')
                <span
                {{-- class="row-labels" --}}
                @class([
                    'row-labels',
                    "text-[".$item->color?->textColor."]" => true,
                    "bg-[".$item->color?->backgroundColor."]" => true,
                ])
                >{{$item['name']}}</span>
            @endif
        @endforeach
    </div>
    <span class="line-clamp-1 flex-1">

        {{ $subject }}
    </span>
    <span class="float-right">
        {{ $email_datetime }}
    </span>
</div>


