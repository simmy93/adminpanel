@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Company</div>

                    <div class="panel-body">
                            @if ($errors->count() > 0)
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        <form enctype="multipart/form-data" action="{{ route('companies.update', $company->id) }}" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            {{ csrf_field() }}
                            Logo:
                            <br />
                            <input type="file" name="logo" id="logo" />
                            <br /><br />
                            Name:
                            <br />
                            <input type="text" name="name" value="{{ $company->name }}" />
                            <br /><br />
                            Address:
                            <br />
                            <input type="text" name="address" value="{{ $company->address }}" />
                            <br /><br />
                            <input type="submit" value="Submit" class="btn btn-default" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection