@extends('layout.app')
{{-- @extends('layout.app') --}}


@section('content')
    <div class="font-[sans-serif] bg-white py-4">
      <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-extrabold text-[#333]">Shopping Cart</h2>
        <div class="overflow-x-auto">
          <table class="mt-12 w-full border-collapse divide-y" id='cart'>
            <thead class="whitespace-nowrap text-left">
              <tr>
                <th class="text-base text-gray-500 p-4">Description</th>
                <th class="text-base text-gray-500 p-4">Price</th>
                <th class="text-base text-gray-500 p-4">Quantity</th>
                <th class="text-base text-gray-500 p-4">Remove</th>
                <th class="text-base text-gray-500 p-4">SubTotal</th>
              </tr>
            </thead>
            <tbody class="whitespace-nowrap divide-y">
                <form action="{{ route('mollie') }}" method="post">
                    @csrf
                    @php $total = 0 @endphp
                    @if (session('cart'))
                    @foreach (session('cart') as $id => $details)
                <tr rowId="{{ $id }}">
                    <td class="py-6 px-4">
                    <div class="flex items-center gap-6 w-max">
                        <div class="h-36 shrink-0">
                        <img src="{{asset("storage/" . $details['image'])}}" class="w-full h-full object-contain" />
                        </div>
                        <div>
                        <p class="text-lg font-bold text-[#333]">{{ $details['name'] }}</p>
                        </div>
                    </div>
                    </td>
                    <td class="py-6 px-4 ">
                    {{ $details['price'] }} MAD
                    </td>
                    
                    <div class="flex divide-x border w-max">
                        
                        <td  class="text-center">
                            <input  type="number" id="quantityInput" name="quantity" class="w-12  text-center border-0 rounded-md bg-gray-50  md:text-right edit-cart-info" value="{{ $details['quantity'] }}"
                                min="1">
                        </td>
                        
                    </div>
                    </td>
                    <td class="py-6 px-4">
                    <a class=" mx-8 btn btn-outline-danger btn-sm delete-product"><i class="fa fa-trash-o"></i></a>
                    </td>
                    <td class="py-6 px-4">
                    <h4 class="text-lg font-bold text-[#333]">{{ $details['price'] * $details['quantity'] }} MAD</h4>
                    </td>
                </tr>
              @endforeach
            @endif
            <input hidden type="text" name="price" value="@php $total +=  $details['price'] * $details['quantity']  @endphp">
            
                
            </tbody>
          </table>
        </div>
        <div class=" max-w-xl ml-auto mt-6">
          <ul class="text-[#333] divide-y">
            <li class="flex flex-wrap gap-4 text-md py-3">Subtotal <span class="ml-auto font-bold">{{$details['price']}} MAD</span></li>
            <li class="flex flex-wrap gap-4 text-md py-3">Shipping <span class="ml-auto font-bold">0.00 MAD</span></li>
            <li class="flex flex-wrap gap-4 text-md py-3">Tax <span class="ml-auto font-bold">0.00 MAD</span></li>
            <li class="flex flex-wrap gap-4 text-md py-3 font-bold">Total <span class="ml-auto">{{$total}} MAD</span></li>
          </ul>
          <button type="submit" class="mt-6 text-md px-6 py-2.5 w-full bg-blue-600 hover:bg-blue-700 text-white rounded">Check
            out</button>
        </div>
        </form>
      </div>
    </div>
    {{-- ------------------------------------------------- --}}
@endsection

@section('scripts')
        <script type="text/javascript">
        $(".edit-cart-info").change(function(e) {
            e.preventDefault();
            var ele = $(this);
            $.ajax({
                url: '{{ route('update.shopping.cart') }}',
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("rowId"),
                    quantity: ele.val(),
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $(".delete-product").click(function(e) {
            e.preventDefault();

            var ele = $(this);

            if (confirm("Do you really want to delete?")) {
                $.ajax({
                    url: '{{ route('delete.cart.product') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").attr("rowId")
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });
    document.addEventListener('DOMContentLoaded', function () {
        // Select the input element
        var quantityInput = document.getElementById('quantityInput');

        // Select the plus and minus buttons
        var plusButton = document.querySelector('.bi-plus');
        var minusButton = document.querySelector('.bi-dash');

        // Add click event listener to the plus button
        plusButton.addEventListener('click', function () {
            // Increment the input value
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });

        // Add click event listener to the minus button
        minusButton.addEventListener('click', function () {
            // Ensure the value is not less than 1 before decrementing
            if (parseInt(quantityInput.value) > 1) {
                // Decrement the input value
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });
    });

    </script>
@endsection



