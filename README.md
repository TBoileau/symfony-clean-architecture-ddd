# RSE

![GitHub release (latest SemVer)](https://img.shields.io/github/v/release/TBoileau/rse?style=for-the-badge)
![GitHub Release Date](https://img.shields.io/github/release-date/TBoileau/rse?style=for-the-badge)

![GitHub issues](https://img.shields.io/github/issues/TBoileau/rse?style=for-the-badge)
![GitHub closed issues](https://img.shields.io/github/issues-closed/TBoileau/rse?style=for-the-badge)

![GitHub Workflow Status (branch)](https://img.shields.io/github/workflow/status/TBoileau/rse/continuous_integration.yml/develop?style=for-the-badge)
![Codecov branch](https://img.shields.io/codecov/c/github/TBoileau/rse/develop?style=for-the-badge)

## Installation

Dans un premier temps, cloner le repository :
```
git clone https://github.com/TBoileau/rse
cd rse
```

Installer les dépendances et préparer l'environnement de développement :
```
make install db_user=root db_password=password env=dev
```

## Tests
Lancer la suite de tests :
```
make tests
```

## Scénario end-2-end & profiling
Lancer la suite de tests :
```
make profile
```

## Base de données et fixtures
```
make prepare env=dev
```

## Analyse du code
Dans un premier temps, pensez à éxecuter la commande qui permet de nettoyer le code :
```
make fix
```

Lancer les outils d'analyse statique :
```
make analyse
```

## Contribuer
Veuillez prendre un moment pour lire le [guide sur la contribution](CONTRIBUTING.md).

## Changelog
[CHANGELOG.md](CHANGELOG.md) liste tous les changements effectués lors de chaque release.

## À propos
Initialement conçu par [Thomas Boileau](https://github.com/TBoileau). Si vous avez le moindre question, contactez [Thomas Boileau](mailto:t-boileau@email.com?subject=[Github]%20RSA)
