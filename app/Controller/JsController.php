<?php
	class JsController extends AppController{
		
		public function q1(){
			
			$this->set('title',__('Question: Advanced Input Field'));

	        if ($this->request->is('ajax') && $this->request->data['action']=="add_empty_value") {  
	        	$this->layout = 'ajax';    
		        $this->autoRender = false; 

		        $this->loadModel('AdvanceInputField');
	            $this->AdvanceInputField->description='';
	            $this->AdvanceInputField->quantity='';
	            $this->AdvanceInputField->unit_price='';
	            $this->AdvanceInputField->save($this->AdvanceInputField);  

		        //$data['id']=$this->AdvanceInputField->id;

	            echo json_encode($this->AdvanceInputField);
	        } 

	        if ($this->request->is('ajax') && $this->request->data['action']=="update") {  
	        	$this->layout = 'ajax';    
		        $this->autoRender = false; 

		        $this->loadModel('AdvanceInputField');
	            $this->AdvanceInputField->id=$this->request->data['id'];
	            $this->AdvanceInputField->set(Array($this->request->data['field']=>$this->request->data['field_value']));
	            $this->AdvanceInputField->save($this->AdvanceInputField);  

	            echo json_encode("success");
	        } 

		}
		
	}