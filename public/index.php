<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Entry;
use App\Database;

$credentials = [
    'host' => 'localhost',
    'username' => 'user',
    'password'=> 'pass',
    'database' => 'database',
];

$pdo = new Database($credentials);

$entry = new Entry($pdo);

// Poniżej różne wywołania metod, w zależności od potrzebnej akcji

// tworzenie wpisu
// $entry->createEntry('test', 'testowy');

// aktualizacja statusu
// $entry->updateStatus(6, 'testowy_nowszy');

// pobranie aktualnych danych o wpisie
// $data = $entry->getEntryById(6);
// print_r($data);

// usuwanie wpisu
// $entry->deleteEntry(4);

// wyszukiwanie po nazwie
// $data = $entry->searchByName('test');
// print_r($data);

// wyszukiwanie po aktualnym statusie
// $data = $entry->searchByCurrentStatus('testowy_nowy');
// print_r($data);

// wyszukiwanie po archiwalnych statusach
// $data = $entry->searchByHistoryStatus('testowy');
// print_r($data);
