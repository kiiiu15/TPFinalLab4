<?php
include(VIEWS."/header2.php");
include(VIEWS.'/nav2.php');
?>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
body {
	background-image: url("https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/V7QIfdTcgikqxmxok/cinema-background_vzw7c2tqe__F0000.png");
    /*background-repeat:no-repeat;*/
    background-size:cover;
    background-size:100%;
} 
</style>

<div class="container">
<form action="<?= FRONT_ROOT ."/Payment/Validate"?>" method="POST">
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Payment Details
                    </h3>
                    <div class="checkbox pull-right">
                        <label>
                            <input type="checkbox" />
                            Remember
                        </label>
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form">
                    <div class="form-group">
                    <div class="input-group">
                            <input type="hidden" value="" name="idBuy" />
                           
                    </div>
                        <label for="cardNumber" >
                            CARD NUMBER</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="cardNumber" id="cardNumber" placeholder="Valid Card Number"
                                required autofocus />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-7 col-md-7">
                            <div class="form-group">
                                <label for="expityMonth">
                                    EXPIRY DATE</label>
                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                    <input type="text" class="form-control" name="expiryMonth" id="expityMonth" placeholder="MM" required />
                                </div>
                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                    <input type="text" class="form-control" name="expiryYear" id="expityYear" placeholder="YY" required /></div>
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-5 pull-right">
                            <div class="form-group">
                                <label for="cvCode">
                                    CV CODE</label>
                                <input type="password" class="form-control" name="securityCode" id="cvCode" placeholder="CV" required />
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#"><span class="badge pull-right"><span class="glyphicon glyphicon-usd"></span><?= $discount;?></span> Discount</a>
                </li>
            </ul>
            <br>
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#"><span class="badge pull-right"><span class="glyphicon glyphicon-usd"></span><?= $total;?> </span> Final Payment</a>
                </li>
            </ul>
            <br/>
            <button type="submit" class="btn btn-success btn-lg btn-block" role="button">Pay</button>
        </div>
    </div>
</div>
</form>
</div>
<style>
form {display: inline-block;
text-align: center;}
body { margin-top:20px; }
.panel-title {display: inline;font-weight: bold;}
.checkbox.pull-right { margin: 0; }
.pl-ziro { padding-left: 0px; }
</style>

<!---
body { margin-top:20px; }
.panel-title {display: inline;font-weight: bold;}
.checkbox.pull-right { margin: 0; }
.pl-ziro { padding-left: 0px; }

-->