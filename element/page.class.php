<?php

/**
 * Page
 * @author Gareth Flowers (gareth@garethflowers.com)
 * @version 0.1
 */
class Page
{

    protected $head;
    private $body;
    private $header;
    private $footer;

    /**
     * create new instance of the Page class
     * @param string $template
     */
    public function __construct( $template = null )
    {
        $this->head = new Head();
        $this->body = new Element( 'content' );
        $this->footer = new Element( 'footer' );
        $this->header = new Element( 'header' );
    }

    /**
     * add content to the page header
     * @param string $content
     */
    public function addHeader( $content )
    {
        $this->header->addContent( $content );
    }

    /**
     * add content to the page footer
     * @param string $content
     */
    public function addFooter( $content )
    {
        $this->footer->addContent( $content );
    }

    /**
     * add content to the page footer
     * @param string $content
     */
    public function addBody( $content )
    {
        $this->body->addContent( $content );
    }

    /**
     * set the page title
     * @param string $title
     */
    public function setTitle( $title )
    {
        $this->head->setTitle( $title );
    }

    /**
     * set the document description
     * @param string $description
     */
    public function setDescription( $description )
    {
        $this->head->setDescription( $description );
    }

    /**
     * add a keyword to the page header
     * @param string $word
     */
    public function addKeyword( $word )
    {
        $this->head->addKeyword( $word );
    }

    /**
     * render the page a a complete html document
     * @return string
     */
    public function render()
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html lang="en">';

        $html .= $this->head->render();

        $html .= '<body>';

        $html .= $this->header->render();

        $html .= $this->body->render();

        $html .= $this->footer->render();

        $html .= '</body>';
        $html .= '</html>';

        return $html;
    }

}

?>