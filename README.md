# Auto CEP
 ![Release Version](https://img.shields.io/github/v/release/live-controls/autocep)
 ![Packagist Version](https://img.shields.io/packagist/v/live-controls/autocep?color=%23007500)

 An Input for CEP which would give you the informations for road, etc. based on CepAberto

## Requirements
- Laravel 9+
- JetStream
- Livewire 2+
- Fortify
- [JetStrap](https://github.com/nascent-africa/jetstrap)


## Translations
- English (en)
- German (de)
- Brazilian Portuguese (pt_BR)


## Installation

1. Install Utils package
```ps 
composer require live-controls/utils
```
2. Install AutoCep package
```ps
composer require live-controls/autocep
```


### Content
- GetCEP class
- AutoCep input - @livewire('livecontrols-autocep')


## Usage
First Step:
You will need to create a CEPABERTO_TOKEN environment variable. You will get the token after registration from https://www.cepaberto.com/

Blade:
```php
@livewire('livecontrols-autocep', [
'prefix' => 'student',
'titlesuffix' => '*',
'oldmodel' => $student,
'required' => true,
], key('autocep'))
```
* prefix = The prefix is optional, but needed if you add more than one AutoCep component on a single page. It will be prefix_road etc. afterwards
* titlesuffix = The suffix of the title, usually you'd set a * if they're required or such.
* oldmodel = This is optional, if set, it will take the cep, street, bairro, uf and city of the model
* required = If set to true it will set all inputs to "required"

**Important: In case you want to use more than one AutoCEP component, don't forget to add a "prefix" so the informations won't be overwritten!**