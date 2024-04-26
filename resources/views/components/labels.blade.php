
@php
    $labels = collect($labels);
    $is_inbox = $labels->contains('name', 'INBOX');
    $is_draft = $labels->contains('name', 'DRAFT');
    $is_important = $labels->contains('name', 'IMPORTANT');
    $is_sent = $labels->contains('name', 'SENT');
    $is_personal = $labels->contains('name', 'CATEGORY_PERSONAL');
    $labels = $labels->filter(function ($label) {
        return !in_array($label['name'], ['UNREAD', 'INBOX', 'DRAFT', 'IMPORTANT', 'SENT', 'CATEGORY_PERSONAL']);
    });
@endphp

{{-- @if ($is_important)
<span>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6" width="24">
        <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.583A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z" clip-rule="evenodd" />
    </svg>
</span>
@endif --}}
{{-- @if ($is_inbox)
    <span>Inbox</span>
@endif --}}
@if ($is_draft)
    <span class="text-gray-500 font-black">Draft</span>
@endif
{{-- @if ($is_sent)
    <span>Sent</span>
@endif --}}
@foreach ($labels as $item)
        <span
        @class([
            'email-label',
            'row-labels',
            "text-[".$item->color?->textColor."]" => true,
            "bg-[".$item->color?->backgroundColor."]" => true,
            // "bg-yellow-500" => $item['name'] == 'INBOX',
            // "bg-green-500" => $item['name'] == 'DRAFT',
            "bg-blue-500" => $item['name'] == 'IMPORTANT',
            "bg-red-500" => $item['name'] == 'SENT',
            "bg-gray-500" => $item['name'] == 'CATEGORY_PERSONAL',
            // "text-bold" => $item['name'] == 'UNREAD',
        ])
        >{{$item['name']}}</span>
@endforeach
