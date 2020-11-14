@extends('layouts.dashboard-app')
@section('title', 'Role & Permission')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Attach Permission</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between mb-1">
            <h6 class="m-0 font-weight-bold text-primary">Attach permission ke role {{ $role->name }}</h6>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('users.setRolePermission', $role->name) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <div class="row">
                        @php $no = 1; @endphp
                        @foreach ($permissions as $key => $row)
                            <div class="col-3">
                                <input type="checkbox" 
                                    name="permission[]" 
                                    class="minimal-red" 
                                    value="{{ $row }}"
                                    {{--  CHECK, JIKA PERMISSION TERSEBUT SUDAH DI SET, MAKA CHECKED --}}
                                    {{ in_array($row, $hasPermission) ? 'checked':'' }}
                                    > {{ $row }} <br>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="float-right">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-check mr-1"></i> Set Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
