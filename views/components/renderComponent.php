<?php
function render_component(string $component = "", array $params = [])
{

    $url = COMPONENTS . "/" . $component . ".php";

    if (file_exists($url)) {
        extract($params);
        require_once($url);
    }
}
?>