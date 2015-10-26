<?php

namespace nvbooster\StarterBundle\Document;

use Sonata\BlockBundle\Model\BlockInterface;

/**
 * OnePageSection
 *
 * Секция страницы
 *
 * @author nvb <nvb@aproxima.ru>
 */
class OnePageSection extends OnePageItem
{

    /**
     * @var string
     */
    protected $template;

    /**
     * @var BlockInterface
     */
    protected $content;

    /**
     * @var BlockInterface
     */
    protected $block;

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     *
     * @return self
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return BlockInterface
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param BlockInterface $content
     *
     * @return self
     */
    public function setContent(BlockInterface $content = null)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return BlockInterface
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param BlockInterface $block
     *
     * @return self
     */
    public function setBlock(BlockInterface $block = null)
    {
        $this->block = $block;

        return $this;
    }
}