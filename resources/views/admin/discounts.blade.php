@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Discounts</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.discounts.index') }}">
                            <div class="text-tiny">Discounts</div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="search"
                                    tabindex="2" value="" aria-required="true">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.discounts.create') }}">
                        <i class="icon-plus"></i>Add New Discount
                    </a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Discount Percentage</th>
                                <th>Discount Category</th>
                                <th>Valid From</th>
                                <th>Valid To</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($discounts as $discount)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $discount->product->product_name ?? 'No Product' }}</td>
                                    <td>{{ $discount->discount_percentage }}%</td>
                                    <td>{{ $discount->discount_category->discount_name }}</td>
                                    <td>{{ $discount->valid_from }}</td>
                                    <td>{{ $discount->valid_to }}</td>
                                    <td>
                                        <div class="list-icon-function">
                                            {{-- <a href="{{ route('admin.discounts.edit', $discount->id) }}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a> --}}
                                            <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <div class="item text-danger delete">
                                                    <i class="icon-trash-2"></i>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{-- {{ $discounts->links('pagination::bootstrap-5') }} --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('.delete').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: 'Are you sure?',
                    text: "You want to delete this record!",
                    type: "warning",
                    confirmButtonColor: '#dc3545'
                }).then(function(result) {
                    if(result){
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
