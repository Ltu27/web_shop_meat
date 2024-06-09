@extends('master.admin')
@section('title', 'User manager')
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
                <a href="{{ route('user.create') }}" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Add new</a>
            </div>
        </div>
    </form>
    <br>
    <div
        class="table-responsive"
    >
        <table
            class="table table-striped table-hover table-borderless table-primary align-middle" id="user-table"
        >
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            {{-- <tbody class="table-group-divider">
                @foreach ($users as $user)
                <tr class="table-primary">
                    <td scope="row">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->status == 0 ? 'Tạm ẩn' :'Hiển thị' }}</td>
                    <td class="text-right">
                        <form action="{{ route('user.destroy', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody> --}}
        </table>
    </div>
    {{-- {{ $users->links() }} --}}
@stop
@section('js')
    <script>
        $(function() {
            $('#user-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('user.getListUser') }}',
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'address', name: 'address' },
                    { data: 'id', 
                        name: 'action', 
                        orderable: false, 
                        className: 'text-center',
                        render: function(data) {
                            var html = '';
                            html += '<div class="d-flex justify-content-center align-items-center flex-nowrap">';
                            html += '<a href="{{ route('user.edit', ':id') }}" class="m-2 btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';
                            html = html.replace(':id', data);
                            html += '<form action="{{ route('user.destroy', ':id') }}" method="post">';
                            html = html.replace(':id', data);
                            html += '@method('DELETE')';
                            html += '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
                            html += '<button onclick="return confirm(\'Bạn có muốn xóa sản phẩm này ?\')" class="m-2 btn btn-danger btn-sm">';
                            html += '<input type="hidden" name="id" value="' + data + '">';
                            html += '<i class="fa fa-trash"></i></button>';
                            html += '</form>';
                            html += '</div>';

                            return html;
                        }
                    },
                ]
            });
        });
    </script>
@endsection