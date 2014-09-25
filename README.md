Contao3: additional_metafields
====================================

Mit dieser Erweiterung kann man Dateien weitere Metadatenfelder hinzufügen. Die Felder könne einfach über einen Menüpunkt im Backend definiert werden.  
Die zusätzlichen Metadaten können dann in den Elementen **gallery** und **image** ausgegeben und verwendet werden.

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
                <figcaption class="author"><?php echo $this->metadata[$col->singleSRC][author]; ?></figcaption>
                <figcaption class="city"><?php echo $this->metadata[$col->singleSRC][city]; ?></figcaption>
                <figcaption class="quote"><?php echo $this->metadata[$col->singleSRC][quote]; ?></figcaption>
                <figcaption class="isbn"><?php echo $this->metadata[$col->singleSRC]['isbn']; ?></figcaption>
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

Für die Inhaltselemente **Text** und **Akkordeon** (Einzelelement) funktioniert die Ausgabe der Metadaten ebenfalls.

```html
<div ...>
  <figure class="image_container" ...>
    ...
  </figure>
  <?php var_dump($this->metadata); ?>
</div>
```



