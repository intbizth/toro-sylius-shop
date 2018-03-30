<?php

declare(strict_types=1);

namespace ToroShop\Bundle\UiBundle\Twig;

use ToroShop\Bundle\UiBundle\Templating\Helper\TransitionHelperInterface;

class TransitionExtension extends \Twig_Extension
{
    /**
     * @var TransitionHelperInterface
     */
    private $transitionHelper;

    /**
     * @param TransitionHelperInterface $transitionHelper
     */
    public function __construct(TransitionHelperInterface $transitionHelper)
    {
        $this->transitionHelper = $transitionHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $options = array('is_safe' => array('html'));

        return array(
            new \Twig_SimpleFunction('ts_graph_set', array($this->transitionHelper, 'setActiveGraph')),
            new \Twig_SimpleFunction('ts_graph_get', array($this->transitionHelper, 'getActiveGraph')),
            new \Twig_SimpleFunction('ts_graph_states', array($this->transitionHelper, 'getGraphStates')),
            new \Twig_SimpleFunction('ts_possibles', array($this->transitionHelper, 'getPossibleTransitions')),
            new \Twig_SimpleFunction('ts_transition_label', array($this->transitionHelper, 'getTransitionLabel')),
            new \Twig_SimpleFunction('ts_transition_color', array($this->transitionHelper, 'getTransitionColor')),
            new \Twig_SimpleFunction('ts_state_label', array($this->transitionHelper, 'getStateLabel')),
            new \Twig_SimpleFunction('ts_state_color', array($this->transitionHelper, 'getStateColor')),
            new \Twig_SimpleFunction('ts_state_icon', array($this->transitionHelper, 'getStateIcon')),
        );
    }
}
