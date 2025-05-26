# CHANGELOG

## v4.0.0 (2025-06-10)
- Support for Sylius 2.0, Symfony ^7.1
- Drop support for Sylius 1, PHP 8.1
- ⚠️ BC Rename for Composer from `3brs/sylius-zasilkovna-plugin` to `3brs/sylius-packeta-plugin` and rename all classes, namespaces and configurations accordingly, see [UPGRADE-2.0.md](UPGRADE-2.0.md)

## v3.3.0 (2025-04-08)
- Support for Sylius 1.14
- Drop support for Symfony <=6.3

## v3.2.0 (2025-02-09)
- Support for Sylius 1.12, 1.13, Symfony ^6.0
- Drop support for Sylius 1.11, Symfony 5.4

## v3.1.0 (2025-02-09)
- Support for Sylius 1.11, Symfony 5.4
- Drop support for Sylius <1.11, Symfony <5.4

## v3.0.0 (2021-10-05)

#### Details

- Support for Sylius 1.8|1.9|1.10, Symfony ^4.4|^5.2, PHP ^7.3|^8.0
- Change namespace from `MangoSylius\SyliusZasilkovnaPlugin` to `ThreeBRS\SyliusZasilkovnaPlugin`
- Change table name from `mango_zasilkovna_config` to `threebrs_zasilkovna_config`
- *BC break: Version 3.0.0 is NOT compatible with previous versions due to namespace change*

## v2.1 (2020-03-25)

#### Details

- Update to Sylius ^1.7, PHP ^7.3

## v2.0 (2020-02-20)

#### Details

- Choose Zasilkovna branch on a map in checkout
- Use Zasilkovna service also for delivery to the customer's address
- Prefill Sender label (optional) in the CSV export
- *BC break: Version 2.0 is NOT compatible with previous versions*

## v1.2 (2020-02-11)

#### Details

- Fixup export CSV

## v1.1 (2020-02-11)

#### Details

- Fixup export CSV
