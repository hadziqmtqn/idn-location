@extends('master')
@section('contents')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ $indonesiaDistrict->name }}</h5>
            <a href="{{ route('city-v2.show', $indonesiaDistrict->city_code) }}" class="btn btn-secondary btn-sm">Kembali</a>
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($indonesiaDistrict->indonesiaVillages as $village)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $village->name }}</td>
                            <td>{{ $village->code }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <hr>
            <form action="{{ route('village-v2.store') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">Generate All Villages</button>
            </form>
        </div>
    </div>
@endsection