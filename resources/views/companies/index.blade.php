@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Companies</div>
                    @if (session('message'))
                        <div class="alert alert-info">{{ session('message') }}</div>
                    @endif 
                    
                    <div class="panel-body">
                        @can('create', Company::class)
                        <a href="{{ route('companies.create') }}" class="btn btn-default">Add New Company</a>
                        @endcan
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    @can('delete', Company::class)
                                    <th><input type="checkbox" class="checkbox_all"></th> 
                                    @endcan
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($companies as $company)
                                <tr>
                                    @can('delete', Company::class)
                                    <td><input type="checkbox" class="checkbox_delete" name="entries_to_delete[]" value="{{$company->id }}" /></td>
                                    @endcan
                                    <td><img src="{{ route('company.image', ['filename' => $company->name . '.jpg']) }}" class="avatar img-circle img-thumbnail" alt="avatar" style="width: 50px; height: 50px;"></td>
                                    <td>{{ $company->name}}</td>
                                    <td>{{ $company->address }}</td>
                                    <td>
                                        
                                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-default">Edit</a>
                                        
                                        @can('delete', Company::class)
                                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
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
                        @can('delete', Company::class)
                        <form action="{{ route('companies.mass_destroy') }}" method="post" onsubmit="return confirm('Are you sure?');">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="ids" id="ids" value="" />
                        <input type="submit" value="Delete selected" class="btn btn-danger" />
                        </form>
                        @endcan
                        {{ $companies->links() }}
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