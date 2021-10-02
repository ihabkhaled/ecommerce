<!doctype html>
<html>
<title>Cart</title>

<body>
    @include('includes.loginLogout')
    <div class="container">
        @if($msg) <h2 align='left'>{{$msg}}</h2> @endif
        <br>
        <div id="main" class="row">
            @foreach ($cartData as $row)
            @php
            $total += $row->product_price
            @endphp
            {{$row->store_name}} - {{$row->product_name}} : <b> {{$row->product_price}} L.E </b>

            <form action='/cart/{{$row->id}}' method='post'>
                <input type='hidden' name='_method' value='DELETE'>
                <input type='submit' value='Remove'>
            </form>
            <br>
            @endforeach
            <h2 align='left'>Total: {{$total}}</h2>
        </div>
    </div>
</body>
<a href="/"><button> Browse more products </button></a>

</html>