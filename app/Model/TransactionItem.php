<?php

class TransactionItem extends AppModel {

	var $name = 'TransactionItem';
	public $belongsTo = array('Transaction');
}
