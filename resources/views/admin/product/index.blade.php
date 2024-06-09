@extends('master.admin')
@section('title', 'Product manager')
@section('main')
    <form method="POST" action="" class="form-inline" >
        <div class="col">
            <div class="mb-3">
                <label for="" class="form-inline">Inline Form</label>
                <input
                    type="text"
                    name=""
                    id=""
                    class="form-control"
                    placeholder=""
                    aria-describedby="helpId"
                />
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                <a href="{{ route('product.create') }}" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Add new</a>
            </div>
        </div>
    </form>
    <br>
    <div
        class="table-responsive"
    >
        <table
            class="table table-striped table-hover table-borderless table-primary align-middle"
        >
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Product Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($data as $model)
                <tr class="table-primary">
                    <td scope="row">{{ $loop->index+1}}</td>
                    <td>{{ $model->name }}</td>
                    <td>{{ $model->cat->name }}</td> 
                    <td>{{ $model->price }} <span class="label label-success">{{ $model->sale_price }}</span></td>
                    <td>
                        <img src="uploads/product/{{ $model->image }}" width="40" alt="Ảnh sản phẩm">
                    </td>
                    <td>{{ $model->status == 0 ? 'Tạm ẩn' :'Hiển thị' }}</td>
                    <td class="text-right">
                        <form action="{{ route('product.destroy', $model->id) }}" method="post" onsubmit="return confirm('Are you want to delete?')">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('product.edit', $model->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                
            </tfoot>
        </table>
    </div>
    {{ $data->links() }}
    
@stop