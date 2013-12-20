Contao3: additional_metafields
====================================

Mit dieser Erweiterung kann man Dateien weitere Metadatenfelder hinzufügen.
Die Felder werden dazu einfach in der Datei langconfig.php definiert.

In den Einstellungen kann man dann noch über eine Kommagetrennte Liste von Dateitypen
die Anzeige der weiteren Felder einschränken.

Die zusätzlichen Metadaten können dann in den Elementen gallery und image ausgegeben und verwendet werden.


Beispiel für ein Template mit erweiterten Metadaten

Beispiel für langconfig.php
<?php

// Put your custom configuration here
$GLOBALS['TL_LANG']['additional_metafields']['author'] = 'Autor';
$GLOBALS['TL_LANG']['additional_metafields']['city']   = 'Stadt';
$GLOBALS['TL_LANG']['additional_metafields']['quote']  = 'Zitat';
$GLOBALS['TL_LANG']['additional_metafields']['isbn']   = 'ISBN';

if ($GLOBALS['TL_LANGUAGE'] === 'en') {
	$GLOBALS['TL_LANG']['additional_metafields']['author'] = 'Author';
	$GLOBALS['TL_LANG']['additional_metafields']['city']   = 'City';
	$GLOBALS['TL_LANG']['additional_metafields']['quote']  = 'Quote';
	$GLOBALS['TL_LANG']['additional_metafields']['isbn']   = 'ISBN';
}

