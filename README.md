# Alt_F104_Project

L’applicativo Alt_F104_Project nasce dalla necessità di digitalizzare e ottimizzare i flussi di lavoro all'interno dei laboratori di ricerca universitari. Il sistema si configura come un hub collaborativo permettendo una gestione fluida che va dalla genesi di un'idea progettuale fino alla diffusione dei risultati scientifici.

Attraverso una struttura modulare, la piattaforma abilita il monitoraggio granulare delle attività (mediante la scomposizione in milestone e task operativi) e la conservazione sistematica dei prodotti della ricerca, offrendo un controllo centralizzato sulla documentazione tecnica e sulle pubblicazioni in formato PDF.

### Architettura 
Il software è stato ingegnerizzato adottando un approccio "full-stack" moderno, garantendo prestazioni elevate, sicurezza dei dati e un'esperienza utente reattiva. La struttura si fonda sui seguenti pilastri tecnologici:
- Logica di Business (Backend): Il cuore del sistema è sviluppato in Laravel 10. L'adozione del pattern MVC e dell'ORM Eloquent ha permesso di mappare le complesse relazioni tra ricercatori, progetti e paper scientifici in modo pulito.
- Sicurezza e Accessi: La gestione dell'identity provider e la protezione dei perimetri operativi sono affidate a Laravel Breeze, che garantisce standard elevati nei processi di autenticazione e nel controllo degli accessi basato sui ruoli.
- Persistenza dei Dati: I flussi informativi sono stoccati in un database relazionale MySQL, ottimizzato per gestire query complesse e garantire l'integrità referenziale tra le diverse entità di sistema.
- Interfaccia Utente (Frontend): * Blade & Tailwind CSS: Per la costruzione di layout dinamici, responsivi e visivamente coerenti, arricchiti da librerie specifiche per la gestione dei form.
- Alpine.js: Per l'implementazione di componenti reattivi "on-page", minimizzando il carico sul browser senza rinunciare a un'interazione fluida.
- Build & Storage: Il workflow di sviluppo è accelerato da Vite, mentre il caricamento e la consultazione dei file scientifici sono gestiti tramite il Filesystem di Laravel, configurato per un'archiviazione sicura nel public storage.

### 🛠️ Tecnologie utilizzate

-   Backend: Laravel (PHP)
-   Autenticazione con Laravel Breeze
-   Gestione delle entità tramite Eloquent ORM e relazioni nel database
-   Tailwind CSS per la stilizzazione
-   Database: MySQL
-   Postman per testare le API
-   Laravel Artisan per gestire la migrazione del database

## Risultato
![homepage](/public/img/results/homePage.png)
![homepage](/public/img/results/home2.png)
![login](/public/img/results/login.png)
![dashboardAdmin](/public/img/results/admin.png)
![new](/public/img/results/new.png)
![publication](/public/img/results/newPublication.png)
![user](/public/img/results/adminNew.png)
![publicationTotal](/public/img/results/publicationAdmin.png)
![userTotal](/public/img/results/teamAdmin.png)
![dashboard](/public/img/results/dashboard.png)