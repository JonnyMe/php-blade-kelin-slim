# php-blade-klein

### Requisiti

- PHP 7
- [Composer](https://getcomposer.org/)

### Installazione

- Clonare il progetto
- Installare le dipendenze tramite `composer install` eseguito nella root del progetto

### Struttura progetto
Di seguito la struttura del progetto, alleggerita dalle cartelle secondarie e non necessarie alla comprensione della struttura.

```
root
|_ config
| |_ config.php
|_ public
|_ resources
| |_ cache
| |_ controllers
| |_ views
|_routes
  |_routes.php
|_ vendor
|_ config.ini
|_ index.php
|_ composer.json
```

#### config.ini
In questo file sono configurate le sezioni (promozioni|occhio-dei-lettori|sondaggi), vengono associate ad una tipologia e successivamente definite con i propri attributi.

#### composer.json
Qui sono definite le dipendenze del progetto, salvate nella cartella `/vendor`. E' un file generato da [**composer**](https://getcomposer.org/).

#### index.php
Questo file include il file di configurazione `/config/config.php` ed il file di routes `/_routes/routes.php`

#### config.php
Qui vengono incluse le dipendenze del progetto e definite costanti e funzioni utili

#### routes.php
Il file di routing fa uso della libreria [**Klein**](https://github.com/klein/klein.php).

Generalmente viene seguito questo flusso:
```
richiesta pagina > mappatura route > esecuzione dei controllers > ritorno di una view
```

#### /resources/controllers
Qui vengono definiti i controllers, inclusi nel file di routes

#### /resources/views
Qui vengono definite le views. Per la gestione delle views è stata usata la libreria [**Blade**](https://github.com/jenssegers/blade).
Maggiore documentazione a riguardo a questo link: [Blade Templates](https://laravel.com/docs/5.1/blade)

#### /public
Qui vengono salvati i file statici relativi alla pagina web.