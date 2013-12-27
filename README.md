Contao3: additional_metafields
====================================

Mit dieser Erweiterung kann man Dateien weitere Metadatenfelder hinzufügen. Die Felder werden dazu einfach in der Datei **langconfig.php** definiert. In den Einstellungen kann man dann noch über eine kommagetrennte Liste von Dateitypen die Anzeige der weiteren Felder einschränken. Die zusätzlichen Metadaten können dann in den Elementen **gallery** und **image** ausgegeben und verwendet werden.

### Beispiel für langconfig.php

```php
<?php
// Put your custom configuration here
$GLOBALS['TL_LANG']['additional_metafields']['author'] = 'Autor';
$GLOBALS['TL_LANG']['additional_metafields']['city']   = 'Stadt';
$GLOBALS['TL_LANG']['additional_metafields']['quote']  = 'Zitat';
$GLOBALS['TL_LANG']['additional_metafields']['isbn']   = 'ISBN';
```

### **gallery**: Template mit erweiterten Metadaten 

```html
<ul>
  <?php foreach ($this->body as $class=>$row): ?>
    <?php foreach ($row as $col): ?>
      <?php if ($col->addImage): ?>
        <li class="<?php echo $class; ?> <?php echo $col->class; ?>">
          <figure class="image_container" ...>
            <?php if ($col->href): ?>
              <a href="<?php echo $col->href; ?>" ...><img src="<?php echo $col->src; ?>" ...></a>
            <?php else: ?>
              <img src="<?php echo $col->src; ?>" ...>
            <?php endif; ?>
              <figcaption class="src"><?php echo 'src: '.$col->src; ?></figcaption>
              <figcaption class="singleSRC"><?php echo 'singleSRC: '.$col->singleSRC; ?></figcaption>
              
              <div class="metaData">
                <figcaption class="author"><?php echo $this->metaData[$col->singleSRC][author]; ?></figcaption>
                <figcaption class="city"><?php echo $this->metaData[$col->singleSRC][city]; ?></figcaption>
                <figcaption class="quote"><?php echo $this->metaData[$col->singleSRC][quote]; ?></figcaption>
                <figcaption class="isbn"><?php echo $this->metaData[$col->singleSRC]['isbn']; ?></figcaption>
              </div>
	      
            <?php if ($col->caption): ?>
              <figcaption class="caption" ...><?php echo $col->caption; ?></figcaption>
            <?php endif; ?>
          </figure>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endforeach; ?>
</ul>
```

### **image**: Template mit erweiterten Metadaten 
```html
<div ...>
  <figure class="image_container" ...>
    ...
  </figure>
  <?php var_dump($this->metaData); ?>
</div>
```



