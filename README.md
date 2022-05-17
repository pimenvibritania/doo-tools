# Demo: Advice Slip

A demo on how to set up a Composer bin command with Minicli.

Check the tutorial at https://dev.to/erikaheidi/how-to-create-a-composer-bin-command-with-minicli-35ih.

## Run this as a standalone application

```shell
git clone https://github.com/minicli/advice-slip.git
cd advice-slip
composer install
php bin/doo-tools advice
```

## Install this on an existing project

```shell
composer require doo-tools/advice-slip
php vendor/bin/doo-tools advice
```
