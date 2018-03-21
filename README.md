# toro-sylius-shop

0. composer.json
`"intbizth/toro-sylius-shop": "dev-master"`
```
{
   "type": "vcs",
   "url": "https://github.com/intbizth/toro-sylius-shop"
}
```

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

3. Add admin routing
```yaml
toro_admin_sylius_shop:
    resource: "@ToroShopCoreBundle/Resources/config/routing/admin.yml"
```

4. ถ้าทุกคนที่จะ checkout ได้ ต้องเป็น User (Login) ให้ setup ดังนี้
```yaml
# app/config/config.yml
imports:
    - { resource: "@ToroShopCoreBundle/Resources/config/app/not_allow_guest_checkout.yml" }
toro_shop_core:
    guest_checkout: false # default true
```





