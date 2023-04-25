# Dépot GIT Groupe 42

## Elèves du groupe : 

#### SISR :
* Louis DEPRES
* Johan LARGY

#### SLAM : 
* Gabriel ARNAUD
* Laureline GRAND

## Tuto Git 

#### Git sur le serveur Docker

* Cloner le dépot : `git clone http://docker.sio.lan:3000/u-ap42/ap42.git`
* Ajouter les fichiers : `git add *`
* Mettre un commentaire : `git commit -am "commentaire"`
* Ajouter un tag : `git tag v0.0.x`
* Envoyer les fichiers : `git push`
* Envoyer les tags : `git push --tag`
* Mettre à jour le dépot : `git pull`\
A faire a chaque fois avant de push.

Identifiant : u-ap42\
Mot de passe : ap42-git

#### Git sur le serveur ap42-test

* Cloner le dépot : `git clone http://docker.sio.lan:3000/u-ap42/ap42.git`
* Ajouter les fichiers : `git add *`
* Mettre un commentaire : `git commit -am "commentaire"`
* Ajouter un tag : `git tag v0.0.x`
* Envoyer les fichiers : `git push ap42-test `
* Envoyer les tags : `git push --tag ap42-test `
* Route : `git remote add ap42-test ssh://git@ap42-test:/home/git/web`
* Mettre à jour le dépot : `git pull`\
A faire a chaque fois avant de push.

Identifiant : git\
Mot de passe : git