@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add New Employee</div>

                    <div class="panel-body">
                        @if ($errors->count() > 0)
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form action="{{ route('employees.store') }}" method="post">
                            {{ csrf_field() }}
                            Email:
                            <br />
                            <input type="text" name="email" value="{{ old('email') }}" />
                            <br /><br />
                            Name:
                            <br />
                            <input type="text" name="name" value="{{ old('name') }}" />
                            <br /><br />
                            Company:
                            <br />
                            <select name="company_id">
                            @foreach($companies as $company)
                            <option value="{{$company->id}}">{{$company->name}}</option>
                            @endforeach  
                            </select> 
                            <br /><br />
                            <input type="submit" value="Submit" class="btn btn-default" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection