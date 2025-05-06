@extends('master')
@section('contents')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ $indonesiaCity->name }}</h5>
            <a href="{{ route('province-v2.show', $indonesiaCity->province_code) }}" class="btn btn-secondary btn-sm">Kembali</a>
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
                        <th>Number Of Villages</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($indonesiaCity->indonesiaDistricts as $district)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $district->name }}</td>
                            <td>{{ $district->code }}</td>
                            <td>{{ $district->indonesia_villages_count }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-secondary">Show</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <hr>
            <form action="{{ route('district-v2.store') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">Generate All Districts</button>
            </form>
        </div>
    </div>
@endsection