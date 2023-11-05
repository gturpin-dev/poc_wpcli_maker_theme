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