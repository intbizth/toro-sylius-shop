# AddressBundle

`AppKernel.php`

```php
public function registerBundles()
{
    $bundles = [
        ...
        new \ToroShop\Bundle\AddressBundle\ToroAddressBundle(),
        ...
    ];
}
```

### Add routing
```yaml
sylius_admin_toro_geo:
    resource: "@ToroAddressBundle/Resources/config/route/sylius_admin.yml"
sylius_admin_toro_geo_filter:
    resource: "@ToroAddressBundle/Resources/config/route/sylius_admin_filter.yml"
```

### Add config
```yaml
imports:
    - { resource: "@ToroAddressBundle/Resources/config/app/config.yml" } # อันนี้ต้องมี
    - { resource: "@ToroAddressBundle/Resources/config/app/sylius_override.yml" } # อันนี้ใช้กับ sylius
```

### Add sylius grid `link` template
```yaml
sylius_grid:
    templates:
        action:
            link: "@SyliusAdmin/Grid/Action/link.html.twig" # ต้องมี
 ```
 
 
### Command
`$ php bin/console toro:address:dump`
ใช้ในการ dump ข้อมูล จังหวัด เขต แขวง 
> แนะนำว่า ทำแค่ครั้งแรก ครั้งต่อๆไป ควร export/import database เอา เพราะนานมากๆ 


## Form types
#### Autocomplete
1. `GeoAjaxSelectizeChoiceType`
อันนี้ใช้ร่วมกับ `selectize.js`
 
2. `Sylius/GeoAutocompleteType` (Autocomplete)
อันนี้ใช้สำหรับ backend sylius

#### Choice
1. `GeoChoiceType`
อันนี้ใช้ render choice ที่เป็น เขต และแขวง

2. `GeoProviceChoiceType`
อันนี้ใช้ render choice ที่เป็น จังหวัด
