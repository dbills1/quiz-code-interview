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
            <li class="breadcrumb-item active">Quiz</li>
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
                <div class="col-md-6">
                    <h3 class="card-title">List of Quiz</h3>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('admin.quizzes.create') }}" class="btn-sm btn-primary float-right">Create new Quiz</a>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="quiz-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Question</th>
                  <th>Answer</th>
                  <th>Score</th>
                  <th width="5%">Status</th>
                  <th width="15%"></th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <td>{{ $quiz->question }}</td>
                            <td>{{ $quiz->correct_answer['text'] }}</td>
                            <td>{{ $quiz->score }}</td>
                            <td><span class="badge badge-{{ $quiz->trashed() ? "danger" : "primary" }}">{{ $quiz->trashed() ? "Deleted" : "Active" }}</span></td>
                            <td>
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="{{ route('admin.quizzes.show', $quiz->getKey()) }}" class="btn-sm btn-success">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                    @if (!$quiz->trashed())
                                    <div class="col-md-4">
                                        <a href="{{ route('admin.quizzes.edit', $quiz->getKey()) }}" class="btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="btn-sm btn-danger remove" data-form="form-delete-quiz-{{ $quiz->getKey() }}" href="{{ route('admin.quizzes.destroy', $quiz->getKey())}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form action="{{ route('admin.quizzes.destroy', $quiz->getKey()) }}" method="post" id="form-delete-quiz-{{ $quiz->getKey() }}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </div>
                                    @else
                                    <div class="col-md-4">
                                        <a class="btn-sm btn-warning restore" data-form="form-restore-quiz-{{ $quiz->getKey() }}" href="{{ route('admin.quizzes.destroy', $quiz->getKey())}}">
                                            <i class="fa fa-recycle"></i>
                                        </a>
                                        <form action="{{ route('admin.quizzes.restore', $quiz->getKey()) }}" method="post" id="form-restore-quiz-{{ $quiz->getKey() }}">
                                            @csrf
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
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
            $('#quiz-table').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            })

            $(document).on('click', '.remove', function(e) {
                e.preventDefault();
                var form = $('#' + $(this).data('form'));
                Swal.fire({
                    title: "Konfirmasi",
                    text: "Yakin data akan dihapus?",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            $(document).on('click', '.restore', function(e) {
                e.preventDefault();
                var form = $('#' + $(this).data('form'));
                Swal.fire({
                    title: "Konfirmasi",
                    text: "Yakin data akan kembalikan?",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        })
    </script>
@endpush
