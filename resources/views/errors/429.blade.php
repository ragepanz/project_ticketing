@extends('layouts.app')
@section('title', '429 - Too Many Requests')
@section('content')
<div class="stage" style="text-align:center;padding:80px 20px;">
  <div style="font-size:72px;font-weight:800;color:#383be5;line-height:1;">429</div>
  <div style="font-size:18px;font-weight:700;color:#0f172a;margin-top:12px;">Terlalu Banyak Permintaan</div>
  <div style="color:#64748b;font-size:14px;margin-top:8px;">Anda melakukan terlalu banyak permintaan. Silakan tunggu beberapa saat.</div>
  <a href="{{ route('peserta.index') }}" class="btn btn-primary" style="margin-top:24px;display:inline-block;">Kembali ke Beranda</a>
</div>
@endsection