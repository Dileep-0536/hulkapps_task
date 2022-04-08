<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadFile;
use App\Models\Tag;
use File;
use App\Http\Requests\AddUploadFormRequest;
use Illuminate\Support\Facades\Auth;

class UploadFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the documents.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get the pdfs list from who is logged in session
        $files_list = UploadFile::where(['user_id' => Auth::id()])->select('id')->orderBy('id','desc')->get();
        return view("upload_files.index", compact('files_list'));
    }

    /**
     * Show the form for creating a upload pdf.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get the tags list
        $tags = Tag::orderBy('id','desc')->get();
        return view("upload_files.create", compact('tags'));
    }

    /**
     * Store a newly created uploaded pdf in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUploadFormRequest $request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $response = [];
        //rename file name with time
        $fileName = time().'.'.$request->document_name->extension(); 
        //move the file to destination folder 
        $request->document_name->move(storage_path() . '/app/public/upload_pdfs/', $fileName);
        //saving data in table 
        $UploadFile_obj = new UploadFile();
        $UploadFile_obj->document_name = $fileName;
        $UploadFile_obj->user_id = Auth::id();
        $UploadFile_obj->created_at = date("Y-m-d h:i:s");
        $UploadFile_obj->updated_at = date("Y-m-d h:i:s");
        $save = $UploadFile_obj->save();
        $tags = $request->get('tags');
        //saving tags relationship
        $res = $UploadFile_obj->tags()->attach($tags);
        if($save) {
            //suucess response
            $response = ['status'=>'success','message'=>"Pdf Uploaded Successfully"];
        } else {
            //failed response
            $response = ['status'=>'failed','message'=>"Pdf Upload Failed"];
        }
        return response($response);
    }

    /**
     * Show the form for editing the specified pdf file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get the upload pdf file data
        $upload_file = UploadFile::with('tags')->find($id);
        if(empty($upload_file)) {
            // if empty the file redirected to index page
            return redirect('manage_files')->with('error_msg',"Files are Not Found");
        }

        //check the uploadfile array or not
        if($upload_file) {
            $upload_file = $upload_file->toArray();
        }
        
        //get the tags data
        $file_tags = Tag::orderBy('id','desc')->get();
        return view("upload_files.edit", compact("file_tags","upload_file"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        date_default_timezone_set("Asia/Kolkata");
        //get the upload pdf file data
        $uploadfile = UploadFile::find($id);
        $result = [];
        //validation
        $request->validate([
            'tags' => 'required|array',
            'tags.*' => 'required'
        ],
        [
            'tags.*.required' => "Select atleast one tag"
        ]);
        $input = $request->all();
        //if file is there in front end request
        if ($request->file('document_name')) {
            //file validation
            $request->validate([
                'document_name' => 'required|mimes:pdf|max:20000',
            ],
            [
                'document_name.required' => "You must use the 'Choose file' button to select pdf file you wish to upload",
                'document_name.max' => "Maximum file size to upload is 20MB (20000 KB).",
                'tags.*.required' => "Select atleast one tag"
            ]);
            //get the destination path
            $file_path = public_path("storage/upload_pdfs/") .$uploadfile->document_name;
            //delete the file
            File::delete($file_path);
            //rename the pdf file
            $original_file =  time().'.'.$request->document_name->extension();
            //move the file to destination path 
            $request->document_name->move(storage_path() . '/app/public/upload_pdfs/', $original_file);
            $input['document_name'] = "$original_file";
        }else{
            //get the old upload file
            $input['document_name'] = $uploadfile->document_name;
        }
        $input['updated_at'] = date("Y-m-d h:i:s");
        
        //update upload pdf file data
        $response = $uploadfile->update($input);

        $tags = $request->get('tags');
        //update the upload pdf file tags relationship
        $res = $uploadfile->tags()->sync($tags);
    
        if($res) {
            //if the result is true
            $result = ['status'=>'success','message' => "Pdf update Successfully"];
        } else {
            //if the result is failed
            $result = ['status'=>'failed','message' => "Pdf Updation Failed"];
        }
        return response($result);
    }

    /**
     * Show the uploaded pdf file from storage folder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDocumentPDF(Request $request)
    {
        $file_id = $request->get('file_id');
        $doc_name = [];
        //get the pdf data
        $get_doc_name = UploadFile::where(['id' => $file_id])->select('document_name')->first()->toArray();
        if(!empty($get_doc_name)) {
            $doc_url = url('/storage/upload_pdfs/'.$get_doc_name['document_name']);
            //prepare embeded pdf data
            $doc_name = ['doc_name' => "<embed src='{$doc_url}#toolbar=0&navpanes=0&scrollbar=0' type='application/pdf' width='100%' height='640px' frameBorder='0'
            scrolling='auto'>"];
        }
        return response($doc_name);
    }
}
