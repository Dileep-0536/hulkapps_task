@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div id='validation_msg'></div>
            <div class="card">
            
                <div class="card-header">{{ __('Upload New File') }}
                </div>
                <div class='card'>
                 
                    <div class="card-body">
                        <!-- upload new pdf file -->
                        <form action="{{ route('manage_files.store') }}" method="POST" enctype="multipart/form-data" id="add_documents_form">
                        @csrf
                            <div class="form-group">
                                <label for="document_name">{{ __('Document Name') }}</label>
                                <input type="file" name="document_name" id="document_name" class="form-control-file" required accept="application/pdf" onChange="validate(this.value)"/>
                                <span class="text-danger" id="document_nameError"></span>
                            </div>
                            <div class="form-group">
                                <label for="tags">{{ __('Tags') }}</label>
                                <select multiple class="form-control" id="tags" name="tags[]" required>
                                    <option value="">{{ __('Select Tag') }}</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}"{{ (old('tags') == $tag->id ? "selected":"") }}>{{ $tag->tag_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="tagsError"></span>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });
        // upload pdf file through ajax
        $("#add_documents_form").on('submit', function(e){
            e.preventDefault();
            $("#validation_msg").html('');
            var form_data = new FormData(this);
            $.ajax({
                url:$(this).attr('action'),
                processData: false,
                contentType: false,
                cache:false,
                type:"POST",
                data:form_data,
                success: function(data){
                    console.log(data);
                    if(data.status == "success") {
                        alert(data.message);
                        $("#add_documents_form")[0].reset();
                        var link = "{{ url('manage_files') }}";
                        window.location.href = link;
                        return false;
                    } else {
                        alert(data.message);
                    }
                },
                error:function (response){
                    console.log(response);
                    if(response.responseJSON.errors.document_name) {
                        $('#document_nameError').text(response.responseJSON.errors.document_name);
                    } else {
                        $('#document_nameError').text('');
                    }

                    $('#document_nameError').delay(5000).fadeOut(800);

                    if(response.responseJSON.errors.tags) {
                        $('#tagsError').text(response.responseJSON.errors.tags);
                    } else {
                        $('#tagsError').text('');
                    }

                    $('#tagsError').delay(5000).fadeOut(800);
                    
                    $.each(response.responseJSON.errors, function (key, item) 
                    {
                        $("#validation_msg").html("<li class='alert alert-danger'>"+item+"</li>")
                    });

                    $("#validation_msg").delay(5000).fadeOut(800);
                }
            });
        });
    });


    //validate file extension
    function validate(file) {
        var ext = file.split(".");
        ext = ext[ext.length-1].toLowerCase();      
        var arrayExtensions = ["PDF", "pdf"];

        if (arrayExtensions.lastIndexOf(ext) == -1) {
            alert("Wrong extension type. Please upload pdf files only");
            $("#document_name").val("");
        }
    }
</script>
@endpush