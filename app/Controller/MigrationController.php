<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

	class MigrationController extends AppController{
		
		public function q1(){
			//set_time_limit(0);
			$this->set('title', __('Migration of data to multiple DB table'));
			$this->setFlash('Question: Migration of data to multiple DB table');
			$this->set('result','');
			
			if($this->request->is('post')){
				$valid_filetype=['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
	            $filetype=$this->request->data['FileUpload']['file']['type'];
            
	            if(!empty($this->request->data['FileUpload']['file']) && in_array($filetype, $valid_filetype)){
	            	$tmp_name=$this->request->data['FileUpload']['file']['tmp_name'];
	            	$file_type = IOFactory::identify($tmp_name);
					$reader = IOFactory::createReader($file_type);
					$reader->setReadDataOnly(true);
					$worksheetData = $reader->listWorksheetInfo($tmp_name);

					$spreadsheet = $reader->load($tmp_name);
					$transactions = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
					unset($transactions['1']); 
					foreach ($transactions as $transaction) {
						
						$date= Date::excelToDateTimeObject($transaction['A']);
						$date=(array)$date;
						$this->loadModel('Transaction');
						$this->loadModel('TransactionItem');
						$this->loadModel('Member');

			            $this->Member->type=$transaction['E'];
			            $this->Member->no=$transaction['D'];
			            $this->Member->name=$transaction['C'];
			            $this->Member->company=$transaction['F'];	
			            $this->Member->clear();		            
			            $this->Member->save($this->Member);

			            $this->Transaction->member_id=$this->Member->id;
			            $this->Transaction->member_name=$transaction['C'];
			            $this->Transaction->member_paytype=$transaction['E'];
			            $this->Transaction->member_company=$transaction['F'];
			            $this->Transaction->date=date("Y-m-d", strtotime($date['date']));
			            $this->Transaction->year=date("Y", strtotime($date['date']));
			            $this->Transaction->month=date("m", strtotime($date['date']));
			            $this->Transaction->ref_no=$transaction['B'];
			            $this->Transaction->receipt_no=$transaction['I'];
			            $this->Transaction->payment_method=$transaction['G'];
			            $this->Transaction->batch_no=$transaction['H'];
			            $this->Transaction->cheque_no=$transaction['J'];
			            $this->Transaction->renewal_year=$transaction['L'];
			            $this->Transaction->remarks=$transaction['K'];
			            $this->Transaction->subtotal=$transaction['M'];
			            $this->Transaction->tax=$transaction['N'];
			            $this->Transaction->total=$transaction['O'];
			            $this->Transaction->clear();		
			            $this->Transaction->save($this->Transaction);

			            $this->TransactionItem->transaction_id=$this->Transaction->id;
			            $this->TransactionItem->description=$transaction['K'];
			            $this->TransactionItem->unit_price=$transaction['M'];
			            $this->TransactionItem->sum=$transaction['M'];
			            $this->TransactionItem->clear();
			            $this->TransactionItem->save($this->TransactionItem);
			            
					}

					$this->set('result','Successfully Migrated');
	            }

        	}
		}
		
		public function q1_instruction(){

			$this->setFlash('Question: Migration of data to multiple DB table');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
	}