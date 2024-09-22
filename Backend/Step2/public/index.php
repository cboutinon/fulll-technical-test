<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

// Charger les variables d'environnement si elles ne sont pas déjà définies
if (!isset($_ENV['DATABASE_URL'])) {
    (new Dotenv())->usePutenv()->bootEnv(dirname(__DIR__).'/.env.test');
}
return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
