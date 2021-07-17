<?php

return function (\Slim\App $app) {
    $app->getContainer()->get('settings');
    $app->addRoutingMiddleware();
    $app->addErrorMiddleware(true, true, true);
};