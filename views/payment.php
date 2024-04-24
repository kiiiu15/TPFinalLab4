<?php
include(VIEWS . "/header.php");
include(VIEWS . '/nav.php');
?>
<main class="p-3 p-md-5">
    <div class="container-fluid container-md">
        <form action="<?= FRONT_ROOT . "/Payment/Validate" ?>" method="POST">

            <div class="card">
                <div class="card-header">
                    <p class="h3">Payment Details</p>
                    <div class="d-none form-group">
                        <label> Remember </label>
                        <input type="checkbox" />
                    </div>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <input type="hidden" value="<?= $buy->getIdBuy(); ?>" name="idBuy" />
                    </div>
                    <div class="form-group">
                        <label for="cardNumber">CARD NUMBER</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="cardNumber" id="cardNumber" placeholder="Valid Card Number" maxlength="16" minlength="16" required autofocus />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="form-group">
                            <label for="expityMonth">EXPIRY DATE</label>
                            <div class="d-flex">
                                <input type="text" class="form-control" name="expiryMonth" id="expityMonth" placeholder="MM" required />
                                <input type="text" class="form-control" name="expiryYear" id="expityYear" placeholder="YY" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cvCode">CV CODE</label>
                            <input type="password" class="form-control" name="securityCode" id="cvCode" placeholder="CV" required />
                        </div>
                    </div>
                </div>

                <div class="card-footer">

                    <div class="d-flex flex-column">
                        <span>Discount: $ <?= $discount; ?></span>
                        <span>Final Payment: $ <?= $total; ?></span>
                        <button type="submit" class="btn btn-success btn-lg btn-block" role="button">Pay</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</main>