@extends('shop')

@section('content')
    <table id="cart" class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <form action="{{ route('mollie') }}" method="post">
            @csrf
            <tbody>
                @php $total = 0 @endphp
                @if (session('cart'))
                    @foreach (session('cart') as $id => $details)
                        <tr rowId="{{ $id }}">
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-sm-3 hidden-xs"><img src="{{ $details['image'] }}" class="card-img-top" />
                                    </div>
                                    <div class="col-sm-9">
                                        <input hidden name="product_name" type="text">
                                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Price">DHS{{ $details['price'] }}</td>

                            <td data-th="Quantity" class="text-center">
                                <input type="number" name="quantity" class="form-control edit-cart-info" value="{{ $details['quantity'] }}"
                                    min="1">
                            </td>
                            <td data-th="Subtotal" class="text-center">{{ $details['price'] * $details['quantity'] }} DHS
                            </td>
                            <td class="actions">
                                <a class="btn btn-outline-danger btn-sm delete-product"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <input hidden type="text" name="price" value="@php $total +=  $details['price'] * $details['quantity']  @endphp">
                        
                    @endforeach
                @endif
                <tr>
                    <td colspan="3" class="text-right"><strong>Total</strong></td>
                    <td class="text-center"><strong>{{ $total }} DHS</strong></td>

                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right">
                        <a href="{{ url('/home') }}" class="btn btn-primary"><i class="fa fa-angle-left"></i> Continue
                            Shopping</a>
                        <button type="submit" class="btn btn-success">Checkout</button>
                    </td>
                </tr>
            </tfoot>
        </form>
    </table>

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
    </script>
@endsection
