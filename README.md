<p align="center">[![PHP CI](https://github.com/stav86/php-project-48/actions/workflows/PHP%20CI.yml/badge.svg)](https://github.com/stav86/php-project-48/actions/workflows/PHP%20CI.yml) [![Hexlet Checks](https://github.com/stav86/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/stav86/php-project-48/actions)</p>

### SonarQube
<p align="center">[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=stav86_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=stav86_php-project-48) [![Bugs](https://sonarcloud.io/api/project_badges/measure?project=stav86_php-project-48&metric=bugs)](https://sonarcloud.io/summary/new_code?id=stav86_php-project-48) [![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=stav86_php-project-48&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=stav86_php-project-48) [![Coverage](https://sonarcloud.io/api/project_badges/measure?project=stav86_php-project-48&metric=coverage)](https://sonarcloud.io/summary/new_code?id=stav86_php-project-48) [![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=stav86_php-project-48&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=stav86_php-project-48) [![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=stav86_php-project-48&metric=ncloc)](https://sonarcloud.io/summary/new_code?id=stav86_php-project-48) [![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=stav86_php-project-48&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=stav86_php-project-48) [![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=stav86_php-project-48&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=stav86_php-project-48) [![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=stav86_php-project-48&metric=sqale_index)](https://sonarcloud.io/summary/new_code?id=stav86_php-project-48) [![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=stav86_php-project-48&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=stav86_php-project-48) [![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=stav86_php-project-48&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=stav86_php-project-48)</p>

<h1 align="center">Project Difference Calculator</h1>

<h2 align="center">Description</h2>
The difference calculator compares JSON, YAML, YML files, with the ability to output in three different formats: 
* Stylish
* Plain
* Json

# System requirements
* [PHP ver.8.3+](https://www.php.net/downloads.php)
* [Symfony Yaml ver.7+](https://symfony.com/doc/current/components/yaml.html)
* [DocOpt ver.1+](https://docopt.org/)

### Clone the repository
```git@github.com:stav86/php-project-48.git```

### Install dependencies
```make install```

### Run Lint
```make lint```

### Background information
```gendiff -h```

### Run compare files
```bin/gendiff path/to/file1.json path/to/file2.json```

Supported file formats:
* YAML
* YML
* JSON

<h2 align="center">Example of work</h2>

* **#1** - [Comparing Flat Files (JSON)](https://asciinema.org/a/OTwBrGlGAsOexMLsHKpgOWfNj)

* **#2** - [Comparing Flat Files (YAML)](https://asciinema.org/a/vPeP3d4yRy6gL4EIpw81u21Sd)

* **#3** - [Stylish format](https://asciinema.org/a/mi1wgU9JS5S0RygSXuzcgbTek)

* **#4** - [Plain format](https://asciinema.org/a/1cKR6sGCmBtvVpC5rV9OVxqKz)

* **#5** - [Json format](https://asciinema.org/a/OY65SnpM6IHVLRCHLp1GSaHGv)