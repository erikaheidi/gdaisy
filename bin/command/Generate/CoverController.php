<?php

namespace GDaisy\Command\Generate;

use Minicli\Command\CommandController;
use GDaisy\Template;
use GDaisy\Util;

class CoverController extends CommandController
{
    public function handle()
    {
        $template_file = $this->getApp()->config->default_template;

        if ($this->hasParam('template')) {
            $template_file = $this->getParam('template');
        }

        if (!is_file($template_file)) {
            $this->getPrinter()->error("Template not found.");
            return 1;
        }

        if (!isset($this->getArgs()[3])) {
            $this->getPrinter()->error("You must provide the URL as second parameter.");
            return 1;
        }

        if (!isset($this->getArgs()[4])) {
            $this->getPrinter()->error("You must provide the Output location as third parameter.");
            return 1;
        }

        $template = Template::create($template_file);

        $url = $this->getArgs()[3];
        $dest = $this->getArgs()[4];

        $tags = get_meta_tags($url);

        $image_file = dirname(__DIR__, 3) . '/resources/images/gdaisy.png';
        $image_url = $tags['twitter:image'] ?? $tags['twitter:image:src'] ?? null;
        if ($image_url) {
            $image_file = Util::downloadImage($image_url);
        }

        $title = $tags['twitter:title'] ?? $this->get_page_title($url) ?? 'Gdaisy';
        $description = $tags['twitter:description'] ?? $tags['description'] ?? 'Generated with erikaheidi/gdaisy';

        $template->apply("title", [
            "text" => html_entity_decode($title, ENT_QUOTES)
        ])->apply("description", [
            "text" => html_entity_decode($description . '...', ENT_QUOTES)
        ])->apply("thumbnail", [
            "image_file" => $image_file
        ]);

        $template->write($dest);
        $this->getPrinter()->info("Image saved to $dest.");

        return 0;
    }

    function get_page_title(string $url) {
        $dom = new \DOMDocument();

        if(@$dom->loadHTMLFile($url)) {
            $list = $dom->getElementsByTagName("title");
            if ($list->length > 0) {
                return $list->item(0)->textContent;
            }
        }

        return null;
    }
}