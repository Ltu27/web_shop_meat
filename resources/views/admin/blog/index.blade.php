@extends('master.admin')
@section('title', 'Quản lý bài viết')
@section('main')
    <form method="POST" action="" class="form-inline" >
        <div class="col">
            <div class="mb-3">
                <a href="{{ route('blog.create') }}" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Thêm mới</a>
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
                    <th>Tên bài viết</th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($blogs as $blog)
                <tr class="table-primary">
                    <td scope="row">{{ $blog->id }}</td>
                    <td>{{ $blog->name }}</td>
                    <td>{{ $blog->description }}</td>
                    <td>{{ $blog->status == 0 ? 'Tạm ẩn' :'Hiển thị' }}</td>
                    <td class="text-right">
                        <form action="{{ route('blog.destroy', $blog->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('blog.edit', $blog->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>Sửa</a>
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
    {{ $blogs->links() }}
    
@stop