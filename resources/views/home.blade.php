@extends('master')
@section('contents')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Province</h5>
            <form action="{{ route('province-v2.store') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-sm btn-primary">Generate Data</button>
            </form>
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
                        <th>Number Of Cities</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($provinces as $province)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $province->name }}</td>
                            <td>{{ $province->code }}</td>
                            <td>{{ $province->indonesia_cities_count }}</td>
                            <td>
                                <a href="{{ route('province-v2.show', $province->code) }}" class="btn btn-sm btn-secondary">Show</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if($provinces->count() > 0)
                <hr>
                <form action="#" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary">Generate All Cities</button>
                </form>
            @endif
        </div>
    </div>
@endsection