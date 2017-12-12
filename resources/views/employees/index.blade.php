@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Employees</div>
                    @if (session('message'))
                        <div class="alert alert-info">{{ session('message') }}</div>
                    @endif 
                    <div class="panel-body">
                        @can('create', Employee::class)
                        <a href="{{ route('employees.create') }}" class="btn btn-default">Add New Employee</a>
                        @endcan
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    @can('delete', Employee::class)
                                    <th><input type="checkbox" class="checkbox_all"></th> 
                                    @endcan
                                    <th>Name</th>
                                    <th>EMail</th>
                                    <th>Company</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $employee)
                                <tr>
                                    @can('delete', Employee::class)
                                    <td><input type="checkbox" class="checkbox_delete" name="entries_to_delete[]" value="{{$company->id }}" /></td>
                                    @endcan
                                    <td>{{ $employee->name}}</td>
                                    <td>{{ $employee->email}}</td>
                                    <td>{{ $employee->company->name }}</td>
                                    <td>
                                        @can('update', Employee::class)
                                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-default">Edit</a>
                                        @endcan
                                        @can('delete', Employee::class)
                                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                              style="display: inline"
                                              onsubmit="return confirm('Are you sure?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No entries found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @can('delete', Employee::class)
                        <form action="{{ route('employees.mass_destroy') }}" method="post" onsubmit="return confirm('Are you sure?');">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="ids" id="ids" value="" />
                        <input type="submit" value="Delete selected" class="btn btn-danger" />
                        </form>
                        @endcan
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection	

@section('scripts')
    <script>
        $(".checkbox_all").click(function(){
            $('input.checkbox_delete').prop('checked', this.checked);
        });
    </script>

        <script>
        function getIDs()
        {
            var ids = [];
            $('.checkbox_delete').each(function () {
                if($(this).is(":checked")) {
                    ids.push($(this).val());
                }
            });
            $('#ids').val(ids.join());
        }

        $(".checkbox_all").click(function(){
            $('input.checkbox_delete').prop('checked', this.checked);
            getIDs();
        });

        $('.checkbox_delete').change(function() {
            getIDs();
        });
    </script> 
@endsection