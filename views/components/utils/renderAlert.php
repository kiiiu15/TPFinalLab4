<?php
include_once(COMPONENTS . "/renderComponent.php");
function render_alert_util(&$successMessage, &$errorMessage)
{
    if (isset($successMessage) || isset($errorMessage)) {
        render_component("alert", [
            "message" =>  isset($successMessage) ? $successMessage : $errorMessage,
            "alertType" => isset($successMessage) ? 'alert-success' : 'alert-danger'
        ]);
    }
}
?>