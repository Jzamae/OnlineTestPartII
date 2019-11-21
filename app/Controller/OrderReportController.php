<?php
	class OrderReportController extends AppController{

		public function index(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));
			// debug($orders);exit;

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
			//debug($portions);

			
			// To Do - write your own array in this format
			$data_report=Array();
			$ingredients=Array();
			foreach($orders as $order)
			{
				$ingredients[$order['Order']['name']]=Array();
				foreach($order['OrderDetail'] as $orderdetail)
				{
					foreach($portions as $portion)
					{   
						if($portion['Portion']['item_id']==$orderdetail['item_id']){
							$ingredients[$order['Order']['name']][$portion['Portion']['item_id']]=Array();
							foreach($portion['PortionDetail'] as $portiondetail)
							{
								$ingredients[$order['Order']['name']][$portion['Portion']['item_id']][$portiondetail['Part']['name']]=$portiondetail['value'];
							}	
						}				
					}
				}

				$sum_ingredients = array();

				foreach ($ingredients[$order['Order']['name']] as $k=>$subArray) {
				  foreach ($subArray as $id=>$value) {
				  	if( ! array_key_exists($id, $sum_ingredients)) $sum_ingredients[$id] = 0;
				    $sum_ingredients[$id]+=$value;

				  }
				}

				$details=array($order['Order']['name']=> $sum_ingredients);
				$data_report=array_merge($data_report, $details);	
			}
			
			$order_reports = $data_report;

			// ...

			$this->set('order_reports',$order_reports);

			$this->set('title',__('Orders Report'));
		}

		public function Question(){

			$this->setFlash('Multidimensional Array.');

			$this->loadModel('Order');
			$orders = $this->Order->find('all',array('conditions'=>array('Order.valid'=>1),'recursive'=>2));

			// debug($orders);exit;

			$this->set('orders',$orders);

			$this->loadModel('Portion');
			$portions = $this->Portion->find('all',array('conditions'=>array('Portion.valid'=>1),'recursive'=>2));
				
			// debug($portions);exit;

			$this->set('portions',$portions);

			$this->set('title',__('Question - Orders Report'));
		}

	}