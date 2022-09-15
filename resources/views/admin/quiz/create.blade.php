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
            <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}">Quiz</a></li>
            <li class="breadcrumb-item active">Create</li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <div class="info-box bg-gradient-success">
            <span class="info-box-icon"><i class="fas fa-sticky-note"></i></span>

            <div class="info-box-content">
                <ul>
                    <li>asdasd</li>
                    <li>asdasd</li>
                    <li>asdasd</li>
                    <li>asdasd</li>
                </ul>
            </div>
            <!-- /.info-box-content -->
        </div>
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Create new Quiz</h3>
            </div>
            <!-- /.card-header -->
            <form action="{{ route('admin.quizzes.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Question</label>
                        <textarea class="form-control" name="question"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Score</label>
                        <input class="form-control" name="score" min="1" max="100" type="number"/>
                    </div>
                    <div class="form-group">
                        <label>List of Answer</label>
                        @livewire('answers')
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
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
    <script>
        $(document).ready(function () {
            $('#quiz-table').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            })

            $(document).on('change', '.radio-answer', function(e) {
                e.preventDefault();
                let currentId = $(this).data('answer')
                let checkedList = $("input:radio.radio-answer:checked")
                for(let checked of checkedList) {
                    if (currentId != $(checked).data('answer')) {
                        checked.checked = false
                    }
                }
            });
        })
    </script>
@endpush
