Prosty CRUD i wyszukiwanie po statusach

# Tabele do importu do bazy:

    CREATE TABLE entries (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(100) DEFAULT NULL,
        status varchar(100) NOT NULL,
        created_at datetime NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

    CREATE TABLE status_history (
        id int auto_increment NOT NULL,
        entry_id int NOT NULL,
        status varchar(100) NOT NULL,
        created_at datetime NOT NULL,
        CONSTRAINT status_history_PK PRIMARY KEY (id),
        CONSTRAINT status_history_FK FOREIGN KEY (entry_id) REFERENCES entries(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

# Konfiguracja

Uproszczona wersja - konfiguracja bazy danych znajduje się w pliku public/index.php w arrayu $credentials:

    $credentials = [
        'host' => 'localhost',
        'username' => 'root',
        'password'=> 'password',
        'database' => 'database_name',
    ];

# Przykładowe wywołania metod

// tworzenie wpisu
$entry->createEntry('test', 'testowy');

// aktualizacja statusu
$entry->updateStatus(1, 'testowy_nowy');

// pobranie aktualnych danych o wpisie
$data = $entry->getEntryById(1);
print_r($data);

// usuwanie wpisu
$entry->deleteEntry(1);

// wyszukiwanie po nazwie
$data = $entry->searchByName('test');
print_r($data);

// wyszukiwanie po aktualnym statusie
$data = $entry->searchByCurrentStatus('testowy');
print_r($data);

// wyszukiwanie po archiwalnych statusach
$data = $entry->searchByHistoryStatus('testowy');
print_r($data);
