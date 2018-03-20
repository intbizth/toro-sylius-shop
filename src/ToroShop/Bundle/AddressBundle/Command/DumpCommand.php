<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Command;

use Sylius\Component\Resource\Model\TranslationInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use ToroShop\Bundle\AddressBundle\Model\CountryInterface;
use ToroShop\Bundle\AddressBundle\Model\GeoNameInterface;
use ToroShop\Bundle\AddressBundle\Model\GeoNameTranslationInterface;

final class DumpCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('toro:address:dump');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        if ((bool) $this->getContainer()->get('toro.repository.geo_name')->findOneBy([])) {
            $output->write('<error>You must to cleanup database</error>');

            return;
        }
        $pathData = $this->getContainer()->get('kernel')->locateResource('@ToroAddressBundle/Resources/data/th_geo.yml');
        $data = Yaml::parse(file_get_contents($pathData));

        $this->import($data, GeoNameInterface::TYPE_PROVINCE);
        $this->import($data, GeoNameInterface::TYPE_DISTRICT);
        $this->import($data, GeoNameInterface::TYPE_PARISH);
    }

    private function import(array $data, int $type)
    {
        $data = array_filter($data, function ($arr) use ($type) {
            return (int) $arr['type'] === $type;
        });

        /** @var CountryInterface $country */
        $country = $this->getContainer()->get('toro.repository.country')->findOneByCode('TH') ?? $this->getContainer()->get('toro.factory.country')->createNew();
        $country->setCode('TH');
        $country->setEnabled(true);

        $manager = $this->getContainer()->get('toro.manager.geo_name');
        $manager->persist($country);
        $manager->flush();
        $i = 0;
        foreach ($data as $code => $v) {
            /** @var GeoNameInterface $geoName */
            $geoName = $this->getContainer()->get('toro.factory.geo_name')->createNew();

            $geoName->setCountry($country);
            $geoName->setPostcode('NULL' === $v['postcode'] ? null : $v['postcode']);
            $geoName->setType((int) $v['type']);
            $geoName->setCode($code);

            if ($type !== GeoNameInterface::TYPE_PROVINCE) {
                $parent = $this->getContainer()->get('toro.repository.geo_name')->findOneByCode($v['parent']);
                $geoName->setParent($parent);
            }

            /** @var GeoNameTranslationInterface|TranslationInterface $geoNameTranslation */
            foreach ($v['locales'] as $localeCode => $vv) {
                $geoName->setFallbackLocale($localeCode);
                $geoName->setCurrentLocale($localeCode);
                $geoName->setSlug($vv['slug']);
                $geoName->setGeoName($vv['fullName']);
                $geoName->setName($vv['name']);
            }

            $manager->persist($geoName);

            ++$i;

            if (0 < $i && 0 === $i % 10) {
                echo "$i inserted\n";
                $manager->flush();
            }
        }
    }
}
