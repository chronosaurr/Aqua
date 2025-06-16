<?php

/**
 * Prosty autoloader klas.
 * Ta funkcja jest automatycznie wywoływana przez PHP za każdym razem,
 * gdy kod próbuje użyć klasy, która nie została jeszcze załadowana.
 * @param string $className Nazwa klasy do załadowania (np. "Auth").
 */


spl_autoload_register(function ($className) {

    $directories = [
        CORE_PATH,
        CONTROLLER_PATH,
        MODEL_PATH
    ];

    foreach ($directories as $dir) {
        $file = $dir . '/' . $className . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});