@extends('app')



@section('content')

    <h1>Contact page</h1>
    <ol>
        @foreach($people as $name)
            <li>{{$name}}</li>
        @endforeach
    </ol>


@endsection

@section('footer')

    <p>Are you sure you want to view this?</p>
    <button onclick='document.getElementById("demo").innerHTML= "You just wasted your time 😂😂😂"'>Yes</button>
    <button onclick="document.getElementById('demo').innerHTML= 'You are saved for not clicking Yes'">No</button>
    <p id="demo"></p>


@stop
