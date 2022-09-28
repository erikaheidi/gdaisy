<?php

namespace GDaisy\Command\Resize;

use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle(): void
    {
        $this->getPrinter()->out("To create a cropped thumbnail:");
        $this->getPrinter()->info("gdaisy resize crop size=[format] input=[input-path] output=[output-path]");
        $this->getPrinter()->out("Sizes defined in resources/templates/resize-*.json. Current options: square, avatar, 480p, 720p, 1080p, 1440p");
        $this->getPrinter()->newline();
    }

}