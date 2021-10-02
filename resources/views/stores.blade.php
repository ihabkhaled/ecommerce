<!doctype html>
<html>
<title>Stores</title>

<body>
    @include('includes.loginLogout')
    <div class="container">
        <div id="main" class="row">
            @foreach ($stores as $row)
            <b> {{$row->store_name}} </b>

            <form action='/store/{{$row->id}}' method='get'>
                <input type='submit' value='Browse'>
            </form>

            <br>
            @endforeach
        </div>
    </div>
</body>

</html>