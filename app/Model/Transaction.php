<?php

class Transaction extends AppModel {

	var $name = 'Transaction';
	public $hasMany = array('TransactionItem');
}
