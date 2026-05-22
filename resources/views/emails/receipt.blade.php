<x-mail::message>
    # Order Confirmed!

    Thank you for yor order. Your food is currently being prepared by our kitchen staff.

    ### **Your Queue Ticket: {{ $order->ticket_number}}**

    Please keep this number safe, you will need to show it when collecting your food.

    **Order Details:**
    - **Order ID:** #{{ $order->id }}
    - **Status:** {{ ucfirst($order->status) }}
    - **Total Paid:** Rs. {{ number_format($order->total_price, 2)}}

    <x-mail::button :url="config('app.url')">
        View Live Queue
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }} Management
</x-mail::message>