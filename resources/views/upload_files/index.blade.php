@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class='col-sm-12'>
            @if(session('success'))
                <li class='alert alert-success'>{{session('success')}}</li>
            @endif
            @if(session('error_msg'))
                <li class='alert alert-danger'>{{session('error_msg')}}</li>
        @endif
        </div>
        <div class="card" style="width:100%;">
            <div class="row no-gutters">
                <div class='col-md-4'>
                    <div class="card-header">{{ __('FILES') }}
                        <div class='btn-group float-right'>
                            <a href="{{ url('manage_files/create') }}" type="button">{{ __('Upload') }} <i class="fa fa-upload" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <!-- show the pdf's list here as per design-->
                    <div class="card-body">
                        @php $i = 1; 
                        @endphp
                        @if(count($files_list))
                            @foreach($files_list as $file_list) 
                            <div class='row'>
                                <div class="col-md-12">
                                    <div class='document_pdf_click' data-id="{{ $file_list->id }}" data-i_value = "{{ $i }}">{{ "Document #".$i++ }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class='row'><div class='col-md-12'>{{ __('No files are found') }}</div></div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <input type="hidden" id="document_id_val" name="document_id_val" value="0">
                    <!-- show the upload pdf here -->
                    <div class='show_pdf'></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // get the selected pdf list
    $(window).on('load', function(){
        if(loggedIn) {
            var DocumentIDVal = localStorage.getItem("DocumentIDVal");
            console.log(DocumentIDVal);
            var Document_I_Val = localStorage.getItem("Document_I_Val");
            if(DocumentIDVal !== null && DocumentIDVal !== '' && DocumentIDVal !== 0) {
                $.ajax({
                    url:"{{ route('manage_files.get_document_pdf') }}",
                    data:{"file_id":DocumentIDVal},
                    type:"get",
                    dataType:"JSON",
                    success: function(res) {
                        console.log(res);
                        if(res.doc_name.length > 0) {
                            $(".loader").fadeOut("slow");
                            $(document).find(".show_pdf").html("<div class='card-header pdf_header_value'>Document #"+Document_I_Val+'<a href="{{ url('manage_files/edit/') }}/'+DocumentIDVal+'" type="button" class="edit_button float-right" title="Edit PDF"><i class="fa fa-pencil"></i></a></div>'+res.doc_name);
                            $('.document_pdf_click.active').removeClass('active');
                            $('.document_pdf_click[data-id="'+DocumentIDVal+'"]').addClass('active');
                        }
                    }
                });
            } else {
                $(document).find(".show_pdf").html("");
            }
        } else {
            localStorage.clear();
        }
    });

    $(document).ready(function(){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });
        // show the pdf click on documents list
        $(".document_pdf_click").on('click', function(e){
            e.preventDefault();
            $(".loader").show();
            $('.document_pdf_click.active').removeClass('active');
            $(this).addClass('active');
            var id = $(this).data('id');
            var i_value = $(this).data('i_value');
            var document_id_val = $("#document_id_val").val();
            $("#document_id_val").val(id);
            localStorage.setItem("DocumentIDVal", id);
            localStorage.setItem("Document_I_Val", i_value);
            $.ajax({
                url:"{{ route('manage_files.get_document_pdf') }}",
                data:{"file_id":id},
                type:"get",
                dataType:"JSON",
                success: function(res) {
                    console.log(res);
                    if(res.doc_name.length > 0) {
                        $(".loader").hide();
                        $(document).find(".show_pdf").html("<div class='card-header pdf_header_value'>Document #"+i_value+"<a href='{{ url('manage_files/edit/') }}/"+id+"' type='button' title='Edit PDF' class='edit_button float-right'><i class='fa fa-pencil'></i></a></div>"+res.doc_name);
                    }
                }
            });
        });
    });
</script>
@endpush