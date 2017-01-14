# wp-cmd

Un plugin per wordpress super semplice che sfrutta le api di wp-cli, in questa prima implementazione è possibile copiare velocemente un sito wordpress.

E' richiesta l'installazione di wp-cli su un sistema operativo linux ( testato su ubuntu ), è sufficiente sopostarsi all'interno della directory contenente l'installazione di wordpress che si vuole copiare.

Esempio di utilizzo:

1. cd var/www/.../directorywp.com/
2. wp cmd copy directorywp-dev.com --server_path=/var/www

Il flag --server_path è obbligatorio e serve a specificare il percorso della directory che contiene le nostre installazioni di wordpress, abbiamo a disposizione anche i seguenti flag --db_name, --db_user e --db_pass per specificare il valore delle costanti per la connessione al database presenti nel wp-config.php del nostro nuovo sito.

Il plugin esegue le seguenti operazioni:

1. Esportazione db vecchio sito
2. Copia della cartella dove viene eseguito lo script
3. Creazione nuovo wp-config con le nuove credenziali
4. Importazione vecchio db sul nuovo sito
5. Sostituzione stringhe nel db appena importato da vecchio dominio a nuovo
