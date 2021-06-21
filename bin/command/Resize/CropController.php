<?php

namespace GDaisy\Command\Resize;

use GDaisy\Template;
use GDaisy\Util;
use Minicli\Command\CommandController;

class CropController extends CommandController
{
    public function handle()
    {
        if (!$this->hasParam('size')) {
            $this->getPrinter()->error("You must provide a valid 'size' argument such as size=square.");
            return 1;
        }

        $template_file = dirname(__DIR__,3) . '/resources/templates/resize-' . $this->getParam('size') . '.json';

        if (!is_file($template_file)) {
            $this->getPrinter()->error("Invalid Size/Template not found.");
            return 1;
        }

        if (!$this->hasParam('input')) {
            $this->getPrinter()->error("You must provide an input image as input=full/path/to/image.png");
            return 1;
        }

        $input_file = $this->getParam('input');

        if (!is_file($input_file)) {
            $this->getPrinter()->error("Input file not found.");
            return 1;
        }

        if (!$this->hasParam('output')) {
            $this->getPrinter()->error("You must provide an output image as output=full/path/to/output.png");
            return 1;
        }


        $template = Template::create($template_file);

        $template->apply("thumbnail", [
            "image_file" => $input_file
        ]);

        $template->write($this->getParam('output'));
        $this->getPrinter()->info("Image saved to " . $this->getParam('output'));

        return 0;
    }
}