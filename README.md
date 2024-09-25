# fulll-technical-test

## Algo
- vous pouvez retrouver la partie sur le FizzBuzz

## Backend Step 1

- On retrouve toute la partie Behat avec l'implémentation du context en PHP

=> Problème rencontré avec les Context : J'ai voulu séparer les deux features dans deux contexts différents.
Cependant, même en essayant plusieurs façon, comme un héritage, j'avais des conflits de noms d'actions qui existaient déjà. 
J'ai donc tout mis dans un seul FleetContext.


## Backend Step 2

- J'ai repris les tests Behat et j'ai créé un projet Symfony pour pouvoir créer les Console CLI.

=> Problème rencontré : Essayer de lancer une persistance sur les scénarios avec le tag @critical. J'ai essayé plusieurs solutions pour qu'il fasse le switch dans de la config yaml, mais malheureusement j'ai fini par le gérer dans le FleetContext directement.

=> Pour aller plus loin, j'aurais bien fais plus de tests :

- Rajouter des tests sur les entités en phpunit.
- Tester les consoleCommand avec phpunit aussi.
- Apres les tests behat couvrent déjà une bonne partie, à discuter :)


## Backend Step 3

### For code quality, you can use some tools : which one and why (in a few words) ?

Dans les étapes précédentes, j'ai justement utilisé des outils pour la qualité du code : php code snifer et phpstan
Cela me permet de garantir un formatage de mon code dans les normes et de structurer encore plus le typage de mes propriétés/paramètre/return

### You can consider to setup a ci/cd process : describe the necessary actions in a few words

Je n'ai jamais mis en place de CI/CD directement, mais je connais GitLab CI et GitHub Actions qui permettent de le gérer. On configure généralement un fichier YAML qui définit les étapes : exécuter des images Docker, lancer les tests, vérifier la qualité du code, et orchestrer le déploiement. Ce processus se déclenche automatiquement après chaque push, et les résultats sont visibles via des logs ou notifications. 
