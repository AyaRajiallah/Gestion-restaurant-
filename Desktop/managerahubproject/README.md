# ManageraHub Django

Reconstruction du site ManageraHub en Django dans le dossier `managerahubproject`.

## Structure

```text
managerahubproject/
  manage.py
  config/
  accounts/
  templates/
  static/
  db.sqlite3
```

## Prerequis

- Python 3.11 ou plus recent
- Django 5.2 ou compatible

## Lancement

Depuis `C:\Users\pc\Desktop\managerahubproject`, lancez :

```bash
C:\Users\pc\AppData\Local\Programs\Python\Python311\python.exe manage.py migrate
C:\Users\pc\AppData\Local\Programs\Python\Python311\python.exe manage.py runserver
```

Puis ouvrez :

```text
http://127.0.0.1:8000
```

## Fonctionnalites

- page d'accueil moderne
- inscription publique candidat
- connexion candidat / entreprise / admin
- portail avec vue adaptee au role
- timeline verticale du candidat
- reinitialisation de mot de passe
- theme clair / sombre

## Regles metier

- l'inscription publique est reservee au candidat
- la photo de profil est retiree
- les champs entreprise sont retires du signup public
- les comptes entreprise doivent etre crees par l'admin

## Administration

Pour creer un administrateur Django :

```bash
C:\Users\pc\AppData\Local\Programs\Python\Python311\python.exe manage.py createsuperuser
```
