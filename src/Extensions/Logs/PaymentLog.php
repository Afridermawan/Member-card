<?php 

namespace App\Extensions\Logs;

class PaymentLog extends DoctrineLogHandler
{
    protected $table = 'payment_log';
    protected $addColumn = ['transaction_id']; 
}