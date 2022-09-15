<div>
    @foreach ($answer as $index => $ans)
        <input type="hidden" name="answer[{{ $index }}][answer_id]" value="{{ $ans['answer_id'] }}" />
        <div class="form-group">
            <div class="row">
                <div class="col-md-10">
                    <input class="form-control" type="text" name="answer[{{ $index }}][text]" value="{{ $ans['text'] }}"/>
                </div>
                <div class="col-sm-1">
                    <!-- radio -->
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="{{ $ans['answer_id'] }}" name="answer[{{ $index }}][is_answer]" class="radio-answer" data-answer="{{ $ans['answer_id'] }}" {{ $ans['is_answer'] ? "checked" : "" }}>
                            <label for="{{ $ans['answer_id'] }}"></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn-sm btn-danger" wire:click.prevent="removeAnswer({{ $index }})">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
    <div class="form-group">
        <button class="btn btn-primary" wire:click.prevent="addAnswer">Add Answer</button>
    </div>
</div>
