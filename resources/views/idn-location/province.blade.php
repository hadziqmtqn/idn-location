@extends('master')
@section('contents')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ $indonesiaProvince->name }}</h5>
            <a href="{{ route('home.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            @include('session')
            <div class="table-responsive">
                <table class="table table-striped w-100 text-nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Number Of District</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($indonesiaProvince->indonesiaCities as $city)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $city->name }}</td>
                            <td>{{ $city->code }}</td>
                            <td>{{ $city->indonesia_districts_count }}</td>
                            <td>
                                <a href="{{ route('city-v2.show', $city->code) }}" class="btn btn-sm btn-secondary">Show</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection