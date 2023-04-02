@component('mail::message')
##Hi {{ ucfirst($customer->name) }},

Greetings of the day.

It is just reminder to inform that, your order has been cancelled successfully

Following are your order details

- Order Date : {{ Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}
- Product : {{ $order->product->name }}
- Product Category : {{ $order->category->name }}
- Product Price : {{ $order->product->price }}

Customer contact details:

- Name: {{ ucfirst($customer->name) }}
- Email: {{ $customer->email }}
@endcomponent