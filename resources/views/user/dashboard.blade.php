@extends('layouts.main')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      @if (!is_null(auth()->user()->quiz))
      <div class="info-box bg-gradient-warning">

        <div class="info-box-content">
            Anda telah menyelesaikan Quiz. <br />
            Score terakhir anda adalah: {{ auth()->user()->quiz->score }}
        </div>
        <!-- /.info-box-content -->
    </div>
      @endif
      <div class="info-box bg-gradient-success">
        <span class="info-box-icon"><i class="fas fa-sticky-note"></i></span>

        <div class="info-box-content">
            <ul>
                <li>Pilih Jawaban yang</li>
                <li>asdasd</li>
                <li>asdasd</li>
                <li>asdasd</li>
            </ul>
        </div>
        <!-- /.info-box-content -->
    </div>
      <div class="row">
        <div class="col-md-12">
            <a href="{{ is_null(auth()->user()->quiz) ? route('user.quiz.index') : "#" }}" class="btn btn-primary" id="{{ is_null(auth()->user()->quiz) ? "" : "startQuiz" }}">Start Quiz</a>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $(document).on('click', '#startQuiz', function(e) {
            e.preventDefault();
            let url = '{{ route('user.quiz.index') }}'
            Swal.fire({
                title: "Konfirmasi",
                text: "Anda telah mengisi quiz. Tekan tombol Ya jika ingin mengulangi quiz",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    window.location = url
                }
            });
        });
    })
</script>
@endpush
