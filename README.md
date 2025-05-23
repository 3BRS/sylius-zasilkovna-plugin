<p align="center">
    <a href="https://www.3brs.com" target="_blank">
        <img src="https://3brs1.fra1.cdn.digitaloceanspaces.com/3brs/logo/3BRS-logo-sylius-200.png"/>
    </a>
</p>
<h1 align="center">
    Zásilkovna Plugin
    <br />
    <a href="https://packagist.org/packages/3brs/sylius-zasilkovna-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/3brs/sylius-zasilkovna-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/3brs/sylius-zasilkovna-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/3brs/sylius-zasilkovna-plugin.svg" />
    </a>
    <a href="https://circleci.com/gh/3BRS/sylius-zasilkovna-plugin" title="Build status" target="_blank">
        <img src="https://circleci.com/gh/3BRS/sylius-zasilkovna-plugin.svg?style=shield" />
    </a>
</h1>

<p align="center">
	<a href="https://www.zasilkovna.cz"><img src="https://raw.githubusercontent.com/3BRS/sylius-zasilkovna-plugin/master/doc/logo.png" alt="Zásilkovna / Zásielkovňa / Csomagküldő / Przesyłkownia / Coletăria"/></a>
</p>

## Features

 - Enables sending shipments via [<a href="https://www.zasilkovna.cz">cz</a>] [<a href="https://www.przesylkownia.pl">pl</a>] [<a href="https://www.zasielkovna.sk">sk</a>] [<a href="https://www.csomagkuldo.hu">hu</a>] [<a href="https://www.coletaria.ro">ro</a>] to Zasilkovna branch or to the customer's address via Zasilkovna service.
 - The user can choose the Zásilkovna branch from the map during checkout in the Shipment step.
 - See Zásilkovna branch in final checkout step and also in the admin panel.
 - Export CSV with the Zásilkovna shipments (both to Zasilkovna branch or customer's address) and import it easily into Zásilkovna's system.

<p align="center">
	<img src="https://raw.githubusercontent.com/3BRS/sylius-zasilkovna-plugin/master/doc/admin_order_detail.png"/>
</p>
<p align="center">
	<img src="https://raw.githubusercontent.com/3BRS/sylius-zasilkovna-plugin/master/doc/admin_shipping_method_edit.png"/>
</p>
<p align="center">
	<img src="https://raw.githubusercontent.com/3BRS/sylius-zasilkovna-plugin/master/doc/shop_shipment_step.png"/>
</p>
<p align="center">
	<img src="https://raw.githubusercontent.com/3BRS/sylius-zasilkovna-plugin/master/doc/shop_checkout_complete.png"/>
</p>

## Installation

1. Run `composer require 3brs/sylius-zasilkovna-plugin`.
1. Add plugin classes to your `config/bundles.php`:
 
   ```php
   return [
      ...
      ThreeBRS\ShipmentExportPlugin\ThreeBRSSyliusShipmentExportPlugin::class => ['all' => true],
      ThreeBRS\SyliusZasilkovnaPlugin\ThreeBRSSyliusZasilkovnaPlugin::class => ['all' => true],
   ];
   ```
  
1. Use plugin configuration by creating `config/packages/threebrs_sylius_zasilkovna_plugin.yaml` with content

    ```yaml
    imports:
         - { resource: "@ThreeBRSSyliusZasilkovnaPlugin/Resources/config/config.{yml,yaml}" }
    ```
   
1. Add routing to `config/routes.yaml`

    ```yaml
    threebrs_sylius_shipment_export_plugin:
        resource: "@ThreeBRSSyliusShipmentExportPlugin/config/admin_routing.{yml,yaml}"
        prefix: /admin
    ```
   
1. Your Entity `Shipment` has to implement `\ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface`. 
   You can use the trait `\ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentTrait`.
 
   ```php
   <?php 
   
   declare(strict_types=1);
   
   namespace App\Entity\Shipping;
   
   use Doctrine\ORM\Mapping as ORM;
   use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface;
   use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentTrait;
   use Sylius\Component\Core\Model\Shipment as BaseShipment;
   
   #[ORM\Entity]
   #[ORM\Table(name: 'sylius_shipment')]
   class Shipment extends BaseShipment implements ZasilkovnaShipmentInterface
   {
       use ZasilkovnaShipmentTrait;
   }
   ```
   
1. Your Entity `ShippingMethod` has to implement `\ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentInterface`. 
   You can use the trait `\ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShipmentTrait`.
 
   ```php
   <?php 
   
   declare(strict_types=1);
   
   namespace App\Entity\Shipping;
   
   use Doctrine\ORM\Mapping as ORM;
   use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodInterface;
   use ThreeBRS\SyliusZasilkovnaPlugin\Model\ZasilkovnaShippingMethodTrait;
   use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;
   
   #[ORM\Entity]
   #[ORM\Table(name: 'sylius_shipping_method')]
   class ShippingMethod extends BaseShippingMethod implements ZasilkovnaShippingMethodInterface
   {
       use ZasilkovnaShippingMethodTrait;
   }
   ```

1. Override the template in `@ThreeBRSSyliusShipmentExportPlugin/_row.html.twig`
    ```twig
   {% extends '@!ThreeBRSSyliusShipmentExportPlugin/_row.html.twig' %}
   
   {% block address %}
       {% if row.zasilkovna %}
            {{ include('@ThreeBRSSyliusZasilkovnaPlugin/_exporterRow.html.twig') }}
       {% else %}
           {{ parent() }}
       {% endif %}
   {% endblock %}
    ```

1. Create and run doctrine database migrations.

For the guide how to use your own entity see [Sylius docs - Customizing Models](https://docs.sylius.com/en/1.6/customization/model.html)

## Usage

* For delivery to the Zasilkovna branch, create new shipping method in the admin panel, set `Zásilkovna api key` and leave `Carrier ID` empty.
* For delivery to customer's address, create new shipping method in the admin panel, set the `Carrier ID` and leave the `Zasilkovna API key` empty.
* If you need to filter the points in the map by country, use the `Show only pickup points from specific country in the map`. If you leave this blank, all points in all supported countries will be shown.
* Zásilkovna CSV export will be generated for shipping method which has the code 'zasilkovna', you can change this in parameters, it is an array (therefore can contain more codes, e.g. if you need to have different prices for different countries, you will need more shipping methods; it is okay to use always the same API key) 
  ```yaml
  parameters:
      shippingMethodsCodes: ['zasilkovna']
  ```
  You should add to this array both methods for shipping to Zasilkovna branch and also to customer's address via Zasilkovna service.
* Packeta API documentation: https://docs.packeta.com/docs/getting-started/client-section-imports#csv-import
* You can expand the list of countries by the parameter
  ```yaml
  parameters:
    threebrs_sylius_zasilkovna_plugin_payment_methods: ['cz', 'pl', 'sk', 'hu', 'ro']
  ```

## Development

### Usage

- Develop your plugin in `/src`
- See [`bin/`](./bin) for useful commands

### Testing


After your changes you must ensure that the tests are still passing.

```bash
make ci
```

License
-------
This library is under the MIT license.

Credits
-------
Developed by [3BRS](https://3brs.com)<br>
Forked from [manGoweb](https://github.com/mangoweb-sylius/SyliusZasilkovnaPlugin).
