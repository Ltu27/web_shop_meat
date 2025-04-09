@extends('master.admin')
@section('title', 'Quản lý danh mục')
@section('main')
    <form method="POST" action="" class="form-inline" >
        <div class="col">
            <div class="mb-3">
                <label for="" class="form-inline">Tìm kiếm</label>
                <input
                    type="text"
                    name=""
                    id=""
                    class="form-control"
                    placeholder=""
                    aria-describedby="helpId"
                />
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                <a href="{{ route('category.create') }}" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Thêm mới</a>
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
                    <th>Tên danh mục</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($cats as $cat)
                <tr class="table-primary">
                    <td scope="row">{{ $cat->id }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->status == 0 ? 'Tạm ẩn' :'Hiển thị' }}</td>
                    <td class="text-right">
                        <form action="{{ route('category.destroy', $cat->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('category.edit', $cat->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>Sửa</a>
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                
            </tfoot>
        </table>
    </div>
    {{ $cats->links() }}
    
@stop