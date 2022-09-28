<?php

namespace GDaisy\Command\Resize;

use GDaisy\Template;
use GDaisy\Util;
use Minicli\Command\CommandController;

class CropController extends CommandController
{
    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        if (!$this->hasParam('size')) {
            throw new \Exception("You must provide a valid 'size' argument such as size=square.");
        }

        $template_file = dirname(__DIR__,3) . '/resources/templates/resize-' . $this->getParam('size') . '.json';

        if (!is_file($template_file)) {
            throw new \Exception("Invalid Size/Template not found.");
        }

        if (!$this->hasParam('input')) {
            throw new \Exception("You must provide an input image as input=full/path/to/image.png");
        }

        $input_file = $this->getParam('input');

        if (!is_file($input_file)) {
            throw new \Exception("Input file not found.");
        }

        if (!$this->hasParam('output')) {
            throw new \Exception("You must provide an output image as output=full/path/to/output.png");
        }


        $template = Template::create($template_file);

        $template->apply("thumbnail", [
            "image_file" => $input_file
        ]);

        $template->write($this->getParam('output'));
        $this->getPrinter()->info("Image saved to " . $this->getParam('output'));
    }
}