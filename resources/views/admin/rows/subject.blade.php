<div class="flex gap-1 items-center">
    <div>
        <x-labels :labels="$labels" />
        {{-- @foreach ($labels as $item)
                <span
                @class([
                    'email-label',
                    'row-labels',
                    "text-[".$item->color?->textColor."]" => true,
                    "bg-[".$item->color?->backgroundColor."]" => true,
                    "bg-yellow-500" => $item['name'] == 'INBOX',
                    "bg-green-500" => $item['name'] == 'DRAFT',
                    "bg-blue-500" => $item['name'] == 'IMPORTANT',
                    "bg-red-500" => $item['name'] == 'SENT',
                    "text-bold" => $item['name'] == 'UNREAD',
                ])
                >{{$item['name']}}</span>
        @endforeach --}}
    </div>
    <span class="email-subject line-clamp-2 flex-1">
        {{ $subject }}
        @if ($ref)
            <span class="text-gray-300 font-normal text-sm ml-1">{{$ref}}</span>
        @endif
    </span>
    @if ($has_attachments)
    <span>
        <a href="#">
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
            </svg>
        </a>
    </span>
    @endif
    <span class="float-right">
        {{ $email_datetime }}
    </span>
</div>


