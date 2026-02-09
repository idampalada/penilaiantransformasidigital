@extends('layouts.zi')

@section('content')

<div class="row">
    <div class="col-md-12">

        <h4><strong>LEMBAR KERJA EVALUASI ZONA INTEGRITAS (ZI)</strong></h4>
        <p><strong>PUSAT DATA DAN TEKNOLOGI INFORMASI</strong></p>

        <div class="pull-right" style="margin-top:-40px">
            <button class="btn btn-excel">Cetak ke Excel</button>
        </div>

        <hr>

        <div class="table-responsive">
        <table class="table table-bordered zi-table">

            <thead>
                <tr>
                    <th width="40">No</th>
                    <th>Kriteria</th>
                    <th>Indikator</th>
                    <th>Komponen</th>
                    <th>Metode Pengukuran</th>
                    <th>Penilaian</th>
                    <th>Bukti / Persyaratan</th>
                    <th width="160">File Bukti</th>
                    <th width="90">Nilai Internal</th>
                    <th width="90">Nilai Eksternal</th>
                </tr>
            </thead>

            <tbody>
            @forelse ($indikators as $item)

            @php
                $hasSplit = str_contains($item->metode_pengukuran, '||');
                $metodes = $hasSplit ? explode('||', $item->metode_pengukuran) : [$item->metode_pengukuran];
                $penilaians = $hasSplit ? explode('||', $item->penilaian) : [$item->penilaian];
            @endphp

            <tr>
                <td class="text-center">{{ $item->nomor }}</td>
                <td>{{ $item->kriteria }}</td>
                <td>{{ $item->indikator }}</td>
                <td>{{ $item->komponen }}</td>

                {{-- METODE + PENILAIAN --}}
                @if ($hasSplit)
                    <td colspan="2" style="padding:0">
                        <table class="zi-inner-table">
                            @foreach ($metodes as $i => $metode)
                            <tr>
                                <td class="zi-inner-metode">
                                    {!! nl2br(e(trim($metode))) !!}
                                </td>
                                <td class="zi-inner-penilaian">
                                    @foreach (explode(';;', $penilaians[$i] ?? '') as $row)
                                        {!! nl2br(e(trim($row))) !!}<br>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                @else
                    <td>{!! nl2br(e($metodes[0])) !!}</td>
                    <td>{!! nl2br(e($penilaians[0])) !!}</td>
                @endif

                {{-- BUKTI --}}
                <td>{!! nl2br(e($item->bukti_persyaratan)) !!}</td>

                {{-- FILE --}}
                <td><em class="text-muted">Belum ada file</em></td>

                {{-- NILAI --}}
                <td><input type="text" class="form-control zi-input" disabled></td>
                <td><input type="text" class="form-control zi-input" disabled></td>
            </tr>

            @empty
            <tr>
                <td colspan="10" class="text-center text-muted">
                    Data indikator belum tersedia
                </td>
            </tr>
            @endforelse
            </tbody>

        </table>
        </div>

    </div>
</div>

@endsection
