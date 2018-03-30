<?php

declare(strict_types=1);

namespace ToroShop\Bundle\UiBundle\Templating\Helper;

use SM\Factory\Factory;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

class TransitionHelper extends Helper implements TransitionHelperInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * @var array
     */
    private $config = array();

    /**
     * @var array
     */
    private $smConfig = array();

    /**
     * @var string
     */
    private $activeGraph = null;

    public function __construct
    (
        TranslatorInterface $translator,
        Factory $factory,
        array $config = array(),
        array $smConfig = array()
    )
    {
        $this->translator = $translator;
        $this->factory = $factory;
        $this->config = $config;
        $this->smConfig = $smConfig;
    }

    private function checkActiveGraph()
    {
        \Webmozart\Assert\Assert::stringNotEmpty($this->activeGraph, "No active graph.");
    }

    private function getConfigValue($path)
    {
        $this->checkActiveGraph();

        $accessor = PropertyAccess::createPropertyAccessorBuilder()
            ->disableExceptionOnInvalidIndex()
            ->getPropertyAccessor()
        ;

        return $accessor->getValue($this->config, $path);
    }

    /**
     * @param string $graph
     */
    public function setActiveGraph($graph)
    {
        $this->activeGraph = $graph;
    }

    public function getActiveGraph()
    {
        return $this->activeGraph;
    }

    public function getNAColor()
    {
        return $this->config['colors']['na'];
    }

    public function getInfoIcon()
    {
        return $this->config['icon']['info'];
    }

    public function getNegativeColor()
    {
        return $this->config['colors']['negative'];
    }

    public function getPositiveColor()
    {
        return $this->config['colors']['positive'];
    }

    public function getLabel($type, $key)
    {
        $this->checkActiveGraph();

        $translationKey = $this->getConfigValue(
            sprintf('[graphs][%s][%s][%s][translation][key]', $this->activeGraph, $type, $key)
        ) ?: $key;

        $translationDomain = $this->getConfigValue(
            sprintf('[graphs][%s][%s][%s][translation][domain]', $this->activeGraph, $type, $key)
        );

        return $this->translator->trans($translationKey, [], $translationDomain);
    }

    public function getTransitionLabel($transition)
    {
        return $this->getLabel('transitions', $transition);
    }

    public function getStateLabel($state)
    {
        return $this->getLabel('states', $state);
    }

    public function getColor($type, $key)
    {
        return $this->getConfigValue(
            sprintf('[graphs][%s][%s][%s][color]', $this->activeGraph, $type, $key)
        ) ?: $this->getNAColor();
    }

    public function getIcon($type, $key)
    {
        return $this->getConfigValue(
            sprintf('[graphs][%s][%s][%s][icon]', $this->activeGraph, $type, $key)
        ) ?: $this->getInfoIcon();
    }

    public function getStateColor($state)
    {
        return $this->getColor('states', $state);
    }

    public function getTransitionColor($transition)
    {
        return $this->getColor('transitions', $transition);
    }

    public function getStateIcon($state)
    {
        return $this->getIcon('states', $state);
    }

    public function getPossibleTransitions($object)
    {
        $transitions = [];
        $sm = $this->factory->get($object, $this->activeGraph);

        foreach ($sm->getPossibleTransitions() as $name) {
            $transitions[$name] = array(
                'name' => $name,
                'graph' => $this->activeGraph,
                'color' => $this->getTransitionColor($name),
                'label' => $this->getTransitionLabel($name),
            );
        }

        return $transitions;
    }

    public function getGraphStates()
    {
        $this->checkActiveGraph();

        $states = $this->smConfig[$this->activeGraph]['states'];
        $return = array();

        foreach ($states as $state) {
            $return[] = array(
                'name' => $state,
                'label' => $this->getStateLabel($state),
                'color' => $this->getStateColor($state),
            );
        }

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'toro_transitions';
    }
}
