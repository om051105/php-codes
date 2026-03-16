<?php
class Bank {
    public $balance;

    function __construct($initialBalance = 5000) {
        if ($initialBalance < 5000) {
            $this->balance = 5000;
            echo "Minimum balance of 5000 required. Initialized with 5000.<br>";
        } else {
            $this->balance = $initialBalance;
            echo "Account initialized with balance: " . $this->balance . "<br>";
        }
    }

    function deposit($amount){
        $this->balance = $this->balance + $amount;
        echo "Deposited: " . $amount . "<br>";
    }
    function withdraw($amount){
        if($amount <= $this->balance){
            $this->balance = $this->balance - $amount;
            echo "Withdrawn: " . $amount . "<br>";
        } else {
            echo "Insufficient Balance<br>";
        }
    }
    function display(){
        echo "Current Balance: " . $this->balance . "<br>";
    }
}

$account = new Bank(6000);
$account->deposit(1000);
$account->withdraw(300);
$account->display();
?>