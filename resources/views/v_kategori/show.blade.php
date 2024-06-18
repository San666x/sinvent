@extends('layouts.adm-main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Show Kategori</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        @forelse ($rsetKategori as $index => $kategori)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kategori->deskripsi }}</td>
                                <td>{{ $kategori->kategori }}</td>
                                <td>
                                    @switch($kategori->kategori)
                                        @case('B')
                                            Bahan
                                            @break
                                        @case('A')
                                            Alat
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                            @empty
                            <!-- display a message or a default row when the collection is empty -->
                        @endforelse
                        <!-- <tr>
                            <td>ID</td>
                            <td>{{ $rsetKategori->id }}</td>
                        </tr>
                        <tr>
                            <td>DESKRIPSI</td>
                            <td>{{ $rsetKategori->deskripsi }}</td>
                        </tr>
                        <tr>
                            <td>KATEGORI</td>
                            <td>{{ $rsetKategori->kategori }}</td>
                            <td>
                                @if($rsetKategori->kategori == 'B')
                                Bahan
                                @elseif(@rsetKategori->kategori == 'A')
                                Alat
                            </td>
                        </tr> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12  text-center">
            <a href="{{ route('kategori.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
        </div>
    </div>
</div>
@endsection