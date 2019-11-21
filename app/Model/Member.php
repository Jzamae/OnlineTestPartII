<?php

class Member extends AppModel {

	var $name = 'Member';
	var $hasMany = array('Transaction' => array(
									'conditions' => array('Transaction.valid' => 1)
								)
							);
}
