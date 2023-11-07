## Créer un nouveau CPT

Pour créer un nouveau Custom Post Type il suffit d'utiliser la commande wp-cli associée :

```bash
wp whostarter make:post-type
```

Cela aura pour effet de créer un nouveau fichier dans le dossier `app/Models` qui contiendra la définition du CPT.  
Ensuite il faudra aller register cette nouvelle classe dans le fichier `config/post_types.php` et le CPT sera automatiquement register par le thème.

## Créer une nouvelle Taxonomy

Pour créer une nouvelle Taxonomy il suffit d'utiliser la commande wp-cli associée :

```bash
wp whostarter make:taxonomy
```

Cela aura pour effet de créer un nouveau fichier dans le dossier `app/Models` qui contiendra la définition de la Taxonomy.  
Ensuite il faudra aller register cette nouvelle classe dans le fichier `config/taxonomies.php` et la Taxonomy sera automatiquement register par le thème.

## Créer une nouvelle Page d'Options

Pour créer une nouvelle Page d'Options il suffit d'utiliser la commande wp-cli associée :

```bash
wp whostarter make:options-page
```

Cela aura pour effet de créer un nouveau fichier dans le dossier `app/OptionPages` qui contiendra la définition de la Page d'Options.  
Ensuite il faudra aller register cette nouvelle classe dans le fichier `config/options_pages.php` et la Page d'Options sera automatiquement register par le thème.  

Il est possible de générer une page d'options sans ACF en ajoutant l'option `--acf=false` à la commande. ( true étant la valeur par défaut )

## TODO

Lors des commandes makes avec labels | aller chercher le textdomain du style.css et le remplacer automatiquement dans les fichiers générés

Voir pour installer nativement le .phar && intégration avec npm pour retomber sur la commande cli
exemple : "make:post-type" => "wp-cli.phar whostarter make:post-type",

Checker l'issue avec le parent slug lorsque l'on cite directement le slug d'une autre OptionPage 