# wp-cmd
* Non ancora pronto per la produzione, solo a scopo di test

Un plugin per wordpress super semplice che sfrutta le api di wp-cli, in questa prima implementazione è possibile copiare una folder contenente un sito wordpress in una nuova cartella.

E' richiesta l'installazione di wp-cli su un sistema operativo linux ( testato su ubuntu ), è sufficiente sopostarsi all'interno della directory contenente l'installazione di wordpress che si vuole copiare.

Esempio di utilizzo:

1. cd var/www/.../directorywp.com/
2. wp install copy directorywp-dev.com
3. Godere :)

il plugin esegue le seguenti operazioni:

1. Esportazione db vecchio sito
2. Copia della cartella dove viene eseguito lo script
3. Creazione nuovo wp-config con le nuove credenziali, da inserire nel file php
4. Importazione vecchio db sul nuovo sito
5. Sostituzione stringhe nel db appena importato da vecchio dominio a nuovo
6. Aggiornamento permalink
