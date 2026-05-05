@extends('layouts.app')

@section('content')
  <div class="space-y-6">
      @role('super_admin')
          @livewire('developer-dashboard')
      @endrole

      @role('kudd')
          @livewire('dashboard-kudd')
      @endrole

      @role('mubaligh')
          @livewire('dashboard-mubaligh')
      @endrole

      @role('guru_apim')
          @livewire('dashboard-guru')
      @endrole

      @role('mualaf')
          @livewire('dashboard-stats')
      @endrole
  </div>
@endsection
