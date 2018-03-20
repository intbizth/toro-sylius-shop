<?php

declare(strict_types=1);

namespace ToroShop\Bundle\AddressBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\TranslatableTrait;

/**
 * @method GeoNameTranslationInterface getTranslation(): GeoNameTranslationInterface
 */
class GeoName implements GeoNameInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var int
     */
    protected $postcode;

    /**
     * @var GeoNameInterface
     */
    protected $root;

    /**
     * @var GeoNameInterface
     */
    protected $parent;

    /**
     * @var Collection|GeoNameInterface[]
     */
    protected $children;

    /**
     * @var int
     */
    protected $left;

    /**
     * @var int
     */
    protected $right;

    /**
     * @var int
     */
    protected $level;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var CountryInterface
     */
    protected $country;

    public function __construct()
    {
        $this->initializeTranslationsCollection();

        $this->children = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getTranslation()->__toString();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): ?string
    {
        if ($this->code) {
            return $this->code;
        }

        if (!$this->country && $this->id) {
            return null;
        }

        return $this->code = sprintf('%s-%s', $this->country->getCode(), $this->id);
    }

    /**
     * {@inheritdoc}
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * {@inheritdoc}
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * {@inheritdoc}
     */
    public function isRoot()
    {
        return null === $this->parent;
    }

    /**
     * @return GeoNameInterface
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(?GeoNameInterface $parent = null)
    {
        $this->parent = $parent;
        if (null !== $parent) {
            $parent->addChild($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParents()
    {
        if (null === $parent = $this->getParent()) {
            return [];
        }

        $parents = [$parent];

        while (null !== $parent->getParent()) {
            $parents[] = $parent = $parent->getParent();
        }

        return $parents;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function hasChild(GeoNameInterface $child)
    {
        return $this->children->contains($child);
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(GeoNameInterface $child)
    {
        if (!$this->hasChild($child)) {
            $this->children->add($child);
        }

        if ($this !== $child->getParent()) {
            $child->setParent($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(GeoNameInterface $child)
    {
        if ($this->hasChild($child)) {
            $child->setParent(null);

            $this->children->removeElement($child);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getTranslation()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->getTranslation()->setName($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getAbbreviation()
    {
        return $this->getTranslation()->getAbbreviation();
    }

    /**
     * {@inheritdoc}
     */
    public function setAbbreviation($abbreviation)
    {
        $this->getTranslation()->setAbbreviation($abbreviation);
    }

    /**
     * {@inheritdoc}
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * {@inheritdoc}
     */
    public function setLeft($left)
    {
        $this->left = $left;
    }

    /**
     * {@inheritdoc}
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * {@inheritdoc}
     */
    public function setRight($right)
    {
        $this->right = $right;
    }

    /**
     * {@inheritdoc}
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * {@inheritdoc}
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * {@inheritdoc}
     */
    public function setCountry(CountryInterface $country = null)
    {
        $this->country = $country;
    }

    /**
     * {@inheritdoc}
     */
    public function isProvince()
    {
        return $this->type === self::TYPE_PROVINCE;
    }

    /**
     * {@inheritdoc}
     */
    public function isDistrict()
    {
        return $this->type === self::TYPE_DISTRICT;
    }

    /**
     * {@inheritdoc}
     */
    public function isParish()
    {
        return $this->type === self::TYPE_PARISH;
    }

    /**
     * {@inheritdoc}
     */
    public function createTranslation()
    {
        return new GeoNameTranslation();
    }

    /**
     * {@inheritdoc}
     */
    public function getGeoName()
    {
        return $this->getTranslation()->getGeoName();
    }

    /**
     * {@inheritdoc}
     */
    public function setGeoName($geoName)
    {
        $this->getTranslation()->setGeoName($geoName);
    }

    /**
     * @deprecated use getGeoAddress
     *
     * {@inheritdoc}
     */
    public function getAddressName()
    {
        return $this->getGeoAddress();
    }

    /**
     * {@inheritdoc}
     */
    public function getGeoAddress()
    {
        $names = array_map('trim', array_reverse(explode(', ', $this->getGeoName())));
        $postcode = null;

        if (is_numeric($names[0])) {
            $postcode = array_shift($names);
            array_push($names, $postcode);
        }

        return implode(', ', $names);
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->getTranslation()->getSlug();
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->getTranslation()->setSlug($slug);
    }
}
