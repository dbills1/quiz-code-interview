@extends('layouts.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Quiz</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index')}}">Quiz</a></li>
            <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-12">
                    <h3 class="card-title">Quiz Detail</h3>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Question</th>
                    </tr>
                    <tr>
                        <td>{!! $quiz->question !!}</td>
                    </tr>
                    <tr>
                        <th>Answer</th>
                    </tr>
                    <tr>
                        <td>{!! $quiz->correct_answer['text'] !!}</td>
                    </tr>
                    <tr>
                        <th>Answer List</th>
                    </tr>
                    <tr>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Answer</th>
                                    <th>Correct</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $answers = $quiz->answer;

                                    if (is_string($quiz->answer)) {
                                        $answers = json_decode($quiz->answer, true);
                                    }
                                @endphp
                                @foreach ($answers as $answer)
                                    <tr>
                                        <td>{{ $answer['text'] }}</td>
                                        <td>
                                            <span class="badge badge-{{ $answer['is_answer'] ? "success" : "danger" }}">
                                                {{ $answer['is_answer'] ? "Correct" : "In Correct" }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </tr>
                </table>
            </div>
            <!-- /.card-body -->
          </div>
    </div>
</section>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(document).ready(function () {

        })
    </script>
@endpush
