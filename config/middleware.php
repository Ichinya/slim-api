<?php

return function (\Slim\App $app) {
    $app->addRoutingMiddleware();
    $app->addErrorMiddleware(true, true, true);
};