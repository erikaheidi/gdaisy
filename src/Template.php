<?php

namespace GDaisy;

class Template
{
    public string $name;
    public int $width;
    public int $height;
    public string $background;
    public array $sources;
    public array $placeholders = [];
    protected $resource;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    static function create(string $filename): Template
    {
        $template = new Template(basename($filename));
        $template->loadJson($filename);

        return $template;
    }

    public function loadJson(string $json_file)
    {
        $json_content = json_decode(file_get_contents($json_file), true);

        $this->width = $json_content['width'];
        $this->height = $json_content['height'];
        $this->background = $json_content['background'] ?? "FFFFFF";

        foreach ($json_content['elements'] as $key => $element) {
            if ($element['type'] && $element['type'] == "text") {
                $this->addPlaceholder($key,
                    new TextPlaceholder($element['properties']));
                continue;
            }

            $this->addPlaceholder($key,
                new ImagePlaceholder($element['properties']));
        }
    }

    public function addPlaceholder(string $key, PlaceholderInterface $placeholder)
    {
        $this->placeholders[$key] = $placeholder;
    }

    public function getPlaceholder(string $key): ?PlaceholderInterface
    {
        return $this->placeholders[$key] ?? null;
    }

    public function build(array $elements)
    {
        /**
         * @var string $key
         * @var PlaceholderInterface $placeholder
         */
        foreach ($this->placeholders as $key => $placeholder) {
            $placeholder->apply($this->getResource(), $elements[$key]);
        }
    }

    public function write(string $path)
    {
        imagepng($this->getResource(), $path);
    }

    public function apply(string $key, array $params = []): Template
    {
        /** @var PlaceholderInterface $placeholder */
        $placeholder = $this->getPlaceholder($key);

        if ($placeholder) {
            $placeholder->apply($this->getResource(), $params);
        }

        return $this;
    }

    public function getResource()
    {
        if (!$this->resource) {
            $this->resource = imagecreatetruecolor($this->width, $this->height);
            imagefill($this->resource, 0, 0, Util::getColor($this->resource, $this->background));
        }

        return $this->resource;
    }
}