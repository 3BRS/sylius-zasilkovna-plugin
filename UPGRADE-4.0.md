# UPGRADE FROM `3.3.0` TO `4.0.0`

1. replace requirement in `composer.json`:
   - from
     ```json
     "threebrs/sylius-zasilkovna-plugin": "^3.3"
     ```
   - to
     ```json
     "threebrs/sylius-packeta-plugin": "^4.0"
     ```

1. replace every occurence of `SyliusZasilkovnaPlugin` to `SyliusPacketaPlugin`
    - for example
      ```yaml
      imports:
          - { resource: "@ThreeBRSSyliusPacketaPlugin/Resources/config/config.{yml,yaml}" }
      ```

1. replace `ThreeBRS\SyliusZasilkovnaPlugin\ThreeBRSSyliusZasilkovnaPlugin::class` to
   `ThreeBRS\SyliusPacketaPlugin\ThreeBRSSyliusPacketaPlugin::class` in `config/bundles.php`

1. replace class names in your code:
  - `ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface` to `ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentTrait`
  - `ThreeBRS\SyliusPacketaPlugin\Model\PacketaShipmentInterface` to `ThreeBRS\SyliusPacketaPlugin\Model\PacketaShipmentTrait`
  - `ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodInterface` to `ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodTrait`
  - `ThreeBRS\SyliusPacketaPlugin\Model\PacketaShippingMethodInterface` to 
  `ThreeBRS\SyliusPacketaPlugin\Model\PacketaShippingMethodTrait`

1. create SQL migration to rename related table and columns

#### MySQL
```mysql
-- MySQL
RENAME TABLE threebrs_zasilkovna_config TO threebrs_packeta_config;
-- PostgreSQL
-- ALTER TABLE threebrs_zasilkovna_config RENAME TO threebrs_packeta_config;

ALTER TABLE sylius_shipment RENAME COLUMN zasilkovna TO packeta;
ALTER TABLE sylius_shipping_method RENAME COLUMN zasilkovna_config TO packeta_config;
```
- hint: you can also configure your entities to keep using legacy table name and column names

Note: the `@ThreeBRSSyliusZasilkovnaPlugin/Admin/Common/Order/_addresses.html.twig` has been removed. All GUI changes are made by Sylius Twig hooks, see [twig_hooks.yaml](./src/Resources/config/twig_hooks/twig_hooks.yaml)
