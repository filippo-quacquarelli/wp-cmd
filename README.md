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

Esempio:
Ovviamente dobbiamo aver installato wp-cli sul nostro sistema, una volta fatto ciò bisogna spostarsi nella cartella di nostro interesse che deve contenere un'installazione di wordpress funzionante ed installare questo plugin.

1. cd /var/www/oldsite.com
2. lanciamo il nostro comando wp-cli personalizzato: wp cmd copy newsite.com --server_path=/var/www

A questo punto wp-cli eseguirà una serie di operazioni specificate sopra, se tutto funziona correttamente il risultato sarà una nuova directory presente in /var/www che ovviamente si chiamerà newsite.com con la nostra installazione di wordpress, il file wp-config.php presente all'interno avrà le stesse credenziali di accesso della directory oldsite.com, tranne per il db_name che sarà "newsite".

Lanciato il comando abbiamo anche già creato il database "newsite" e sostituito le stringhe nel db da oldsite.com a newsite.com, non ci resta che entrare nel backend nel nostro nuovo sito ed aggiornare i permalink.  
