<?php

class FileUploadController extends AppController {
	public function index() {
		$this->set('title', __('File Upload Answer'));
        $this->set('validation_message','');

		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));

        if($this->request->is('post')){
            $filetype=$this->request->data['FileUpload']['file']['type'];
            $valid_filetype=['text/csv'];
            if(!empty($this->request->data['FileUpload']['file']) && in_array($filetype, $valid_filetype)){
                $csv=$this->request->data['FileUpload']['file']['tmp_name'];

                if ($file = fopen($csv, "r")) {
                    $counter=0;

                    while(!feof($file)) {
                    $line = fgets($file);
                    $fgetslines = explode(",",$line);
                        if ($counter > 0){

                            $this->FileUpload->name=$fgetslines[0];
                            $this->FileUpload->email=$fgetslines[1];
                            $this->FileUpload->created=date("Y-m-d h:i:s");

                            $this->FileUpload->clear();
                            $this->FileUpload->save($this->FileUpload);
                        }
                        $counter++;
                    }
                }
                fclose($file);
                $file_uploads = $this->FileUpload->find('all');
                $this->set(compact('file_uploads'));
            }
            
        }
    }
}