@extends('layouts.pages-layouts')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Kamar')

@section('content')
<div class="container">
    <h2>Create Adime Gizi</h2>
    <div class="card">
         <form action="{{ route('adimegizi.update',  [$no_rawat, $adimeGizi->formatted_tanggal]) }}" method="POST">
    <div class="card-body">
        @method('PUT')
        @csrf
        <div class="form-group col-12">
            <label for="no_rawat" class="form-label">No Rawat:</label>
            <input type="text" class="form-control" id="no_rawat" name="no_rawat" value="{{ $adimeGizi->no_rawat }}" readonly>
        </div>
        <div class="form-group col-12">
            <label for="tanggal" class="form-label">Tanggal:</label>
            <input type="text" class="form-control" id="tanggal" name="tanggal" value="{{ $adimeGizi->tanggal }}">
        </div>
        <div class="form-group col-12" >
            <label for="asesmen" class="form-label">Asesmen:</label>
            <textarea class="form-control" id="asesmen" name="asesmen">{{ $adimeGizi->asesmen }}</textarea>
        </div>
        <div class="form-group col-12">
            <label for="diagnosis" class="form-label">Diagnosis:</label>
            <textarea class="form-control" id="diagnosis" name="diagnosis">{{ $adimeGizi->diagnosis }}</textarea>
        </div>
        <div class="form-group col-12">
            <label for="intervensi" class="form-label">Intervensi:</label>
            <textarea class="form-control" id="intervensi" name="intervensi">{{ $adimeGizi->intervensi }}</textarea>
        </div>
        <div class="form-group col-12">
            <label for="monitoring" class="form-label">Monitoring:</label>
            <textarea class="form-control" id="monitoring" name="monitoring">{{ $adimeGizi->monitoring }}</textarea>
        </div>
        <div class="form-group col-12">
            <label for="evaluasi" class="form-label">Evaluasi:</label>
            <textarea class="form-control" id="evaluasi" name="evaluasi">{{ $adimeGizi->evaluasi }}</textarea>
        </div>
        <div class="form-group col-12">
            <label for="instruksi" class="form-label">Instruksi:</label>
            <textarea class="form-control" id="instruksi" name="instruksi">{{ $adimeGizi->instruksi }}</textarea>
            
        </div>
         <input type="hidden" class="form-control" id="nip" name="nip" value="{{ Auth::user()->email }}">
  </div>
    <div class="card-footer text-end">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

     </form>
       
      </div>
</div>
<script src="./dist/libs/flatpickr/flatpickr.min.js" defer></script>
<script>
$(document).ready(function() {
    $("#tanggal").flatpickr({
         enableTime: true,
        dateFormat: "Y-m-d H:i:s",
        time_24hr: true
    });
});
</script>
@endsection