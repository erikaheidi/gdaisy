<?php

namespace GDaisy\Command\Generate;

use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
    public function handle()
    {
        $this->getPrinter()->out("To generate a new cover based on the default template:");
        $this->getPrinter()->info("gdaisy generate cover [cover-url] [output-path]");
    }

}