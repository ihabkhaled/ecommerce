<!doctype html>
<html>
<title>{{$store_name}} Products</title>

<body>
    @include('includes.loginLogout')
    <div class="container">
        <div id="main" class="row">
            @foreach ($products as $row)
            <b> {{$row->product_name}} </b> - {{$row->product_price}} L.E
            <br>
            {{$row->product_desc}}

            <form action='/cart' method='post'>
                <input type='hidden' name='store_id' value='{{$store_id}}'>
                <input type='hidden' name='product_id' value='{{$row->id}}'>
                <input type='submit' value='Add to cart'>
            </form>

            <br>
            @endforeach
        </div>
    </div>
</body>
<a href="/"><button> Browse more products </button></a>

</html>