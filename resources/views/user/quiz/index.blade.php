@extends('layouts.main')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Quiz</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Quiz</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3>Quiz</h3>
                    </div>
                </div>
                <form action="{{ route('user.quiz.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        @foreach ($quizzes->shuffle() as $quiz)
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label style="display: block">Question ({{ $quiz->score }} pts)</label>
                                        <span style="display: inline-block">{!! $quiz->question !!}</span>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: block">Answers</label>
                                        @foreach ($quiz->random_answer->shuffle() as $ans)
                                        <div class="form-control row mb-2" style="display: flex">
                                            <div class="col-md-10">
                                                {{ $ans['text'] }}
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group clearfix">
                                                    <div class="icheck-primary d-inline">
                                                        <input type="radio" id="answer-{{ $quiz->getKey() }}-{{ $ans['answer_id'] }}" name="answer[{{ $quiz->getKey() }}]" value="{{ $ans['answer_id'] }}" class="radio-answer" data-answer="{{ $quiz->getKey() }}">
                                                        <label for="answer-{{ $quiz->getKey() }}-{{ $ans['answer_id'] }}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit">Finish</button>
                    </div>
                </form>
            </div>
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
        $(document).on('change', '.radio-answer', function(e) {
            e.preventDefault();
            let currentId = $(this).data('answer')
            let checkedList = $("input:radio[name='answer["+currentId+"]']:checked")
            for(let checked of checkedList) {
                if (currentId != $(checked).data('answer')) {
                    checked.checked = false
                }
            }
        });
    })
</script>
@endpush
