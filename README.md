# wp-cmd

Un plugin per wordpress super semplice che sfrutta le api di wp-cli, in questa prima implementazione è possibile copiare velocemente un sito wordpress.

E' richiesta l'installazione di wp-cli, il plugin è stato testato su Ubuntu linux, è sufficiente sopostarsi all'interno della directory contenente l'installazione di wordpress che si vuole copiare.

Esempio di utilizzo:

1. cd var/www/.../directorywp.com/
2. wp cmd copy directorywp-dev.com --server_path=/var/www

Il primo parametro dopo copy è il nome della nostra nuova directory, per funzionare correttamente bisogna seguire una convenzione di denominazione è infatti obbligatorio inserire il nome di dominio in questo formato nomedominio.topleveldomain per esempio newsite.com e non dev.newsite.com

Il flag --server_path è obbligatorio e serve a specificare il percorso della directory che contiene le nostre installazioni di wordpress, abbiamo a disposizione anche i seguenti flag --db_name, --db_user e --db_pass per specificare il valore delle costanti per la connessione al database presenti nel wp-config.php del nostro nuovo sito.

Se il --db_pass ecc ecc non vengono specificati vengono usate le credenziali di accesso al db dell'installazione di wordpress copiata, tranne per il --db_name di default infatti assume il valore del nome di directory senza il topleveldomain, per esempio per il sito newsite.com il db_name sarà newsite ed ovviamente anche il nuovo database creato si chiamerà newsite.

Il plugin esegue le seguenti operazioni:

1. Esportazione db vecchio sito
2. Copia della cartella dove viene eseguito lo script
3. Creazione nuovo wp-config con le nuove credenziali
4. Importazione vecchio db sul nuovo sito
5. Sostituzione stringhe nel db appena importato da vecchio dominio a nuovo
