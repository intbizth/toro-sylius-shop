# toro-sylius-shop

composer.json
`"intbizth/toro-sylius-shop": "dev-master"`

1. Register Bundles ที่จำเป็น
```php
   new \BitBag\SyliusCmsPlugin\BitBagSyliusCmsPlugin(),
   new \SitemapPlugin\SitemapPlugin(),
   new \PhpMob\TwigModifyBundle\PhpMobTwigModifyBundle(),
   
   new \Ivory\CKEditorBundle\IvoryCKEditorBundle(),
   new \FM\ElfinderBundle\FMElfinderBundle(),
   new \ToroShop\Bundle\CmsBundle\ToroShopCmsBundle(),

   new \ToroShop\Bundle\AddressBundle\ToroShopAddressBundle(),
   new \ToroShop\Bundle\CurrencyBundle\ToroShopCurrencyBundle(),
   new \ToroShop\Bundle\CoreBundle\ToroShopCoreBundle(),
   
   new \PhpMob\SyliusSettingsPlugin\PhpMobSyliusSettingsPlugin(),
   new \PhpMob\SettingsBundle\PhpMobSettingsBundle(),
```

2. Add config file
```yaml
# app/config/config.yml
imports:
    - { resource: "@ToroShopCoreBundle/Resources/config/app/config.yml" }
# app/config/services.yml
imports:
    - "../../vendor/intbizth/toro-sylius-shop/src/Sylius/sylius_override.yml"
```
