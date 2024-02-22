@extends('shop')
    
@section('content')


{{-- filter zid hadchi fl home --}}
<div class="categories">
    <ul>
        <li><a href="{{ route('home') }}">All</a></li>
        @foreach ($categories as $category)
            <li><a href="{{ url("/home?category=".$category->id) }}">{{ $category->name }}</a></li>
        @endforeach
    </ul>
</div>
     
<div class="row">
    @foreach($products as $product)
        <div class="col-md-3 col-6 mb-4">
            <div class="card">
                <img src="{{ asset('images') }}/{{ $product->image }}" class="card-img-top"/>
                <div class="card-body">
                    <h4 class="card-title">{{ $product->name }}</h4>
                    {{-- <p>{{ $product->author }}</p> --}}
                    <p class="card-text"><strong>Price: </strong> ${{ $product->price }}</p>
                    <p class="btn-holder"><a href="{{ route('addproduct.to.cart', $product->id) }}" class="btn btn-outline-danger">Add to cart</a> </p>
                </div>
            </div>
        </div>
    @endforeach
</div>
     
@endsection