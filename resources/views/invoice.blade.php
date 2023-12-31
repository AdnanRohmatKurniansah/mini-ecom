@extends('layout.main')

@section('content')

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Confirmation</h1>
                <nav class="d-flex align-items-center">
                    <a href="/"><span class="lnr lnr-arrow-right"></span>Home</a>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="order_details section_gap">
    <div class="container">
        <h3 class="ml-3 mb-5"><span>No Invoice</span> : #INV{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h3>
            <div class="row order_d_inner"> 
                <div class="col-lg-4">
                    <div class="details_item">
                        <h4>Customer Details</h4>
                        <ul class="list">
                            <li><a><span>First Name</span> : {{ $order->fname }}</a></li>
                            <li><a><span>Last Name</span> : {{ $order->lname }}</a></li>
                            <li><a><span>Phone Number</span> : {{ $order->pnumber }}</a></li>
                            <li><a><span>Email </span> : {{ $order->email }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="details_item">
                        <h4>Order Info</h4>
                        <ul class="list">
                            <li><a><span>No Resi</span> : {{ $order->resi == null ? 'No receipt' : $order->resi }}</a></li>
                            <li><a><span>Shipping</span> : {{ strtoupper($order->courier) }} | {{ $order->shipping_cost }} | {{ $order->service }}</a></li>
                            <li><a><span>Time Order</span> : {{ $order->created_at->format('d M Y h:i') }}</a></li>
                            <li><a><span>Due Date</span> : {{ \Carbon\Carbon::parse($order->due_date)->format('d M Y h:i') }}</a></li>
                            <li><a><span>Total</span> : Rp. {{ number_format($order->total, 0, ',', '.') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="details_item">
                        <h4>Shipping Address</h4>
                        <ul class="list">
                            <li><a><span>Street</span> : {{ $order->street }}</a></li>
                            @php
                                $district = \App\Models\District::where('id', $order->district)->pluck('name')->first();
                            @endphp
                            <li><a><span>District</span> : {{ $district }}</a></li>
                            @php
                                $regency = \App\Models\Regency::where('id', $order->regency)->pluck('name')->first();
                            @endphp
                            <li><a><span>Regency</span> : {{ $regency }}</a></li>
                            @php
                                $province = \App\Models\Province::where('id', $order->province)->pluck('name')->first();
                            @endphp
                            <li><a><span>Province</span> : {{ $province }}</a></li>
                            <li><a><span>Postcode </span> : {{ $order->zip }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="order_details_table">
                <h2>Order Details</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $products = $order->carts;
                            @endphp
                            @foreach ($products as $cart)
                                <tr>
                                    <td>
                                        <p>{{ $cart->product_name }}</p>
                                    </td>
                                    <td>
                                        <h5>x {{ $cart->qty }}</h5>
                                    </td>
                                    <td>
                                        <p>Rp. {{ number_format($cart->price, 0, ',', '.') }}</p>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>
                                    <h4>Subtotal</h4>
                                </td>
                                <td>
                                    <h5></h5>
                                </td>
                                <td>
                                    <p>Rp. {{ number_format($order->sub_total, 0, ',', '.') }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>Shipping</h4>
                                </td>
                                <td>
                                    <h5></h5>
                                </td>
                                <td>
                                    <p>Rp. {{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>Total</h4>
                                </td>
                                <td>
                                    <h5></h5>
                                </td>
                                <td>
                                    <p>Rp. {{ number_format($order->total, 0, ',', '.') }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($order->status == 'unpaid')
            <div class="pay d-flex justify-content-end mt-3" >
                <button id="pay-btn" type="submit" class="primary-btn rounded-0 border-0">Pay Now</button>
            </div>
            @endif
            @if ($order->status == 'process')
                @php
                    $array = explode(' | ', $order->service);
                    $value = $array[1];
                    $etd = explode('-', $value)[0];
                    $date = \Carbon\Carbon::parse($order->updated_at)->addDays($etd)->format('d M Y');
                @endphp
                @if (\Carbon\Carbon::today() >= \Carbon\Carbon::parse($date))
                    <div class="justify-content-end mt-3" >
                        <small>The possibility of items arriving on {{ $date }} please wait, if the item has arrived please confirm by clicking this button</small>
                        <form action="/itemsArrived" method="post">
                            @method('put')
                            @csrf
                            <input type="hidden" value="{{ $order->id }}" name="id">
                            <button type="submit" onclick="return confirm('Are you sure the order actually arrived?')" class="genric-btn info e-large rounded-0 border-1" style="font-size: 16px">Items arrived</button>
                        </form>
                    </div>
                @else
                    <div class="d-flex justify-content-end mt-3 text-danger" >
                        <small>The possibility of items arriving on {{ $date }}, if the item has arrived please confirmation</small>
                    </div>
                @endif
            @endif
        </div>
</section>

<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-btn');
    payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{ $order->snaptoken }}', {
            onSuccess: function (result) {
                /* You may add your own implementation here */
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    iconColor: 'white',
                    color: '#fff',
                    timerProgressBar: true,
                    background: '#a5dc86',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'Payment success!'
                })
                console.log(result);
                window.location.href = '/transaction'
            },
            onPending: function (result) {
                /* You may add your own implementation here */
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    iconColor: 'white',
                    color: '#fff',
                    background: '#3fc3ee',
                    
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'Wating your payment!'
                })
                console.log(result);
            },
            onError: function (result) {
                /* You may add your own implementation here */
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    iconColor: 'white',
                    color: '#fff',
                    background: '#f27474',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: 'Payment failed!'
                })
                console.log(result);
            },
            onClose: function () {
                /* You may add your own implementation here */
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    iconColor: 'white',
                    color: '#fff',
                    background: '#f8bb86',
                    
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'warning',
                    title: 'You closed the popup without finishing the payment'
                })
            }
        })
    });

</script>

@endsection