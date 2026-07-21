@extends('layouts.app')

@section('title', 'Login Admin')

@section('body_class', 'login-page')

@section('content')
<div class="login-wrap">
  <div class="login-card">
    <div class="mark">E</div>
    <h2>Login Admin</h2>
    <div style="color:var(--bento-muted); font-size:14px; margin-bottom:26px;">Masuk ke panel administrasi EventFlow</div>

    @if($errors->any())
    <div style="background:rgba(244,63,94,0.1); border:1px solid rgba(244,63,94,0.3); border-radius:10px; padding:10px 14px; margin-bottom:18px; font-size:13px; color:#f43f5e;">
      {{ $errors->first('email') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.authenticate') }}">
      @csrf
      <div class="field" style="text-align:left;">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="admin@eventflow.id" required>
      </div>
      <div class="field" style="text-align:left;">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" value="admin123" required>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <div style="margin-top:16px; font-size:12px; color:var(--bento-muted);">
      Demo: admin@eventflow.id / admin123
    </div>
  </div>
</div>
@endsection
